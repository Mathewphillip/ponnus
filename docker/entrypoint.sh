#!/bin/sh
set -e

echo "==> [Ponnus Startup] Initializing application for Render Free Tier..."

# Normalize Neon DB_HOST / DB_URL: strip '-pooler' to use direct connection for DDL / migrations
if [ -n "$DB_HOST" ]; then
    DB_HOST=$(echo "$DB_HOST" | sed 's/-pooler//')
    export DB_HOST
    echo "==> [Ponnus Startup] Active DB_HOST: ${DB_HOST}"
fi
if [ -n "$DB_URL" ]; then
    DB_URL=$(echo "$DB_URL" | sed 's/-pooler//')
    export DB_URL
fi
if [ -n "$DATABASE_URL" ]; then
    DATABASE_URL=$(echo "$DATABASE_URL" | sed 's/-pooler//')
    export DATABASE_URL
fi

# 1. Configure Port for Nginx (Render sets $PORT dynamically, default to 10000)
export PORT="${PORT:-10000}"
echo "==> [Ponnus Startup] Configuring Nginx to listen on port ${PORT}..."
envsubst '${PORT}' < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf

# 2. Ensure Required Storage and Cache Directories Exist with Correct Permissions
mkdir -p \
    /var/www/html/storage/app/public \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 3. Create public storage symlink if missing
if [ ! -L /var/www/html/public/storage ]; then
    echo "==> [Ponnus Startup] Creating storage symlink..."
    php artisan storage:link || true
fi

# Ensure valid APP_KEY exists
if [ -z "$APP_KEY" ] || ! php -r '
    $k = getenv("APP_KEY");
    if (str_starts_with($k, "base64:")) { $k = base64_decode(substr($k, 7)); }
    exit(strlen($k) === 32 ? 0 : 1);
' 2>/dev/null; then
    echo "==> [Ponnus Startup] APP_KEY is missing or invalid. Auto-generating production key..."
    export APP_KEY=$(php artisan key:generate --show)
    echo "==> [Ponnus Startup] Generated APP_KEY: ${APP_KEY}"
fi

export LOG_CHANNEL="${LOG_CHANNEL:-stderr}"
export AUTORUN_SEEDERS="${AUTORUN_SEEDERS:-true}"

# 4. Optimize Laravel for Production
echo "==> [Ponnus Startup] Caching configuration, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Database Connection Check & Safe Migrations
if [ -n "$DB_HOST" ] || [ -n "$DB_URL" ] || [ -n "$DATABASE_URL" ]; then
    echo "==> [Ponnus Startup] Checking database connection (${DB_CONNECTION:-mysql})..."
    MAX_TRIES=15
    COUNT=0
    until php -r '
        require __DIR__ . "/vendor/autoload.php";
        $app = require_once __DIR__ . "/bootstrap/app.php";
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        try {
            Illuminate\Support\Facades\DB::connection()->getPdo();
            exit(0);
        } catch (\Throwable $e) {
            fwrite(STDERR, $e->getMessage() . PHP_EOL);
            exit(1);
        }
    ' 2>/dev/null || [ $COUNT -ge $MAX_TRIES ]; do
        COUNT=$((COUNT + 1))
        echo "    Waiting for database ($COUNT/$MAX_TRIES)..."
        sleep 2
    done

    if [ $COUNT -lt $MAX_TRIES ]; then
        echo "==> [Ponnus Startup] Database connection established!"
        echo "==> [Ponnus Startup] Running safe database migrations (migrate --force)..."
        if php artisan migrate --force; then
            echo "==> [Ponnus Startup] Migrations completed successfully!"
            # Optional: Run seeders if AUTORUN_SEEDERS is set to true
            if [ "$AUTORUN_SEEDERS" = "true" ] || [ "$AUTORUN_SEEDERS" = "1" ]; then
                echo "==> [Ponnus Startup] Seeding demo accounts and dishes (db:seed --force)..."
                php artisan db:seed --force || echo "==> [Ponnus Startup] Seeding notice: seed completed with notice."
            fi
        else
            echo "==> [Ponnus Startup] WARNING: Migration command exited with warning. Web service will continue running."
        fi
    else
        echo "==> [Ponnus Startup] WARNING: Database connection timed out. Skipping migrations on startup."
        echo "    Check DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD in Render dashboard."
    fi
else
    echo "==> [Ponnus Startup] No DB_HOST or DB_URL provided; skipping database migration step."
fi

echo "==> [Ponnus Startup] Startup sequence complete! Launching web server..."
exec "$@"
