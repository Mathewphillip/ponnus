# PONNUS Restaurant — Render Free Tier Deployment Guide

This guide provides step-by-step instructions for deploying the **PONNUS Restaurant Menu Management System** to [Render](https://render.com) using the **Free Web Service** tier and an external MySQL-compatible database.

---

## 🏗️ Architecture on Render Free Tier

| Component | Configuration | Notes |
|---|---|---|
| **Hosting Platform** | Render Free Web Service | Containerized Docker service (0.1 CPU, 512 MB RAM) |
| **Runtime** | Docker (Multi-stage) | Node 20 (Vite assets) + Composer 2 + PHP 8.4-FPM + Nginx |
| **Web Server** | Nginx + PHP-FPM | Dynamically binds to Render's internal `$PORT` (default 10000) |
| **Database** | External MySQL-compatible DB | Render free tier does not provide MySQL; use TiDB Cloud, Aiven, or Railway |
| **HTTPS / Edge SSL** | Render Edge Proxy | Terminated at edge; trusted proxies configured in `bootstrap/app.php` |
| **Session & Cache** | Database (`mysql`) | Ephemeral container storage means sessions/cache must live in MySQL |
| **Health Check** | `/up` or `/healthz` | Configured in `render.yaml` and Render service settings |

---

## ⚠️ Important Free Tier Rules & Constraints

1. **Ephemeral Filesystem**:
   - The container's filesystem is discarded whenever the service goes to sleep or redeploys.
   - **Never use SQLite** as a production database on Render.
   - Sessions (`SESSION_DRIVER=database`) and cache (`CACHE_STORE=database`) are persisted directly to MySQL.
2. **Cold Starts & Sleep Behavior**:
   - Render's Free Web Service sleeps after **15 minutes** of inactivity.
   - When a new request arrives, it takes **40–50 seconds** to spin up.
   - **Health check timeout**: Render allows up to a few minutes during cold boot before marking the service ready.
   - **Tip**: You can use a free monitoring service like [UptimeRobot](https://uptimerobot.com) or [Cron-job.org](https://cron-job.org) to ping your `/healthz` endpoint every 14 minutes to keep the instance warm during demonstrations.
3. **Safe Database Migrations**:
   - The container startup script automatically runs:
     ```sh
     php artisan migrate --force --isolated
     ```
   - **Never run `migrate:fresh`** in production, as it drops all existing tables and data.
   - If `AUTORUN_SEEDERS=true` is set, `db:seed --force` will populate the default demo accounts (`admin@ponnus.test`, `staff@ponnus.test`, `manager@ponnus.test`) using safe `updateOrCreate()` logic.

---

## 🗄️ Step 1: Set Up an External Database

Render's free web service connects seamlessly to any cloud database.

### Recommended Provider: Neon Serverless PostgreSQL (Free Tier)
If you are using [Neon](https://neon.tech):
From your Neon connection string:
```text
postgresql://ponnusdb_owner:npg_EvNsI3rTg7Fw@ep-spring-flower-bdyg1rft-pooler.c-8.us-east-2.aws.neon.tech/ponnusdb?sslmode=require
```

The corresponding Render environment variables are:
- **`DB_CONNECTION`**: `pgsql`
- **`DB_HOST`**: `ep-spring-flower-bdyg1rft-pooler.c-8.us-east-2.aws.neon.tech`
- **`DB_PORT`**: `5432`
- **`DB_DATABASE`**: `ponnusdb`
- **`DB_USERNAME`**: `ponnusdb_owner`
- **`DB_PASSWORD`**: `npg_EvNsI3rTg7Fw`
- **`DB_SSLMODE`**: `require`

*(Alternatively, you can also use TiDB Cloud, Aiven, or Railway if you prefer MySQL).*

---

## 🚀 Step 2: Deploy to Render from GitHub

### Option A: One-Click Blueprint Deployment (Recommended)
Because this repository contains a `render.yaml` blueprint:
1. Log in to your [Render Dashboard](https://dashboard.render.com).
2. Click **New +** in the top right &rarr; select **Blueprint**.
3. Connect your repository: `https://github.com/Mathewphillip/ponnus.git`.
4. Render will read `render.yaml` and prompt you to fill in your database credentials:
   - `DB_HOST`: Your external MySQL host
   - `DB_PORT`: `3306` (or `4000` for TiDB)
   - `DB_DATABASE`: `ponnus`
   - `DB_USERNAME`: Your MySQL username
   - `DB_PASSWORD`: Your MySQL password
   - `APP_URL`: Render will assign a URL like `https://ponnus-restaurant.onrender.com`
5. Click **Apply**. Render will automatically build the multi-stage Docker image and launch the service.

---

### Option B: Manual Web Service Deployment
1. Go to your [Render Dashboard](https://dashboard.render.com).
2. Click **New +** &rarr; select **Web Service**.
3. Choose **Build and deploy from a Git repository**.
4. Select `Mathewphillip/ponnus` (or paste `https://github.com/Mathewphillip/ponnus.git`).
5. Configure the service parameters:
   - **Name**: `ponnus-restaurant`
   - **Region**: Select closest to your database (e.g., `Oregon (US West)` or `Frankfurt (EU Central)`)
   - **Branch**: `main`
   - **Runtime**: **Docker**
   - **Dockerfile Path**: `./Dockerfile`
   - **Instance Type**: **Free** ($0/month)
6. Under **Advanced Settings**:
   - **Health Check Path**: `/up` (or `/healthz`)
   - **Auto-Deploy**: `Yes`

---

## 🔑 Step 3: Configure Environment Variables

In your Render Web Service dashboard, navigate to the **Environment** tab and add the following environment variables:

| Variable Name | Recommended Value | Description |
|---|---|---|
| `APP_NAME` | `Ponnus Restaurant` | Display name of the application |
| `APP_ENV` | `production` | Production environment mode |
| `APP_DEBUG` | `false` | Disable detailed debug stack traces |
| `APP_KEY` | *(Click "Generate" or run `php artisan key:generate --show`)* | 32-character AES application encryption key |
| `APP_URL` | `https://<your-service-name>.onrender.com` | Full HTTPS Render URL of your application |
| `ASSET_URL` | `https://<your-service-name>.onrender.com` | Enforces HTTPS on all Vite & Blade assets |
| `DB_CONNECTION` | `mysql` | MySQL database driver |
| `DB_HOST` | `<your-external-db-host>` | Hostname of your external MySQL server |
| `DB_PORT` | `3306` (or `4000`) | Database port |
| `DB_DATABASE` | `ponnus` | Database name |
| `DB_USERNAME` | `<your-db-username>` | Database user |
| `DB_PASSWORD` | `<your-db-password>` | Database password |
| `SESSION_DRIVER` | `database` | Stores user login sessions in MySQL (survives cold starts) |
| `CACHE_STORE` | `database` | Stores application cache in MySQL |
| `QUEUE_CONNECTION` | `sync` | Synchronous queue processing |
| `AUTORUN_SEEDERS` | `true` | Safely seeds initial demo accounts on first deployment |

> [!IMPORTANT]
> Never commit actual database passwords or `APP_KEY` into Git. All sensitive credentials must be set exclusively via Render's Environment Variables panel.

---

## 🔍 Step 4: Verification Checklist

Once Render shows **"Deploy live"**:

1. **Health Check**:
   - Visit `https://<your-app>.onrender.com/up` &rarr; should return HTTP `200 OK` heartbeat.
   - Visit `https://<your-app>.onrender.com/healthz` &rarr; should return JSON `{"status":"ok"}`.
2. **Public Homepage**:
   - Visit `https://<your-app>.onrender.com/` &rarr; verifies Chef branding, navigation bar, and responsive hero.
3. **Public Menu**:
   - Visit `https://<your-app>.onrender.com/menu` &rarr; click category filters (*Main Course, Fast Food, Pizza, Beverages*) and verify dishes and prices in **UGX**.
4. **Staff Login**:
   - Click **Log In** &rarr; sign in with:
     - **Email**: `admin@ponnus.test`
     - **Password**: `password123`
   - Test the eye icon to verify password visibility toggle.
5. **Dashboard & CRUD**:
   - Verify metrics counter (Total Items, Available, Unavailable).
   - Go to **Menu Items** (`/menu/list`) &rarr; test **View Details** (`/menu/show/1`).
   - Add a test menu item (`/menu/create`) &rarr; confirm it appears in the menu table.
   - Edit and delete the test item.

---

## 🛠️ Troubleshooting Common Issues

### 1. Database Connection Timeout during Deploy
- **Symptom**: Render deployment logs show `Waiting for external MySQL database... timed out`.
- **Solution**:
  - Verify your external MySQL provider allows incoming connections from any IP (`0.0.0.0/0`) or whitelist Render's IP addresses.
  - Verify `DB_HOST`, `DB_PORT`, and `DB_DATABASE` have no leading or trailing whitespace.

### 2. HTTPS Mixed Content or Assets Not Loading
- **Symptom**: CSS/JS or Livewire endpoints throw `http://` mixed content warnings.
- **Solution**:
  - `bootstrap/app.php` already contains `$middleware->trustProxies(at: '*')`.
  - `app/Providers/AppServiceProvider.php` already calls `URL::forceScheme('https')` when `APP_ENV=production`.
  - Ensure `APP_URL` in Render matches your exact `https://<app-name>.onrender.com` domain.

### 3. Service Wakes Up Slowly (Cold Start)
- **Symptom**: Initial request takes ~50 seconds after being idle.
- **Explanation**: This is normal behavior on the Render Free Web Service. Render unloads idle containers after 15 minutes to conserve resources.
- **Workaround**: Configure [UptimeRobot](https://uptimerobot.com) to ping `https://<your-app>.onrender.com/healthz` every 14 minutes.
