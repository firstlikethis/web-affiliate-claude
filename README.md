affiliate-website/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── ArticleController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── TagController.php
│   │   │   │   └── UserController.php
│   │   │   ├── ArticleController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProductController.php
│   │   │   └── RedirectController.php
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── Article.php
│   │   ├── Category.php
│   │   ├── ClickLog.php
│   │   ├── Product.php
│   │   ├── Tag.php
│   │   └── User.php
├── database/
│   ├── migrations/
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2023_01_01_000001_create_categories_table.php
│   │   ├── 2023_01_01_000002_create_products_table.php
│   │   ├── 2023_01_01_000003_create_articles_table.php
│   │   ├── 2023_01_01_000004_create_tags_table.php
│   │   ├── 2023_01_01_000005_create_taggables_table.php
│   │   └── 2023_01_01_000006_create_click_logs_table.php
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── articles/
│       │   ├── categories/
│       │   ├── dashboard/
│       │   ├── products/
│       │   ├── tags/
│       │   └── users/
│       ├── articles/
│       ├── components/
│       ├── layouts/
│       ├── products/
│       └── home/
└── routes/
    └── web.php

# ขั้นตอนการสร้าง Views

ต่อไปนี้คือรายการของไฟล์ Views ที่จำเป็นต้องสร้างตามโครงสร้างที่วางแผนไว้:

## 1. Layouts
```
resources/views/layouts/
├── app.blade.php         # สำหรับหน้าบ้าน
├── admin.blade.php       # สำหรับหลังบ้าน
└── auth.blade.php        # สำหรับหน้า login/register
```

## 2. Components
```
resources/views/components/
├── header.blade.php
├── footer.blade.php
├── sidebar.blade.php      # สำหรับเมนูหลังบ้าน
├── product-card.blade.php
├── article-card.blade.php
├── pagination.blade.php
├── alerts.blade.php       # สำหรับแสดงข้อความแจ้งเตือน
└── search-form.blade.php
```

## 3. หน้าบ้าน (Frontend)
```
resources/views/
├── home/
│   ├── index.blade.php
│   ├── category-products.blade.php
│   ├── category-articles.blade.php
│   ├── tag.blade.php
│   └── search.blade.php
├── products/
│   └── index.blade.php
└── articles/
    ├── index.blade.php
    └── show.blade.php
```

## 4. หลังบ้าน (Admin)
```
resources/views/admin/
├── dashboard/
│   └── index.blade.php
├── products/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── articles/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── categories/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── tags/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── users/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php
```

## 5. Authentication
```
resources/views/auth/
├── login.blade.php
└── register.blade.php
```

# ติดตั้ง Laravel และสร้างโปรเจค
composer create-project laravel/laravel affiliate-website

# เข้าไปยังโฟลเดอร์โปรเจค
cd affiliate-website

# ติดตั้ง Tailwind CSS
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

# สร้าง Models
php artisan make:model Category -m
php artisan make:model Product -m
php artisan make:model Article -m
php artisan make:model Tag -m
php artisan make:model ClickLog -m

# สร้าง Controllers
php artisan make:controller HomeController
php artisan make:controller ProductController
php artisan make:controller ArticleController
php artisan make:controller RedirectController

# สร้าง Admin Controllers
php artisan make:controller Admin/DashboardController
php artisan make:controller Admin/UserController
php artisan make:controller Admin/ProductController
php artisan make:controller Admin/ArticleController
php artisan make:controller Admin/CategoryController
php artisan make:controller Admin/TagController

# สร้าง Requests สำหรับ Validation
php artisan make:request StoreProductRequest
php artisan make:request UpdateProductRequest
php artisan make:request StoreArticleRequest
php artisan make:request UpdateArticleRequest
php artisan make:request StoreCategoryRequest
php artisan make:request UpdateCategoryRequest
php artisan make:request StoreTagRequest
php artisan make:request UpdateTagRequest

# สร้าง Middleware สำหรับตรวจสอบสิทธิ์
php artisan make:middleware AdminMiddleware