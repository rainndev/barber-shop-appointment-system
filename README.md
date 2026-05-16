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

## Preview (Desktop)

### Guest

<div align="center">
  <table>
    <tr>
      <td align="center"><img width="400" alt="register" src="https://github.com/user-attachments/assets/b4bd526a-5cbf-4e6a-ac93-db8e6fc644e9" /></td>
      <td align="center"><img width="400" alt="log-in" src="https://github.com/user-attachments/assets/6645f6a4-3119-4dbb-9e24-47799387b1b3" /></td>
    </tr>
    <tr>
      <td align="center"><img width="400" alt="landing-hero" src="https://github.com/user-attachments/assets/d45d95d2-3e45-4300-b9fd-d511d66d4e9a" /></td>
      <td align="center"><img width="400" alt="landing-services" src="https://github.com/user-attachments/assets/a1afcd60-51e0-4d39-a7f7-8601c0577ccf" /></td>
    </tr>
    <tr>
      <td align="center" colspan="2"><img width="400" alt="landing-footer" src="https://github.com/user-attachments/assets/110e1f75-8b10-44d5-bbb5-1c7198086466" /></td>
    </tr>
  </table>
</div>

---

### Customer

<div align="center">
  <table>
    <tr>
      <td align="center"><img width="400" alt="dashboard-calendar" src="https://github.com/user-attachments/assets/5938b177-3bac-4532-9a76-289bca9fc057" /></td>
      <td align="center"><img width="400" alt="dashboard-w-confirmed-visits-and-waitinglist" src="https://github.com/user-attachments/assets/b5819ece-1211-4fec-bd6a-00f5fb5cc24c" /></td>
    </tr>
    <tr>
      <td align="center"><img width="400" alt="appointments" src="https://github.com/user-attachments/assets/417db071-8d5d-4580-a4f9-a059b52db320" /></td>
      <td align="center"><img width="400" alt="appointment-details" src="https://github.com/user-attachments/assets/8fa83291-0821-4e50-be92-dbe544a8267f" /></td>
    </tr>
    <tr>
      <td align="center"><img width="400" alt="appointments-modal" src="https://github.com/user-attachments/assets/42b6f2d7-0bc7-4fc8-8638-2762d23b00fa" /></td>
      <td align="center"><img width="400" alt="profile" src="https://github.com/user-attachments/assets/9fcd9114-50fe-40fe-b7df-9e50f640f59d" /></td>
    </tr>
  </table>
</div>

---

### Admin

<div align="center">
  <table>
    <tr>
      <td align="center"><img width="400" alt="dashboard" src="https://github.com/user-attachments/assets/1b4169be-c3dc-4287-b76e-dc6b2c1d7e90" /></td>
      <td align="center"><img width="400" alt="barber-approval" src="https://github.com/user-attachments/assets/30b25ab2-9b0c-4d3e-8e07-536d433a43ad" /></td>
    </tr>
    <tr>
      <td align="center"><img width="400" alt="active-user-list" src="https://github.com/user-attachments/assets/5e5bd8f0-f22c-417a-8e94-85389f687c36" /></td>
      <td align="center"><img width="400" alt="pending-approved-user-list" src="https://github.com/user-attachments/assets/deeb6a07-b4e8-431e-ad76-4b7e4ba7f9d9" /></td>
    </tr>
    <tr>
      <td align="center" colspan="2"><img width="300" alt="delete-modal" src="https://github.com/user-attachments/assets/766508ad-aa2a-4da8-a6ce-efbaa2070804" /></td>
    </tr>
    <tr>
      <td align="center" colspan="2"><img width="400" alt="profile" src="https://github.com/user-attachments/assets/1d588777-0c5f-4557-bc10-4a3ef197ff68" /></td>
    </tr>
  </table>
</div>

---

### Barber

<div align="center">
  <table>
    <tr>
      <td align="center"><img width="400" alt="dashboard-with-service-creation" src="https://github.com/user-attachments/assets/32ca9703-759a-469c-9fec-ab9ecb4ee4e1" /></td>
      <td align="center"><img width="400" alt="dashboard-with-pending-appointments" src="https://github.com/user-attachments/assets/e9568f34-a77b-47fc-a04e-e533d6bdc6f1" /></td>
    </tr>
    <tr>
      <td align="center" colspan="2"><img width="400" alt="profile" src="https://github.com/user-attachments/assets/0ac2a9b3-8893-4c1c-8525-efe932c3059c" /></td>
    </tr>
  </table>
</div>



