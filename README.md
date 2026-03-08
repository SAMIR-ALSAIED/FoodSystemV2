# 🍽️ FoodSystem - Restaurant Management System

Web‑based Restaurant Management System built with **Laravel, PHP & MySQL** to manage tables, menu items, orders, users, and billing.

## 🚀 Features

- User & Role Management (Admin / Waiter / Cashier)  
- Add / Edit / Delete Categories, Menu Items, Products  
- Table Management and Reservations  
- Order Processing (Quick and Scheduled)  
- Admin Dashboard with Stats  
- Billing & Print Invoices


## 📥 Installation / Setup (Local)

1. **Clone the repository**  
```bash
git clone https://github.com/SAMIR-ALSAIED/FoodSystem.git

composer install
npm install && npm run dev
cp .env.example .env

php artisan key:generate

------------------------------------
Run Migrations & Seed Data
php artisan migrate --seed
-------------------------
Start the server:
php artisan serve


