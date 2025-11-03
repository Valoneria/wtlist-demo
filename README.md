## wtlist-demo

This is a demo project intended to showcase my understanding of Laravel. As a demo, some production-grade concerns are intentionally simplified or omitted.

### Notes
- Authentication: The project includes Laravel Breeze scaffolding, but full authentication is not set up nor expected to work. Treat any auth-related code as placeholders for a real implementation.

### The project
- Uses <a href="https://www.wtvehiclesapi.sgambe.serv00.net/api/vehicles" target="blank">https://www.wtvehiclesapi.sgambe.serv00.net/api/vehicles</a> as a resource to import elements from their API, to populate the DB
- Provides a list of ground-based vehicles from the popular MMO title <a href="https://warthunder.com/en" target="blank">War Thunder</a>
- Uses technologies like TailwindCSS for the CSS framework, Livewire for the JavaScript framework, and MySQL for database

> Reminder: Since this is a demo, it's not intended to be deployed, or used in a real world application - It's only meant to showcase my Laravel project

### Requirements
- PHP 8.2+
- Composer
- Node.js 18+ and npm
- A MySQL-compatible database

### Setup
1. Copy environment file and set database credentials
   - `cp .env.example .env`
   - Update DB settings and app URL as needed
2. Install dependencies
   - `composer install`
   - `npm install`
3. Generate app key and run migrations + seeders (countries and types)
   - `php artisan key:generate`
   - `php artisan migrate --seed`
4. Start development services
   - Backend: `php artisan serve`
   - Frontend: `npm run dev`

Alternative combined dev (uses concurrently): `composer run dev`

### Data import
- Service: `App\Services\WarThunderImportService`
- Routes:
  - `GET /vehicle/import` — triggers an import; accepts optional `limit` query param (default 50)
  - `GET /vehicle/import/form` — simple UI to trigger and view import history
- Behavior:
  - Fetches paginated vehicles from the external API in pages of `limit`, up to ~11 pages.
  - Saves/updates vehicles, and downloads images to `public/vehicles/{country}/{identifier}.png`.
  - Records a summary (created/updated/skipped/failed) per run.

### Listing and filtering
- Home: `GET /`
- Query params:
  - `vehicle_type` — filter by `vehicle_types.id`
  - `country` — filter by `vehicle_countries.id`
  - `min_rank` / `max_rank`

### Testing
- Uses Pest. Run tests with: `php artisan test`

### Known limitations / caveats
- Authentication scaffolding (Breeze) exists but is not configured.
- Import relies on a public third-party API and may be rate/availability constrained.
- Images are written directly to `public/vehicles/*`; no checksum/versioning.
- `set_time_limit(3000)` is used in import to avoid timeouts; a queued job would be preferable.
- No pagination on the vehicle list; all matching vehicles are rendered.

