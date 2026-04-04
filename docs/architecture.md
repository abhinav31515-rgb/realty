# LuxeEstate | Technical Architecture

LuxeEstate is a commercial-grade, luxury real estate platform designed with an architectural focus and high-performance scalability.

## 🏗 System Overview

The platform follows a modern full-stack architecture:

- **Frontend:** A Single-Page Application (SPA) built with **Vue.js 3** and **Vite**, utilizing **Tailwind CSS** for bespoke luxury styling.
- **Backend:** A robust **Laravel 11** RESTful API managing business logic, authentication, and complex data relationships.
- **Database:** **PostgreSQL** hosted on Render, optimized for high-value property metadata.
- **Real-time Engine:** **Supabase** handles instant notifications, concierge chat, and live database replication.
- **Storage:** Dynamic media engine with failover logic (S3 -> Supabase -> Local).

## 💎 Design System: Elysian Heirloom

The platform adheres to a custom 'Brutalist-Luxe' aesthetic:
- **Aesthetic:** Minimalist, structural, high-contrast.
- **Colors:** Charcoal (#1A1A1A), Gold (#C5A059), Off-White (#F9F9F7).
- **Typography:** Noto Serif (Headlines) and Inter (Body).
- **Geometry:** Strict 0px border-radius to emphasize architectural precision.

## 📡 Integrations

1.  **Supabase Real-time:** Used for the Concierge Chat and instant Booking alerts.
2.  **Stripe Checkout:** Prepared for luxury deposits and featured listing payments.
3.  **Mapbox:** Powers the spatial exploration and locality insights (nearby amenities).
4.  **Render:** Automated CI/CD deployment via Docker containers.
