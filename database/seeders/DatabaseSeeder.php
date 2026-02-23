<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Settings ─────────────────────────────────────────────────────────
        $settings = [
            'site_name_fa'        => 'فروشگاه مکمل ورزشی',
            'site_name_en'        => 'Supplement Store',
            'seo_title_fa'        => 'فروشگاه مکمل ورزشی | خرید مکمل اصل',
            'seo_title_en'        => 'Sports Supplement Store | Buy Original Supplements',
            'seo_description_fa'  => 'خرید مکمل‌های ورزشی اصل با بهترین قیمت',
            'seo_description_en'  => 'Buy original sports supplements at the best price',
            'seo_keywords'        => 'مکمل ورزشی, پروتئین, کراتین, supplement',
            'whatsapp_number'     => '989123456789',
            'payment_enabled'     => '1',
            'zarinpal_merchant'   => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'zarinpal_sandbox'    => '1',
            'site_phone'          => '021-12345678',
            'site_email'          => 'info@supplement.store',
            'site_address_fa'     => 'تهران، خیابان ولیعصر',
            'site_address_en'     => 'Tehran, Valiasr Street',
            'shipping_cost'       => '50000',
            'free_shipping_min'   => '500000',
            'instagram'           => '',
            'telegram'            => '',
            'google_analytics_id' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // ── Admin User ────────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@supplement.store'],
            [
                'name'     => 'مدیر سیستم',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'active'   => true,
            ]
        );

        // ── Test Customer ─────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'user@supplement.store'],
            [
                'name'     => 'کاربر آزمایشی',
                'password' => Hash::make('user123'),
                'role'     => 'user',
                'active'   => true,
            ]
        );

        // ── Categories ────────────────────────────────────────────────────────
        $categories = [
            ['name_fa' => 'پروتئین',       'name_en' => 'Protein',      'slug' => 'protein',      'sort_order' => 1],
            ['name_fa' => 'کراتین',        'name_en' => 'Creatine',     'slug' => 'creatine',     'sort_order' => 2],
            ['name_fa' => 'پری‌ورک‌اوت',  'name_en' => 'Pre-Workout',  'slug' => 'pre-workout',  'sort_order' => 3],
            ['name_fa' => 'ویتامین‌ها',   'name_en' => 'Vitamins',     'slug' => 'vitamins',     'sort_order' => 4],
            ['name_fa' => 'آمینو اسید',   'name_en' => 'Amino Acids',  'slug' => 'amino-acids',  'sort_order' => 5],
            ['name_fa' => 'چربی‌سوز',    'name_en' => 'Fat Burners',  'slug' => 'fat-burners',  'sort_order' => 6],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $record = Category::updateOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, ['active' => true])
            );
            $categoryIds[$cat['slug']] = $record->id;
        }

        // ── Products ──────────────────────────────────────────────────────────
        $products = [
            [
                'category_id'          => $categoryIds['protein'],
                'name_fa'              => 'گلد استاندارد ویی پروتئین',
                'name_en'              => 'Gold Standard Whey Protein',
                'slug'                 => 'gold-standard-whey-protein',
                'brand'                => 'Optimum Nutrition',
                'sku'                  => 'ON-GSW-001',
                'price'                => 850000,
                'sale_price'           => 780000,
                'stock'                => 50,
                'featured'             => true,
                'active'               => true,
                'short_description_fa' => 'بهترین پروتئین وی با ۲۴ گرم پروتئین در هر سرو',
                'short_description_en' => 'Best whey protein with 24g protein per serving',
                'weight'               => 2.27,
            ],
            [
                'category_id'          => $categoryIds['protein'],
                'name_fa'              => 'ایزولیت پروتئین دایماتایز',
                'name_en'              => 'Dymatize ISO100 Whey Isolate',
                'slug'                 => 'dymatize-iso100-whey-isolate',
                'brand'                => 'Dymatize',
                'sku'                  => 'DYM-ISO-001',
                'price'                => 1200000,
                'sale_price'           => null,
                'stock'                => 30,
                'featured'             => true,
                'active'               => true,
                'short_description_fa' => 'پروتئین ایزوله خالص برای عضله‌سازی سریع‌تر',
                'short_description_en' => 'Pure isolate protein for faster muscle building',
                'weight'               => 2.27,
            ],
            [
                'category_id'          => $categoryIds['creatine'],
                'name_fa'              => 'مونوهیدرات کراتین',
                'name_en'              => 'Creatine Monohydrate',
                'slug'                 => 'creatine-monohydrate',
                'brand'                => 'Now Foods',
                'sku'                  => 'NOW-CRE-001',
                'price'                => 320000,
                'sale_price'           => null,
                'stock'                => 80,
                'featured'             => false,
                'active'               => true,
                'short_description_fa' => 'خالص‌ترین کراتین مونوهیدرات برای افزایش قدرت',
                'short_description_en' => 'Purest creatine monohydrate for strength gains',
                'weight'               => 0.5,
            ],
            [
                'category_id'          => $categoryIds['pre-workout'],
                'name_fa'              => 'پری‌ورک‌اوت سلتک',
                'name_en'              => 'C4 Original Pre-Workout',
                'slug'                 => 'c4-original-pre-workout',
                'brand'                => 'Cellucor',
                'sku'                  => 'CEL-C4-001',
                'price'                => 680000,
                'sale_price'           => 620000,
                'stock'                => 25,
                'featured'             => true,
                'active'               => true,
                'short_description_fa' => 'انرژی و تمرکز فوق‌العاده قبل از تمرین',
                'short_description_en' => 'Explosive energy and focus before workout',
                'weight'               => 0.195,
            ],
            [
                'category_id'          => $categoryIds['vitamins'],
                'name_fa'              => 'مولتی ویتامین اوپتی‌من',
                'name_en'              => 'Opti-Men Multivitamin',
                'slug'                 => 'opti-men-multivitamin',
                'brand'                => 'Optimum Nutrition',
                'sku'                  => 'ON-OPM-001',
                'price'                => 450000,
                'sale_price'           => null,
                'stock'                => 60,
                'featured'             => false,
                'active'               => true,
                'short_description_fa' => 'کامل‌ترین مولتی ویتامین برای مردان ورزشکار',
                'short_description_en' => 'Most complete multivitamin for active men',
                'weight'               => 0.24,
            ],
            [
                'category_id'          => $categoryIds['amino-acids'],
                'name_fa'              => 'بی‌سی‌اِی‌ای اسید آمینه',
                'name_en'              => 'BCAA Amino Acids',
                'slug'                 => 'bcaa-amino-acids',
                'brand'                => 'Scitec Nutrition',
                'sku'                  => 'SCI-BCA-001',
                'price'                => 580000,
                'sale_price'           => 520000,
                'stock'                => 40,
                'featured'             => true,
                'active'               => true,
                'short_description_fa' => 'آمینو اسیدهای شاخه‌دار برای ریکاوری سریع',
                'short_description_en' => 'Branched-chain amino acids for fast recovery',
                'weight'               => 0.3,
            ],
            [
                'category_id'          => $categoryIds['fat-burners'],
                'name_fa'              => 'چربی‌سوز ترموژنیک',
                'name_en'              => 'Thermogenic Fat Burner',
                'slug'                 => 'thermogenic-fat-burner',
                'brand'                => 'BSN',
                'sku'                  => 'BSN-THR-001',
                'price'                => 750000,
                'sale_price'           => null,
                'stock'                => 20,
                'featured'             => false,
                'active'               => true,
                'short_description_fa' => 'فرمول قوی چربی‌سوزی با افزایش متابولیسم',
                'short_description_en' => 'Powerful fat burning formula with metabolic boost',
                'weight'               => 0.2,
            ],
            [
                'category_id'          => $categoryIds['protein'],
                'name_fa'              => 'کازئین پروتئین شبانه',
                'name_en'              => 'Casein Protein Night',
                'slug'                 => 'casein-protein-night',
                'brand'                => 'Optimum Nutrition',
                'sku'                  => 'ON-CAS-001',
                'price'                => 920000,
                'sale_price'           => 860000,
                'stock'                => 15,
                'featured'             => false,
                'active'               => true,
                'short_description_fa' => 'پروتئین کند‌هضم برای ریکاوری شبانه',
                'short_description_en' => 'Slow-digesting protein for overnight recovery',
                'weight'               => 1.82,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['slug' => $product['slug']], $product);
        }

        // ── Coupons ───────────────────────────────────────────────────────────
        $coupons = [
            [
                'code'       => 'WELCOME10',
                'type'       => 'percent',
                'value'      => 10,
                'min_order'  => 200000,
                'max_uses'   => 100,
                'used_count' => 0,
                'active'     => true,
                'expires_at' => now()->addYear(),
            ],
            [
                'code'       => 'SAVE100K',
                'type'       => 'fixed',
                'value'      => 100000,
                'min_order'  => 500000,
                'max_uses'   => 50,
                'used_count' => 0,
                'active'     => true,
                'expires_at' => now()->addMonths(6),
            ],
            [
                'code'       => 'SPORT20',
                'type'       => 'percent',
                'value'      => 20,
                'min_order'  => 800000,
                'max_uses'   => 30,
                'used_count' => 0,
                'active'     => true,
                'expires_at' => now()->addMonths(3),
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(['code' => $coupon['code']], $coupon);
        }
    }
}