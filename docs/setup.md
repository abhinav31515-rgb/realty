# Developer Setup Guide

Follow these instructions to set up the LuxeEstate development environment locally.

## 📋 Prerequisites

- **PHP 8.3+** & **Composer**
- **Node.js 22+** & **NPM**
- **PostgreSQL** (Recommended for full feature support)
- **Supabase Account** (Required for real-time notifications and chat)

## 🚀 Local Installation

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/abhinav31515-rgb/realty.git
    cd realty
    ```

2.  **Environment Configuration:**
    ```bash
    cp .env.example .env
    ```
    Open `.env` and configure your local PostgreSQL database:
    - `DB_HOST=127.0.0.1`
    - `DB_PORT=5432`
    - `DB_DATABASE=your_local_db_name`
    - `DB_USERNAME=your_db_user`
    - `DB_PASSWORD=your_db_password`

3.  **Application Initialization:**
    ```bash
    composer install
    php artisan key:generate
    php artisan storage:link
    ```

4.  **Database Setup:**
    ```bash
    php artisan migrate --seed
    ```

5.  **Frontend Setup:**
    ```bash
    npm install
    npm run build
    ```

6.  **Run the Application:**
    ```bash
    php artisan serve
    ```

## 🛠 Troubleshooting (500 Errors)

If you encounter a 500 error:
1.  **Check APP_KEY:** Ensure `php artisan key:generate` was run.
2.  **Check Database:** Ensure your database is running and credentials in `.env` are correct.
3.  **Check Logs:** View detailed error messages in `storage/logs/laravel.log`.
4.  **Session/Cache:** If you change the `SESSION_DRIVER` to `database`, ensure you have run the migrations.

## 🔐 Core Environment Variables

| Variable | Requirement | Description |
| :--- | :--- | :--- |
| `DB_CONNECTION` | Required | Set to `pgsql` for full compatibility. |
| `SUPABASE_URL` | Required | Your Supabase project URL for Real-time features. |
| `SUPABASE_ANON_KEY` | Required | Your Supabase public key. |
| `STRIPE_SECRET` | Optional | Required for processing payments. |
| `SUPABASE_STORAGE_ENDPOINT` | Required | S3-compatible endpoint for Supabase Storage. |
