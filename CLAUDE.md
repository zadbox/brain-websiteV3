# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Quick Start Commands

### Development Server
```bash
# Recommended: Use the automated setup script
./start-server.sh [port]

# Manual setup
composer install --no-dev
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve --port=8080
```

### Asset Development
```bash
# Install frontend dependencies
npm install

# Build assets for development
npm run dev

# Build assets for production
npm run build
```

### Testing & Quality
```bash
# Run PHPUnit tests
php artisan test
# or
./vendor/bin/phpunit

# Code formatting with Laravel Pint
./vendor/bin/pint

# Database operations
php artisan migrate
php artisan migrate:fresh
php artisan migrate:rollback
```

## Architecture Overview

### Technology Stack
- **Backend**: Laravel 11 with PHP 8.2+
- **Frontend**: Blade templates with custom CSS/JS (no framework)
- **Database**: SQLite (development)
- **Styling**: TailwindCSS + custom CSS architecture
- **Build**: Vite for asset compilation

### Project Structure
This is a Laravel-based corporate website for BrainGenTechnology with the following key components:

#### Custom Frontend Architecture
- **Neural Network Animation**: HTML5 Canvas-based particle system in `/public/assets/js/index-page.js`
- **Modular CSS**: Page-specific stylesheets in `/public/assets/css/`
- **No Frontend Framework**: Pure JavaScript with custom animations and interactions

#### Content Pages
- **Homepage** (`/`): Hero section with animated neural network background
- **About** (`/a-propos`): Company information
- **Services**: Three main service areas (communication, real estate, agri-food)
- **Contact** (`/contact`): Contact form with email integration
- **FAQ** (`/faqs`): Frequently asked questions

#### Email System
- Uses Laravel's Mail system with custom `ContactMessage` mailable
- Form submissions processed through routes (not controller methods)
- Email sent to `contact@braingentech.com`

### Key Features
- **Responsive Design**: Mobile-first approach with custom breakpoints
- **Performance Optimized**: Lazy loading, efficient animations
- **Interactive Elements**: 
  - Auto-switching expertise tabs (3-second intervals)
  - Statistics counters with scroll-triggered animations
  - Partners carousel using Swiper.js
  - Smooth scroll animations

### Database
- Uses SQLite for development (file: `database/database.sqlite`)
- Standard Laravel migrations in `database/migrations/`
- No custom models beyond User model

### Routing
- All routes defined in `routes/web.php`
- Uses `IndexController` for page rendering
- Contact form uses closure-based route for processing

### Asset Management
- **CSS**: Custom stylesheets in `/public/assets/css/`
- **JavaScript**: Custom scripts in `/public/assets/js/`
- **Images**: Multiple directories under `/public/images/` and `/public/braintech_image/`
- **Fonts**: Custom web fonts in `/public/assets/fonts/`

### Development Notes
- The project uses a custom launch script (`start-server.sh`) that handles all setup automatically
- Frontend assets are managed through Vite but most styling is in custom CSS files
- TailwindCSS configuration includes custom color palette and animations
- No complex state management - uses traditional server-side rendering

### Email Configuration
When working with contact forms, ensure mail configuration is set up in `.env`:
- `MAIL_MAILER`
- `MAIL_HOST`
- `MAIL_PORT`
- `MAIL_USERNAME`
- `MAIL_PASSWORD`

### Deployment Considerations
- SQLite database file needs to be created and migrated
- Ensure proper permissions for `storage/` and `bootstrap/cache/` directories
- Run `composer install --no-dev --optimize-autoloader` for production
- Configure web server to point to `/public` directory
```