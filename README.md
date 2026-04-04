# LuxeEstate | Luxury Real Estate Platform

A commercial-grade, luxury real estate platform built with Laravel 11, Vue.js 3, and Tailwind CSS. Featuring an architectural 'Brutalist-Luxe' aesthetic, real-time notifications, and high-end property management.

## 💎 Features

- **Architectural Design:** 'Elysian Heirloom' design system with 0px border-radius, gold accents, and Noto Serif typography.
- **Dynamic Property Engine:** Advanced filtering by location, type, and luxury price ranges.
- **Interactive Dashboards:** Role-based interfaces for Admins (KPIs, CMS), Agents (Performance, Leads), and Customers (My Collection, Showings).
- **Real-time Communication:** In-platform concierge chat and instant booking notifications via Supabase.
- **Secure Infrastructure:** Token-based authentication (Sanctum), Stripe-ready payment workflows, and Dockerized deployment on Render.
- **Luxury Media:** High-resolution galleries and support for virtual tour metadata.

## 🛠 Tech Stack

- **Backend:** Laravel 11, PostgreSQL
- **Frontend:** Vue.js 3, Vite, Tailwind CSS
- **Real-time:** Supabase
- **Payments:** Stripe (Integration Ready)
- **Deployment:** Render (Docker / Nginx / Supervisor)

## 📖 Documentation

Comprehensive guides are available in the `docs/` directory:
- [Architecture](./docs/architecture.md)
- [Developer Setup](./docs/setup.md)
- [API & Database Reference](./docs/api_and_database.md)
- [Deployment Guide](./docs/deployment.md)

## 🚀 Getting Started

1. Clone the repository.
2. Install dependencies: `composer install` & `npm install`.
3. Set up environment variables in `.env` (DB, SUPABASE, STRIPE).
4. Run migrations and seeders: `php artisan migrate --seed`.
5. Build assets: `npm run build`.
6. Start the server: `php artisan serve`.

---
*Created with focus on architectural integrity and bespoke service.*
