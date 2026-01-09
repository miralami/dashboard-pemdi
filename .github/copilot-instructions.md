# Dashboard PEMDI - AI Coding Agent Instructions

## Project Overview

Laravel 12 dashboard application for Indonesian government institutions (PEMDI), displaying SPBE (Sistem Pemerintahan Berbasis Elektronik) and SIA (Sistem Informasi Arsitektur) metrics via radar charts and visualizations. Data flows from external APIs → database → cached service layer → Chart.js frontend.

## Critical: Environment Variable Encryption

**ALWAYS use `npx dotenvx run --` prefix for ALL Laravel/PHP commands.** This project uses dotenvx for encrypted environment variables.

```bash
# ✅ Correct
npx dotenvx run -- php artisan serve
npx dotenvx run -- php artisan migrate
npx dotenvx run -- php artisan spbe:fetch

# ❌ Never run directly
php artisan serve
```

Never suggest commands without the `npx dotenvx run --` prefix. See `.github/instructions/main.instructions.md`.

## Architecture & Data Flow

### Service-Oriented Architecture

Three core services handle all external data:

1. **SpbeApiService** (`app/Services/SpbeApiService.php`)
   - Fetches TAUVAL API data (SPBE/governance metrics)
   - Stores in `spbe_data` table with JSON `nilai` field containing D2001-D2004 domain scores
   - Command: `spbe:fetch [--awal=YYYY] [--akhir=YYYY]`
   - Scheduled daily at 1:00 AM (`routes/console.php`)

2. **SiaApiService** (`app/Services/SiaApiService.php`)
   - Fetches architecture maturity data (AS-IS/TO-BE metrics)
   - Stores in `sia_data` table with separate columns per domain
   - Command: `sia:fetch`
   - Cache-first strategy (15 min TTL)

3. **DashboardService** (`app/Services/DashboardService.php`)
   - Orchestrates data from both sources
   - Transforms DB data into Chart.js format
   - Implements aggressive caching (5 min for dashboard, 10 min for national averages)
   - Database-first with API fallback

### Key Data Structures

**SPBE Domain Mapping** (constants in `DashboardService::DOMAIN_MAPPING`):
- D2001: Kebijakan SPBE (Policy)
- D2002: Tata Kelola SPBE (Governance)
- D2003: Manajemen SPBE (Management)
- D2004: Layanan SPBE (Service)

Scores range 0-5. Chart data compares institution values vs. national averages.

**SIA Domains**: 6 categories each for AS-IS and TO-BE states:
- Proses Bisnis, Layanan, Data/Info, Aplikasi, Infra, Keamanan

See `docs/SIA-ARCHITECTURE-IMPLEMENTATION.md` for detailed domain documentation.

## Development Workflows

### Initial Setup
```bash
composer install
npx dotenvx run -- php artisan key:generate
npx dotenvx run -- php artisan migrate
npm install && npm run build
```

### Running Development Server
```bash
# Full stack with live reload (recommended)
composer run dev  # Runs server + queue + logs + Vite concurrently

# Or manual
npx dotenvx run -- php artisan serve
npm run dev
```

### Data Fetch Commands
```bash
# Fetch SPBE data (various options)
npx dotenvx run -- php artisan spbe:fetch                    # All years from 2020
npx dotenvx run -- php artisan spbe:fetch --awal=2022        # From 2022 onwards
npx dotenvx run -- php artisan spbe:fetch --awal=2022 --akhir=2024
npx dotenvx run -- php artisan spbe:fetchalltime            # Year-by-year 2019-2024

# Fetch SIA data
npx dotenvx run -- php artisan sia:fetch

# Run scheduler (for daily auto-fetch)
npx dotenvx run -- php artisan schedule:work
```

### Testing
```bash
composer test  # Clears config cache + runs PHPUnit
```

## Project-Specific Conventions

### Database Patterns
- **Unique constraints**: `spbe_data` uses `['kode', 'tahun']`, `sia_data` uses `['instansi', 'id_kategori_instansi']`
- **JSON storage**: SPBE `nilai` field stores nested domain scores as JSON (indexed queries not used)
- **Indexes**: Performance-critical columns (`kode`, `instansi`, `tahun`) are indexed

### Caching Strategy
- **Service layer caching**: All services implement Laravel Cache facade
- **TTL hierarchy**: 
  - Dashboard data: 5 min
  - National averages: 10 min
  - SIA API data: 15 min
- **Cache keys**: Namespaced by institution code (e.g., `dashboard_data_{kode}`)
- **Fallback pattern**: Database → API → empty array (never throw on cache miss)

### API Integration
- **TAUVAL API**: Requires `code` header with `TAUVAL_API_KEY`
- **SIA API**: Requires `code` header with `SIA_API_KEY`
- **Timeout strategy**: 30s for fetch operations, 3-5s for real-time queries
- **Config location**: `config/services.php` maps env vars (`TAUVAL_API_URL`, `SIA_API_URL`, etc.)

### Frontend Patterns
- **Chart.js**: Radar charts for multi-dimensional SPBE domains
- **Blade templates**: No Vue/React, pure Blade + vanilla JS
- **Tailwind CSS v4**: Using `@tailwindcss/vite` plugin
- **Asset building**: Vite (see `vite.config.js`)

## Important Files & Directories

- `app/Services/` - Service layer for API/data orchestration
- `app/Console/Commands/` - Artisan commands for data fetching
- `routes/console.php` - Scheduled tasks (daily SPBE fetch)
- `config/services.php` - External API configuration
- `docs/SIA-ARCHITECTURE-IMPLEMENTATION.md` - Domain architecture deep dive
- `database/migrations/` - Schema with unique constraints and indexes

## Common Pitfalls

1. **Forgetting dotenvx prefix**: Always wrap artisan commands with `npx dotenvx run --`
2. **Cache invalidation**: When changing service logic, clear cache: `npx dotenvx run -- php artisan cache:clear`
3. **JSON queries**: Don't attempt complex JSON queries on `spbe_data.nilai` - retrieve and decode in PHP
4. **Year parameters**: SPBE commands default to 2020 if no `--awal` specified, not current year
5. **Institution codes**: Dashboard requires `?kode=` query param, redirects to home if missing
6. **Migration order**: SPBE and SIA migrations have specific years (2026) - maintain chronological order

## Key Endpoints

- `/` - Institution selector (landing page)
- `/dashboard?kode={code}` - Main dashboard with radar charts
- `/api/institutions` - Institution list for dropdowns
- `/api/search-institutions` - Real-time search

## Testing Notes

- PHPUnit 11.5+ configured in `phpunit.xml`
- Test structure: `tests/Feature/` for HTTP, `tests/Unit/` for services
- Always clear config before testing: `@php artisan config:clear --ansi` (see `composer.json` scripts)
