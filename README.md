# Skripsi Ihsan

This is a Laravel project.

## Stack

*   PHP >= 8.2
*   Laravel Framework 12.0
*   barryvdh/laravel-dompdf: ^3.1
*   intervention/image: ^3.11
*   milon/barcode: ^12.0
*   spatie/laravel-permission: ^6.20
*   Bootstrap

## Features

*   Authentication (login, register, logout)
*   User profile management (view, update profile, update password)
*   Dashboard
*   User management (view, create, update, delete)
*   Role and permission management (create, update, delete roles and permissions)
*   Resident management (view, create, update)
*   Document type management (view, create, update, delete)
*   Document field management (view, create, update, delete)
*   Document generation (create, edit, download)
*   Document approval (approve, reject, sign)

## Installation

1.  Clone the repository:

    ```bash
    git clone https://github.com/sulthanalif/skripsi-ihsan.git project-ihsan
    ```
    ```bash
    cd project-ihsan
    ```

2.  Install PHP dependencies:

    ```bash
    composer install
    ```

3.  Copy the `.env.example` file to `.env` and configure your database settings:

    ```bash
    cp .env.example .env
    ```

    Edit the `.env` file with your database credentials.

4.  Generate application key:

    ```bash
    php artisan key:generate
    ```

5.  Generate application key:

     ```bash
     php artisan key:generate
     ```

6.  Create the symbolic link from `public/storage` to `storage/app/public`:

    ```bash
    php artisan storage:link
    ```

7.  Run database migrations:

     ```bash
     php artisan migrate
     ```

8.  Seed the database (optional):

    ```bash
    php artisan db:seed
    ```

9.  Start the development server:

    ```bash
    php artisan serve
    ```

## Usage

1.  **Authentication:**

    *   Register a new account via the `/register` route.
    *   Log in with your credentials via the `/login` route.
    *   Log out via the `/logout` route.

2.  **User Profile Management:**

    *   View your profile information via the `/profile` route.
    *   Update your profile information via the `/profile` route.
    *   Update your password via the `/password` route.

3.  **Dashboard:**

    *   Access the dashboard via the `/dashboard` route.

4.  **Master Data Management (requires appropriate permissions):**

    *   Manage users via the `/master/users` route.
    *   Manage roles and permissions via the `/master/role-permission` route.
    *   Manage residents via the `/master/resident` route.
    *   Manage document types via the `/master/document/document-type` route.
    *   Manage document fields via the `/master/document/document-field` route.

5.  **Document Generation:**

    *   Generate documents via the `/document/generate` route.

6.  **Document Approval:**

    *   Approve, reject, or sign documents via the `/document/approval/{document}` route.