# GitHub Open Issues List (PHP, Laravel, Inertia, Vue)

A Laravel-based project that lists GitHub issues assigned to the authenticated user, leveraging PHP, Laravel, Inertia, and Vue.

---

## ▶️ How to Run

1. Clone the repository
    ```bash
    git clone git@github.com:lrencallado/github-issues-list.git
    ```
2. Navigate to the project directory
    ```bash
    cd github-issues-list
    ```
3. Install dependencies using Composer
    ```bash
    composer install
    ```
4. Install node packages
    ```bash
    npm install
    ```
5. Copy the `.env.example` file to `.env` or to `.env.local` (if not existing):
    ```bash
    cp .env.example .env
    ```
    or
    ```bash
    cp .env.example .env.local
    ```
6. Update the `.env` file with your database credentials (if using MySQL):
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```
7. Generate the application key (if `APP_KEY` from `.env` is null):
    ```bash
    php artisan key:generate
    ```
8. Run database migrations and seeder:
    ```bash
    php artisan migrate --seed
    ```
8. Run on local:
    ```bash
    composer run dev
    ```

---

## Test User

Email: test@example.com

Password: password
