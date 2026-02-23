<?php
/**
 * THIS FILE IS NOT A MIGRATION.
 * It documents which old duplicate migration files must be manually deleted
 * before running `php artisan migrate:fresh --seed`.
 *
 * DELETE these files if they exist in your database/migrations/ folder:
 *
 *   - Any second file named *_create_settings_table.php
 *     (keep only: 2024_01_01_000001_create_settings_table.php)
 *
 *   - Any second file named *_create_categories_table.php
 *     (keep only: 2024_01_01_000002_create_categories_table.php)
 *
 *   - Any file named 2024_01_01_000009_create_settings_table.php  ← DELETE
 *
 * The authoritative migration set is:
 *   0001_01_01_000000_create_users_table        (Laravel default)
 *   0001_01_01_000001_create_cache_table        (Laravel default)
 *   0001_01_01_000002_create_jobs_table         (Laravel default)
 *   2024_01_01_000001_create_settings_table
 *   2024_01_01_000002_create_categories_table
 *   2024_01_01_000003_create_products_table
 *   2024_01_01_000004_create_product_images_table
 *   2024_01_01_000005_create_product_variants_table
 *   2024_01_01_000006_create_coupons_table
 *   2024_01_01_000007_create_orders_table
 *   2024_01_01_000008_create_order_items_table
 *   2024_01_01_000009_create_reviews_table
 *   2024_01_01_000010_add_fields_to_users_table
 *
 * After deleting duplicates run:
 *   php artisan migrate:fresh --seed
 */