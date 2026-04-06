# LuxeEstate Agent Guidelines

## Architecture: Senior-Grade Hardened Laravel + Supabase

### 1. Security & Identity
- **Fail-Closed Integration**: Stripe session creation and webhooks MUST fail closed if API keys or secrets are missing in non-local environments.
- **Role Isolation**: Roles are NEVER self-assigned. All registrations default to CUSTOMER.
- **UUIDs**: All public-facing models (`Property`, `Booking`, `User`, `Payment`) MUST use UUIDs for route model binding. 
- **Soft Deletes**: Always implement `SoftDeletes` for business-critical models like `Property` and `Booking`.

### 2. Backend Standards
- **Enums**: Use PHP Enums (`App\Enums\*`) for all roles and statuses. Avoid string literals in logic.
- **Service Layer**: Decouple logic from controllers. Use `PropertyService` for media/disk and `SupabaseService` for external integration.
- **Standardized API**: Use strict `FormRequest` validation and explicit `JsonResource` contracts for all outputs to prevent data leakage.

### 3. Payments (Stripe)
- **Stripe SDK**: Always use the official Stripe SDK. Metadata MUST include `booking_uuid` for reconciliation.
- **Webhook Security**: Webhooks MUST implement signature verification.
- **Status Persistence**: Track all payment states (`pending`, `paid`, `failed`) in the `Payment` model.

### 4. CI/CD & Testing
- **Feature Tests**: New features MUST have corresponding `tests/Feature/Api` tests.
- **Test Parity**: Ensure `public/build/manifest.json` is present for tests to avoid boot failures.
- **SQLite Compatibility**: Keep migrations compatible with in-memory SQLite for rapid testing.
