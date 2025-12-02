# Complete Migrations List

## ✅ All Migrations Added

### Core Laravel Migrations
1. `0001_01_01_000000_create_users_table.php` - Users, password reset tokens, sessions
2. `0001_01_01_000001_create_cache_table.php` - Cache table
3. `0001_01_01_000002_create_jobs_table.php` - Jobs queue table
4. `2025_11_28_164320_create_sessions_table.php` - Sessions table

### SEO Migrations
5. `2025_12_01_010936_drop_seo_pages_table.php` - Cleanup migration
6. `2025_12_01_013623_create_page_seos_table.php` - SEO management

### Tech Blog Core Migrations
7. `2025_12_02_000001_create_categories_table.php` - Categories
8. `2025_12_02_000002_create_articles_table.php` - Articles
9. `2025_12_02_000003_create_tags_table.php` - Tags + article_tag pivot
10. `2025_12_02_000004_create_comments_table.php` - Comments with replies

### User Profile Enhancements
11. `2025_12_02_000005_add_profile_fields_to_users_table.php` - User profile fields
   - username, avatar, bio, website, social links
   - is_author, role fields

### Newsletter & Contact
12. `2025_12_02_000006_create_newsletter_subscriptions_table.php` - Newsletter subscribers
13. `2025_12_02_000007_create_contact_messages_table.php` - Contact form submissions

### User Engagement Features
14. `2025_12_02_000008_create_bookmarks_table.php` - User bookmarks/favorites
15. `2025_12_02_000009_create_article_views_table.php` - Detailed view tracking
16. `2025_12_02_000010_create_article_likes_table.php` - Article likes
17. `2025_12_02_000011_create_reading_history_table.php` - Reading history with progress

### Utility Migrations
18. `2025_12_02_000012_add_slug_to_articles_table.php` - Ensures slug is properly set up

## 📊 Database Schema Overview

### Users Table (Enhanced)
- Basic: id, name, email, password, timestamps
- Profile: username, avatar, bio, website, twitter, github, linkedin
- Role: is_author, role (user/author/admin)

### Categories Table
- id, name, slug, description, image, color
- sort_order, is_active
- Soft deletes

### Articles Table
- id, title, slug, excerpt, content, featured_image
- category_id (FK), author_id (FK)
- status, views, reading_time, is_featured, allow_comments
- published_at, sort_order, meta (JSON)
- Soft deletes

### Tags Table
- id, name, slug, description
- Soft deletes

### Article_Tag Pivot
- id, article_id (FK), tag_id (FK)
- Unique constraint on article_id + tag_id

### Comments Table
- id, article_id (FK), user_id (FK, nullable)
- name, email (for guests), content
- parent_id (FK for replies)
- status, ip_address, user_agent
- Soft deletes

### Newsletter Subscriptions
- id, email (unique), name
- is_active, subscribed_at, unsubscribed_at
- unsubscribe_token, ip_address, source

### Contact Messages
- id, name, email, subject, message
- status (unread/read/replied/archived)
- user_id (FK, nullable), ip_address, user_agent
- read_at, replied_by (FK), replied_at, reply_message

### Bookmarks
- id, user_id (FK), article_id (FK)
- notes (user's personal notes)
- Unique constraint on user_id + article_id

### Article Views (Analytics)
- id, article_id (FK), user_id (FK, nullable)
- ip_address, user_agent, referer
- country, device_type, viewed_at

### Article Likes
- id, article_id (FK), user_id (FK, nullable)
- ip_address (for guest likes)
- Unique constraint on article_id + user_id

### Reading History
- id, user_id (FK), article_id (FK)
- progress (0-100%), last_read_at
- Unique constraint on user_id + article_id

## 🎯 Features Enabled

✅ **User Management**
- User profiles with bio, avatar, social links
- Author roles and permissions
- User authentication

✅ **Content Management**
- Articles with categories and tags
- Featured articles
- Draft/Scheduled publishing
- Reading time calculation

✅ **Engagement Features**
- Comments with replies
- Article likes
- Bookmarks/favorites
- Reading history with progress tracking

✅ **Analytics**
- Detailed view tracking (IP, device, referer)
- View counts per article
- User engagement metrics

✅ **Communication**
- Newsletter subscriptions
- Contact form submissions
- Email management

✅ **SEO**
- Page-level SEO management
- Meta tags, OG tags, Twitter cards
- Schema markup support

## 🚀 Migration Order

The migrations are properly ordered to handle foreign key dependencies:

1. Users (base)
2. Categories (no dependencies)
3. Articles (depends on categories, users)
4. Tags (depends on articles)
5. Comments (depends on articles, users)
6. User profile fields (adds to users)
7. Newsletter (no dependencies)
8. Contact messages (depends on users)
9. Bookmarks (depends on users, articles)
10. Article views (depends on articles, users)
11. Article likes (depends on articles, users)
12. Reading history (depends on users, articles)

## 📝 Next Steps

1. Run migrations:
   ```bash
   php artisan migrate
   ```

2. Create seeders for:
   - Sample categories
   - Sample articles
   - Admin user
   - Sample tags

3. Update models to include new relationships:
   - User model: bookmarks, readingHistory, likes, etc.
   - Article model: views, likes, bookmarks, etc.

All migrations are complete and ready to use! 🎉

