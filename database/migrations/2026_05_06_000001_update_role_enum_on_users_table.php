<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role VARCHAR(20) NOT NULL DEFAULT 'customer'");
            DB::statement("UPDATE users SET role = 'customer' WHERE role = 'user'");
            DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'barber', 'admin') NOT NULL DEFAULT 'customer'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role VARCHAR(20) NOT NULL DEFAULT 'user'");
            DB::statement("UPDATE users SET role = 'user' WHERE role = 'customer'");
            DB::statement("UPDATE users SET role = 'admin' WHERE role = 'barber'");
            DB::statement("ALTER TABLE users MODIFY role ENUM('user', 'admin') NOT NULL DEFAULT 'user'");
        }
    }
};