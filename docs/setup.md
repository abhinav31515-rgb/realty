# Developer Setup Guide

Follow these instructions to set up the LuxeEstate development environment locally.

## 📋 Prerequisites

- **PHP 8.3+** & **Composer**
- **Node.js 22+** & **NPM**
- **PostgreSQL** (or SQLite for local dev)
- **Supabase Account** (for real-time features)

## 🚀 Installation

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/abhinav31515-rgb/realty.git
    cd realty
    ```

2.  **Backend Setup:**
    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Frontend Setup:**
    ```bash
    npm install
    ```

4.  **Database Configuration:**
    Configure your `.env` with your DB credentials and run:
    ```bash
    php artisan migrate --seed
    ```

5.  **Build Assets:**
    ```bash
    npm run build
    ```

6.  **Start the Server:**
    ```bash
    php artisan serve
    ```

## 🔐 Environment Variables

Ensure the following variables are set in your `.env`:

| Variable | Description |
| :--- | :--- |
| `DB_CONNECTION` | Set to `pgsql` or `sqlite` |
| `SUPABASE_URL` | Your Supabase project URL |
| `SUPABASE_ANON_KEY` | Your Supabase public key |
| `STRIPE_SECRET` | (Optional) Stripe API secret |
| `SUPABASE_STORAGE_BUCKET` | Set to `properties` |
