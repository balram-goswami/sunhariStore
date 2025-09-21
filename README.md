
# 🛍️ Laravel eCommerce Platform

This is a custom-built Laravel eCommerce system with admin, vendor, and Customer dashboards. This guide will help you set up the project on your local or production environment.

---

## 🚀 Project Features

- Admin & Vendor Panel (Filament)
- User Frontend (Blade)
- Product & Category Management
- Orders, Cart, Wishlist
- Coupon System
- Address Book & Saved Cards
- Laravel Breeze Auth + Custom Customer Login

---

## 🛠️ Tech Stack

- Laravel 12+
- PHP 8.2+
- MySQL / pgsql
- Filament Admin v3
- Bootstrap (Frontend)
- Livewire (Cart/Wishlist)
- Laravel Breeze (Auth)

---

## ⚙️ Installation Steps

### 1. 📦 Clone the Repository

Backend
```bash
git clone http://www.brownmfgdigital.team/BonoboGit/LinxWebStore_Admin.git
cd your-repo-name
```
FrontEnd
```bash
git clone http://www.brownmfgdigital.team/BonoboGit/LinxWebStore_Tenant.git
cd your-repo-name
```

### 2. 📂 Install Dependencies

```bash
composer install
npm install && npm run build
```
if any error than use 
```bash
composer install --ignore-platform-reqs
```

### 3. 🧪 Copy `.env` File

```bash
cp .env.example .env
```

### 4. 🔑 Set Environment Values

Edit the `.env` file:

```env
APP_NAME="Brown Digital"
APP_URL=http://localhost:8000

DB_DATABASE=your_database
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_pass
```

> ✅ **Optional**: Set mail, Stripe/PayPal, and other environment configs here.

### 5. 🗃️ Generate App Key

```bash
php artisan key:generate
```

### 6. 🛠️ Migrate & Seed Database

```bash
php artisan migrate --path=database\migrations\landlord
php artisan migrate
php artisan migrate --seed
```

> Seeding creates default roles, admin user, and sample products.

### 7. 📤 Storage Link (for images)

```bash
php artisan storage:link
```

### 8. 🏃 Run the Server

```bash
php artisan serve
```

Visit: [http://localhost:8000](http://localhost:8000)

---

## 🧑‍💻 Admin & Panel Login

| Role   | Email              | Password    |
|--------|--------------------|-------------|
| Admin  | admin@gmail.com    | admin@123   |
| Vendor | vendor@gmail.com   | vendor@123  |

---

## 📂 Folder Structure Highlights

| Folder            | Purpose                                |
|-------------------|----------------------------------------|
| `/app/Models`     | All Eloquent models                    |
| `/resources/views`| Blade templates for frontend           |
| `/app/Filament`   | Filament resources and pages           |
| `/routes`         | Web and API routes                     |
| `/database/seeders` | Data seeders for roles/products     |

---

## 🔧 Useful Artisan Commands

```bash
php artisan migrate:fresh --seed     # Reset DB
php artisan make:model ModelName     # Create model
php artisan make:controller Name     # Create controller
php artisan optimize:clear           # Clear cache/config
```

## 📞 Support

For setup issues or custom changes, contact the developer:

**Name:** ------  
**Email:** your@email.com  
**Phone:** +91-XXXXXXXXXX  
**Support Hours:** Mon–Fri, 10am–6pm IST

---
