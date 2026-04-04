# Database Schema & API Reference

LuxeEstate utilizes a normalized PostgreSQL schema designed for high-end property management and lead tracking.

## 🗄 Database Schema

### `users`
- `id` (bigint, PK)
- `name` (string)
- `email` (string, unique)
- `role` (admin, agent, customer)
- `is_verified` (boolean)
- `profile_data` (json)

### `properties`
- `id` (bigint, PK)
- `owner_id` (FK -> users)
- `title`, `description`, `price`
- `listing_category` (buy, rent, commercial)
- `location`, `total_area`, `bhk_count`
- `status` (active, pending, sold, rejected)
- `metadata` (jsonb) - amenities, smart features
- `is_featured` (boolean)

### `bookings`
- `id` (bigint, PK)
- `property_id` (FK -> properties)
- `customer_id` (FK -> users)
- `agent_id` (FK -> users)
- `status` (pending, confirmed, cancelled)
- `scheduled_at` (datetime)

### `leads`
- `id`, `property_id`, `customer_id`
- `status` (new, contacted, qualified, closed)

## 📡 API Reference (Endpoints)

All API routes are prefixed with `/api`. Authenticated routes require a `Bearer` token.

### Authentication
- `POST /register`: Create new account.
- `POST /login`: Get Sanctum token.
- `GET /me`: Current user profile.

### Properties
- `GET /properties`: List properties (filters: `location`, `type`, `max_price`, `category`).
- `POST /properties`: Submit new masterpiece (requires auth).
- `GET /properties/{id}`: Detailed view.
- `PUT /properties/{id}`: Update listing.

### Leads & Bookings
- `GET /bookings`: Role-based booking list.
- `POST /bookings`: Request a showing.
- `PATCH /bookings/{booking}`: Update status (Confirm/Cancel).

### CMS & Dashboards
- `GET /content`: Fetch dynamic guides/FAQs.
- `GET /dashboard/stats`: Global or personal performance metrics.
