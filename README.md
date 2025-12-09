# Nazaaracircle - Technology Blog Platform

A modern Laravel-based technology blog platform for publishing articles, tutorials, and tech news with categories, tags, and SEO optimization.

## Features

- 📝 Article management with rich content editor
- 🏷️ Category and tag system for content organization
- 👤 Author management and attribution
- 💬 Comment system with reply support
- 🔍 Full-text search functionality
- 📱 Responsive design with modern UI using Tailwind CSS
- 🎨 Beautiful dark theme with modern styling
- ⚡ Fast performance with intelligent caching
- 🎯 Comprehensive SEO optimization
- 📊 Reading time calculation
- ⭐ Featured articles support

## Requirements

- PHP >= 8.2
- Composer
- Laravel 12.x
- Database (MySQL, PostgreSQL, or SQLite)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/coding-with-maaz/SEO_BASED_WEBSITE.git
cd SEO_BASED_WEBSITE
```

2. Install dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in `.env`:
```env
DB_CONNECTION=sqlite
# Or use MySQL/PostgreSQL
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=nazaaracircle
# DB_USERNAME=root
# DB_PASSWORD=
```

6. Run migrations:
```bash
php artisan migrate
```

7. Start the development server:
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Configuration

The application configuration is in `config/app.php`:

- `APP_NAME`: Your blog name
- `APP_URL`: Your blog URL
- Database configuration in `.env` file

## Project Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── HomeController.php      # Home page controller
│       ├── ArticleController.php   # Articles listing and details
│       ├── CategoryController.php  # Categories listing and articles
│       ├── TagController.php       # Tags listing and articles
│       ├── SearchController.php    # Search functionality
│       └── Admin/
│           ├── ArticleController.php  # Article management
│           ├── CategoryController.php # Category management
│           └── TagController.php      # Tag management
├── Models/
│   ├── Article.php                 # Article model
│   ├── Category.php                # Category model
│   ├── Tag.php                     # Tag model
│   └── Comment.php                 # Comment model
└── Services/
    ├── ArticleService.php          # Article business logic
    ├── SeoService.php              # SEO management
    └── SitemapService.php          # Sitemap generation

resources/
├── css/
│   ├── theme.css                  # Theme color constants
│   └── components.css             # Reusable component styles
└── views/
    ├── layouts/
    │   └── app.blade.php          # Main layout with Tailwind CSS
    ├── home.blade.php             # Home page
    ├── articles/
    │   ├── index.blade.php        # Articles listing
    │   └── show.blade.php         # Article details
    ├── categories/
    │   ├── index.blade.php        # Categories listing
    │   └── show.blade.php         # Category articles
    ├── tags/
    │   ├── index.blade.php        # Tags listing
    │   └── show.blade.php         # Tag articles
    └── search/
        └── index.blade.php        # Search results

routes/
└── web.php                        # Application routes
```

## Routes

- `/` - Home page with latest articles
- `/articles` - Articles listing with pagination
- `/articles/{slug}` - Article detail page
- `/categories` - Categories listing
- `/categories/{slug}` - Articles in a category
- `/tags` - Tags listing
- `/tags/{slug}` - Articles with a tag
- `/search?q={query}` - Search for articles
- `/about` - About page
- `/contact` - Contact page
- `/privacy` - Privacy policy
- `/terms` - Terms of service

## Caching

The application uses Laravel's cache system to cache:
- Article listings and popular articles (30-60 minutes)
- Category and tag data (1 hour)
- Sitemap generation (1 hour)
- All caches automatically clear when content is updated

## Technologies Used

- **Laravel 12** - PHP framework
- **Tailwind CSS 4.0** - Utility-first CSS framework
- **Blade** - Templating engine
- **Vite** - Build tool and asset bundler
- **SQLite/MySQL/PostgreSQL** - Database support

## Design Features

- Dark theme with professional color scheme
- Modern, clean design
- Responsive grid layouts
- Smooth hover animations
- Card-based article UI
- Modern typography and spacing
- Reading time indicators
- Category and tag badges

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Admin Panel

Access the admin panel at `/admin` to:
- Manage articles (create, edit, delete, publish)
- Manage categories
- Manage tags
- Configure SEO for public pages
- View dashboard statistics

## Features in Detail

### Articles
- Rich content editor support
- Featured image upload
- Category assignment
- Multiple tag support
- Reading time auto-calculation
- View counter
- Published/Draft/Scheduled status
- Featured article flagging
- Comment system integration

### Categories
- Hierarchical organization
- Custom colors and images
- Active/inactive status
- Sort ordering
- Article count tracking

### Tags
- Flexible tagging system
- Auto-slug generation
- Article count tracking
- Search functionality

### SEO
- Comprehensive meta tags
- Open Graph support
- Twitter Card support
- Schema.org structured data
- XML sitemap generation
- Admin-managed SEO for all pages
