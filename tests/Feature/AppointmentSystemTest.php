<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\AvailabilityBlock;
use App\Models\Service;
use App\Models\User;
use App\Models\WaitingListEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_book_an_available_slot(): void
    {
        $customer = User::factory()->customer()->create();
        $barber = User::factory()->barber()->create();
        $service = Service::query()->create([
            'name' => 'Classic Haircut',
            'description' => 'Quick trim',
            'duration_minutes' => 30,
            'price' => 15,
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)->post(route('appointments.store'), [
            'service_id' => $service->id,
            'scheduled_at' => now()->addDay()->setTime(10, 0)->toDateTimeString(),
            'barber_id' => $barber->id,
            'notes' => 'Please keep it low.',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('appointments', [
            'user_id' => $customer->id,
            'barber_id' => $barber->id,
            'service_id' => $service->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_customer_is_added_to_waiting_list_when_slot_is_full(): void
    {
        $customer = User::factory()->customer()->create();
        $secondCustomer = User::factory()->customer()->create();
        $barber = User::factory()->barber()->create();
        $service = Service::query()->create([
            'name' => 'Beard Trim',
            'description' => 'Quick trim',
            'duration_minutes' => 30,
            'price' => 10,
            'is_active' => true,
        ]);
        $slot = now()->addDay()->setTime(11, 0);

        Appointment::query()->create([
            'user_id' => $customer->id,
            'barber_id' => $barber->id,
            'service_id' => $service->id,
            'scheduled_at' => $slot,
            'ends_at' => $slot->copy()->addMinutes(30),
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($secondCustomer)->post(route('appointments.store'), [
            'service_id' => $service->id,
            'scheduled_at' => $slot->toDateTimeString(),
            'barber_id' => $barber->id,
            'notes' => 'Any slot is fine.',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('waiting_list_entries', [
            'user_id' => $secondCustomer->id,
            'service_id' => $service->id,
            'status' => 'waiting',
        ]);
    }

    public function test_admin_can_block_a_time_slot(): void
    {
        $admin = User::factory()->admin()->create();
        $barber = User::factory()->barber()->create();

        $response = $this->actingAs($admin)->post(route('admin.availability-blocks.store'), [
            'barber_id' => $barber->id,
            'starts_at' => now()->addDay()->setTime(12, 0)->toDateTimeString(),
            'ends_at' => now()->addDay()->setTime(13, 0)->toDateTimeString(),
            'reason' => 'Lunch break',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('availability_blocks', [
            'barber_id' => $barber->id,
            'reason' => 'Lunch break',
        ]);
    }
}
