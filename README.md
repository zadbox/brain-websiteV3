# BrainGenTechnology

BrainGenTechnology is a modern web platform designed to present Brain's activities, services, and technological expertise, with a focus on artificial intelligence, blockchain, and automation.

## Project Overview

This Laravel-based application aims to deliver a high-quality, scalable, and secure website for BrainGenTechnology, featuring:

- 🎨 **Modern responsive design** with mobile-first approach
- 🤖 **Animated neural network background** with HTML5 Canvas
- 🚀 **Optimized performance** with lazy loading and efficient animations
- 📱 **Mobile-responsive** interface with adaptive breakpoints
- 🔧 **Modular architecture** with separated CSS and JavaScript files
- 📧 **Contact form** with email integration
- 🎯 **Interactive sections** with smooth animations and transitions

## ✨ Features

### 🎨 Design & UX
- Hero section with animated background
- Statistics counters with scroll-triggered animations
- Interactive expertise tabs with auto-switching
- Partners carousel with Swiper.js
- Responsive grid layout with Bootstrap-like system
- Smooth scroll animations and hover effects

### 🔧 Technical Features
- Laravel 11 framework
- SQLite database (development)
- PHP 8.4 compatibility
- Modular CSS and JavaScript architecture
- Performance optimizations
- SEO-friendly structure

## 🚀 Quick Start

### Prerequisites

- PHP >= 8.2
- Composer
- SQLite (included with PHP)

### Installation

1. Clone the repository:
```bash
git clone https://github.com/zadbox/BrainGenTechnology.git
cd BrainGenTechnology
```

2. **Easy launch** (recommended):
```bash
./start-server.sh
```

3. **Manual setup**:
```bash
# Copy environment file
cp .env.example .env

# Install dependencies
composer install --no-dev

# Generate application key
php artisan key:generate

# Create database
touch database/database.sqlite

# Run migrations
php artisan migrate

# Start development server
php artisan serve --port=8080
```

4. **Access the application**:
   - Open your browser and go to: `http://127.0.0.1:8080`
   - The application should load with the animated neural network background

## 📁 Project Structure

```
BrainGenTechnology/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Mail/                # Email classes
│   └── Models/              # Eloquent models
├── public/
│   ├── assets/
│   │   ├── css/
│   │   │   └── index-page.css    # Custom page styles
│   │   └── js/
│   │       └── index-page.js     # Custom page scripts
│   └── images/              # Static images
├── resources/
│   └── views/               # Blade templates
├── routes/
│   └── web.php              # Web routes
├── database/
│   └── database.sqlite      # SQLite database
└── start-server.sh          # Quick launch script
```

## 🎨 Page Sections

### 1. Hero Section
- Animated title and subtitle
- Feature highlights with icons
- Call-to-action button
- Responsive image

### 2. Statistics Section
- Animated counters (70%, 80%, 60%, 50%)
- Performance metrics cards
- Hover effects and animations

### 3. Expertise Section
- Auto-switching tabs every 3 seconds
- Service descriptions with images
- Interactive tab navigation
- Responsive layout

### 4. Partners Section
- Swiper.js carousel
- Auto-playing partner logos
- Responsive breakpoints

### 5. Approach Section
- Three-phase methodology
- Interactive cards
- Call-to-action buttons

### 6. Why Choose Us Section
- Step-by-step process
- Icons and descriptions
- Side-by-side layout

### 7. Final CTA Section
- Gradient background
- Contact encouragement
- Feature highlights

## 🔧 Development

### File Structure
- **CSS**: `/public/assets/css/index-page.css`
- **JavaScript**: `/public/assets/js/index-page.js`
- **Views**: `/resources/views/index.blade.php`

### Key Features
- **Neural Network Animation**: HTML5 Canvas with particle system
- **Responsive Design**: Mobile-first approach with breakpoints
- **Performance Optimized**: Lazy loading and efficient animations
- **Accessibility**: Keyboard navigation and screen reader support

## 🚀 Deployment

### Production Setup
1. Configure your web server (Apache/Nginx)
2. Set up proper `.env` file with production values
3. Run `composer install --no-dev --optimize-autoloader`
4. Set up SSL certificate
5. Configure caching and optimization

### Environment Variables
Key variables to configure in `.env`:
- `APP_NAME`: Application name
- `APP_ENV`: Environment (local/production)
- `APP_URL`: Application URL
- `MAIL_*`: Email configuration
- `DB_*`: Database configuration

## 🎯 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📞 Support

For any questions or issues, please contact the development team or create an issue in the repository.

## 🔄 Updates

The project is regularly updated with new features and improvements. Check the commit history for the latest changes.

---

**BrainGenTechnology** - Empowering businesses with AI, blockchain, and automation solutions.
