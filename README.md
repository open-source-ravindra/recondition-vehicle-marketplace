# recondition-vehicle-marketplace

A powerful, open-source Laravel-based marketplace platform designed specifically for reconditioning houses and resellers to manage and sell bikes and automobiles online.

## ✨ Features

*   **Multi-role User System:** Admin, Reconditioning House/Dealer, and Buyer.
*   **Advanced Listings Management:** Create, edit, publish, and expire vehicle ads.
*   **Vehicle Inventory:** Detailed specs (Make, Model, Year, Mileage, VIN, Reconditioning details).
*   **Image Galleries:** Multiple image uploads for each vehicle.
*   **Inquiry & Contact System:** Buyers can contact sellers directly.
*   **Search & Filtering:** Filter by price, vehicle type, brand, year, location, etc.
*   **Admin Dashboard:** Manage users, listings, categories, and site settings.
*   **Responsive Design:** Works on all devices (mention if you use a CSS framework like Tailwind/Bootstrap).

## 🚀 Live Demo

**Admin Credentials:** admin@example.com / password
**Dealer Credentials:** dealer@example.com / password

## 📋 Prerequisites

*   PHP >= 8.2
*   Composer
*   Node.js & NPM (if using frontend scaffolding)
*   MySQL/PostgreSQL/SQLite

## ⚙️ Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/open-source-ravindra/recondition-vehicle-marketplace
    cd your-repo-name
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Setup Environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    Edit `.env` with your database credentials.

4.  **Run Migrations & Seeders (for dummy data):**
    ```bash
    php artisan migrate --seed
    ```

5.  **Install NPM dependencies (if any):**
    ```bash
    npm install && npm run build
    ```

6.  **Start the development server:**
    ```bash
    php artisan serve
    ```
    Visit `http://localhost:8000`

## 🧑‍💻 Default Login Credentials (from Seeder)

*   **Admin:** `admin@example.com` / `password`
*   **Dealer/Reconditioner:** `dealer@example.com` / `password`
*   **Buyer:** `buyer@example.com` / `password`


