# Deployment & Maintenance Guide

LuxeEstate is designed to be deployed using Docker for consistent performance across environments.

## 🚢 Deployment on Render

1.  **Connect GitHub:** Point Render to `https://github.com/abhinav31515-rgb/realty.git`.
2.  **Runtime:** Choose **Docker**.
3.  **Build/Start:** Managed by the root `Dockerfile` and `start.sh`.
4.  **Auto-Deploy:** Enabled for the `main` branch.

## 🛠 Maintenance Scripts

The `start.sh` entrypoint automatically handles:
- `php artisan migrate --force` (Schema updates)
- `php artisan storage:link` (Public media access)
- `php artisan db:seed` (If `RUN_SEEDER=true`)

## 📦 Storage Configuration

The platform uses a dynamic disk selection logic. To enable Supabase Storage:
1. Create a public bucket named `properties` in Supabase.
2. Set `SUPABASE_STORAGE_ENDPOINT` to your S3-compatible URL.
3. Set `SUPABASE_STORAGE_KEY` and `SECRET` (Service Role key).

## 📊 Monitoring

- **Logs:** Accessible via Render dashboard or `php artisan logs` if configured.
- **Analytics:** Property view/click data is stored in the `properties` table and summarized in the Agent Dashboard.
