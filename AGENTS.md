# LuxeEstate Agent Guidelines

## Architecture: Senior-Grade Hardened Laravel + Supabase

### 1. Database & Infrastructure
- **Supabase-First**: Use the remote Supabase project for Auth, DB, Storage, and Real-time.
- **UUIDs**: All public-facing models (`Property`, `Booking`, `User`, `Payment`) MUST use UUIDs for route model binding. Use the `uuid` column and define `getRouteKeyName()`.
- **Soft Deletes**: Always implement `SoftDeletes` for business-critical models like `Property` and `Booking`.

### 2. Backend Standards
- **Enums**: Use PHP Enums (`App\Enums\*`) for all roles and statuses. Avoid string literals in logic.
- **Service Layer**: Decouple logic from controllers. Use `PropertyService` for media/disk and `SupabaseService` for external integration.
- **FormRequests & Resources**: Use strict validation in `FormRequest` classes and standardized JSON in `JsonResource` classes.
- **Policies**: Enforce authorization using `Gate::authorize()` or `$this->authorize()` in controllers, backed by `ModelPolicy` classes.

### 3. Payments (Stripe)
- **Status Persistence**: Always track payment status in the `Payment` model.
- **Webhook Reliability**: The Stripe webhook (`WebhookController`) MUST handle idempotency and be outside the `throttle:api` middleware group.
- **Transitions**: State transitions for `Booking` MUST be triggered by verified webhook events.

### 4. Testing
- **Feature-First**: New features MUST include a `tests/Feature/Api` test class.
- **SQLite Support**: Ensure migrations and tests are compatible with in-memory SQLite for CI/CD speed.
