# Migrations Update Summary

## ✅ Cleaned Up Migrations

All old movie/TV show related migrations have been removed. The following migrations are now in place:

### Core Laravel Migrations (Keep)
- `0001_01_01_000000_create_users_table.php` - Users table
- `0001_01_01_000001_create_cache_table.php` - Cache table
- `0001_01_01_000002_create_jobs_table.php` - Jobs table
- `2025_11_28_164320_create_sessions_table.php` - Sessions table

### SEO Migrations (Keep)
- `2025_12_01_010936_drop_seo_pages_table.php` - Cleanup migration
- `2025_12_01_013623_create_page_seos_table.php` - SEO management table

### Tech Blog Migrations (New - Correct Order)
1. `2025_12_02_000001_create_categories_table.php` - Categories (must be first)
2. `2025_12_02_000002_create_articles_table.php` - Articles (references categories)
3. `2025_12_02_000003_create_tags_table.php` - Tags and article_tag pivot (references articles)
4. `2025_12_02_000004_create_comments_table.php` - Comments (references articles)

## ❌ Removed Migrations

The following old migrations have been deleted:
- `2025_11_28_200401_create_contents_table.php`
- `2025_11_28_205153_create_episodes_table.php`
- `2025_11_28_221950_add_slug_to_contents_table.php`
- `2025_11_28_221957_add_slug_to_episodes_table.php`
- `2025_11_28_230119_add_servers_to_contents_table.php`
- `2025_11_29_005422_add_series_status_to_contents_table_if_not_exists.php`
- `2025_11_29_005709_add_end_date_to_contents_table_if_not_exists.php`
- `2025_11_29_123235_add_director_to_contents_table_if_not_exists.php`
- `2025_11_29_192502_create_casts_table.php`
- `2025_11_29_192516_create_content_cast_table.php`
- `2025_11_29_200211_remove_cast_column_from_contents_table.php`
- `2025_11_29_220000_add_slug_to_casts_table.php`

## 📋 Migration Order

The migrations are now in the correct order to handle foreign key dependencies:

1. **Users** (Laravel default)
2. **Categories** - Created first (no dependencies)
3. **Articles** - References categories and users
4. **Tags** - References articles (creates both tags and article_tag tables)
5. **Comments** - References articles and users

## 🚀 Next Steps

1. If you have existing data, you may need to:
   - Backup your database
   - Run `php artisan migrate:fresh` to reset and run all migrations
   - Or manually migrate data from old tables to new tables

2. Run migrations:
   ```bash
   php artisan migrate
   ```

3. If starting fresh:
   ```bash
   php artisan migrate:fresh
   ```

## 📊 Database Schema

### Categories Table
- id, name, slug, description, image, color, sort_order, is_active
- Soft deletes enabled

### Articles Table
- id, title, slug, excerpt, content, featured_image
- category_id (FK to categories)
- author_id (FK to users)
- status, views, reading_time, is_featured, allow_comments
- published_at, sort_order, meta (JSON)
- Soft deletes enabled

### Tags Table
- id, name, slug, description
- Soft deletes enabled

### Article_Tag Pivot Table
- id, article_id (FK), tag_id (FK), timestamps
- Unique constraint on article_id + tag_id

### Comments Table
- id, article_id (FK), user_id (FK, nullable)
- name, email (for guest comments)
- content, parent_id (FK for replies)
- status, ip_address, user_agent
- Soft deletes enabled

All migrations are now clean and ready for the tech blog platform!

