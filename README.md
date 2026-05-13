# Barber Shop Appointment System

A comprehensive Laravel-based appointment booking system designed for barber shops. Customers can book appointments with their preferred barbers, manage their bookings, and join a waiting list when slots are full. Barbers can accept or decline appointments, and admins can manage services and block time slots.

## Installation

1. Clone the repository and navigate to the project directory:

    ```bash
    cd app/barber-shop-appointment-system
    ```

2. Install PHP dependencies:

    ```bash
    composer install
    ```

3. Install JavaScript dependencies:

    ```bash
    npm install
    # or use pnpm
    pnpm install
    ```

    After installing dependencies, build the frontend assets so Vite has the generated files it needs:

    ```bash
    pnpm run build
    ```

4. Copy the environment configuration file:

    ```bash
    cp .env.example .env
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Configure your database in the `.env` file:

    Ensure XAMPP MySQL server is running, then update the following environment variables in `.env`:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=barber_shop_appointment
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7. Run migrations and seed the database:
    ```bash
    php artisan migrate --seed
    ```

## Demo Accounts

After seeding the database, you can use these sample accounts to sign in:

- Lead barber
    - Email: barber@barbershop.test
    - Password: password
- Admin
    - Email: admin@barbershop.test
    - Password: password
- Junior barber
    - Email: barber2@barbershop.test
    - Password: password

Customer accounts are not pre-seeded. You can create one yourself using the registration form.

## Running the Application

Start the development server:

```bash
php artisan serve
```

If you change any frontend assets or if Vite complains about missing build output, run `pnpm run build` again before refreshing the app.

In a separate terminal, compile and watch frontend assets:

```bash
npm run dev
# or
pnpm dev
```

The application will be available at `http://localhost:8000`

## Features

- User role-based access control (Customer, Barber, Admin)
- Real-time appointment booking with barber preference
- Automatic waiting list management when slots are full
- Appointment acceptance/decline workflow
- Service management and scheduling
- Time block management for barbers
- Appointment cancellation and rescheduling
- Calendar view integration with Livewire

## Testing

Run the test suite:

```bash
php artisan test
```

## Tech Stack

- Laravel 11
- Livewire for real-time components
- Blade templating with Flux UI components
- Tailwind CSS for styling
- Lucide React icons
- MySQL database
- Vite for asset bundling
- PHPUnit for testing

## Architecture

- Role-based middleware for access control
- Models: User, Appointment, Service, AvailabilityBlock, WaitingListEntry
- Controllers handle booking logic, availability calculations, and appointment management
- Database migrations tracked in `database/migrations/`
- Feature tests in `tests/Feature/`

## License

This project is open source and licensed under the MIT License.
