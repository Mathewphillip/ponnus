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
if [ -n "$DB_HOST" ] && [ "$DB_CONNECTION" = "mysql" ]; then
    echo "==> [Ponnus Startup] Waiting for external MySQL database at ${DB_HOST}:${DB_PORT:-3306}..."
    MAX_TRIES=15
    COUNT=0
    until php -r '
        try {
            $options = [];
            if ($ca = getenv("MYSQL_ATTR_SSL_CA")) {
                $options[Pdo\Mysql::ATTR_SSL_CA] = $ca;
            }
            $pdo = new PDO(
                "mysql:host=" . getenv("DB_HOST") . ";port=" . (getenv("DB_PORT") ?: 3306) . ";dbname=" . getenv("DB_DATABASE"),
                getenv("DB_USERNAME"),
                getenv("DB_PASSWORD"),
                $options
            );
            exit(0);
        } catch (Exception $e) {
            exit(1);
        }
    ' 2>/dev/null || [ $COUNT -ge $MAX_TRIES ]; do
        COUNT=$((COUNT + 1))
        echo "    Waiting for MySQL ($COUNT/$MAX_TRIES)..."
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
    echo "==> [Ponnus Startup] DB_HOST not provided or not mysql; skipping database migration step."
fi

echo "==> [Ponnus Startup] Startup sequence complete! Launching web server..."
exec "$@"
