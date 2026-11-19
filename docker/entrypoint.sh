#!/bin/sh
set -e

echo "==> [Ponnus Startup] Initializing application for Render Free Tier..."

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
        php artisan migrate --force --isolated || php artisan migrate --force

        # Optional: Run seeders if AUTORUN_SEEDERS is set to true
        if [ "$AUTORUN_SEEDERS" = "true" ] || [ "$AUTORUN_SEEDERS" = "1" ]; then
            echo "==> [Ponnus Startup] Seeding demo accounts and dishes (db:seed --force)..."
            php artisan db:seed --force
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
