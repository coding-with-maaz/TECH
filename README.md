# Nazaarabox - Movies & TV Shows Website

A modern Laravel-based website for browsing movies and TV shows using The Movie Database (TMDB) API.

## Features

- 🎬 Browse popular, top-rated, now playing, and upcoming movies
- 📺 Explore popular and top-rated TV shows
- 🔍 Search for movies and TV shows
- 📱 Responsive design with modern UI
- 🎨 Beautiful gradient-based color scheme
- ⚡ Fast API responses with caching

## Requirements

- PHP >= 8.2
- Composer
- Laravel 12.x
- TMDB API Key and Access Token

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd Nazaarabox
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

5. Configure your TMDB API credentials in `.env`:
```env
TMDB_API_KEY=your_api_key_here
TMDB_ACCESS_TOKEN=your_access_token_here
```

6. Start the development server:
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Configuration

The TMDB API credentials are configured in `config/services.php`:

- `TMDB_API_KEY`: Your TMDB API key
- `TMDB_ACCESS_TOKEN`: Your TMDB access token
- `TMDB_BASE_URL`: TMDB API base URL (default: https://api.themoviedb.org/3)
- `TMDB_IMAGE_BASE_URL`: TMDB image base URL (default: https://image.tmdb.org/t/p)

## Project Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── HomeController.php      # Home page controller
│       ├── MovieController.php     # Movies listing and details
│       ├── TvShowController.php    # TV shows listing and details
│       └── SearchController.php    # Search functionality
└── Services/
    └── TmdbService.php             # TMDB API service class

resources/
└── views/
    ├── layouts/
    │   └── app.blade.php          # Main layout
    ├── home.blade.php             # Home page
    ├── movies/
    │   ├── index.blade.php        # Movies listing
    │   └── show.blade.php         # Movie details
    ├── tv-shows/
    │   ├── index.blade.php        # TV shows listing
    │   └── show.blade.php         # TV show details
    └── search/
        └── index.blade.php        # Search results

routes/
└── web.php                        # Application routes
```

## Routes

- `/` - Home page with featured content
- `/movies` - Movies listing (with filters: popular, top_rated, now_playing, upcoming)
- `/movies/{id}` - Movie details page
- `/tv-shows` - TV shows listing (with filters: popular, top_rated)
- `/tv-shows/{id}` - TV show details page
- `/search?q={query}` - Search for movies and TV shows

## API Caching

The application uses Laravel's cache system to cache TMDB API responses for 1 hour (3600 seconds) to improve performance and reduce API calls.

## Technologies Used

- **Laravel 12** - PHP framework
- **TMDB API** - Movie and TV show data
- **Blade** - Templating engine
- **CSS3** - Modern styling with gradients and animations

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

- Movie and TV show data provided by [The Movie Database (TMDB)](https://www.themoviedb.org/)
