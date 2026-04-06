# Developer Setup Guide (Supabase Unified)

LuxeEstate uses a unified architecture where **Supabase** serves as the primary database, real-time engine, and media storage provider. This eliminates the need for local Docker or PostgreSQL installations.

## 📋 Prerequisites

- **PHP 8.3+** & **Composer**
- **Node.js 22+** & **NPM**
- **Supabase Account** (Credentials provided in .env)

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
    The `.env` is already pre-configured to connect to the Supabase cloud instance. Ensure you have the DB password.

3.  **Application Initialization:**
    ```bash
    composer install
    php artisan key:generate
    php artisan storage:link
    ```

4.  **Frontend Setup:**
    ```bash
    npm install
    npm run build
    ```

5.  **Run the Application:**
    ```bash
    php artisan serve
    ```
    The site will be available at `http://localhost:8000`.

## 🛠 Unified Architecture Benefits

- **Single Source of Truth:** Your local development and the production site on Render both connect to the same Supabase instance. Changes to data are reflected everywhere instantly.
- **No Local DB Needed:** No need to install PostgreSQL or Docker on your machine.
- **Real-time Ready:** Chat and notifications work out-of-the-box in the local environment.

## 🔐 Core Credentials

| Service | Connection |
| :--- | :--- |
| **PostgreSQL** | db.cuqxtobrrpgrvcnstais.supabase.co |
| **Real-time** | cuqxtobrrpgrvcnstais.supabase.co |
| **Storage** | bucket: properties (S3 Compatible) |

## 🎨 UI System (Notifications)
To trigger a notification in any component:
```javascript
import { inject } from 'vue';
const notify = inject('notify');
notify('Your message here', 'success', 'Title');
```
