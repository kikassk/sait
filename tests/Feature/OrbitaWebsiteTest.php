<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrbitaWebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('ОРБИТА');
        $response->assertSee('Двигайся вместе с');
        $response->assertSee('Балконная Галерея');
        $response->assertSee('Орбитальность');
    }

    public function test_table_booking_can_be_submitted_successfully()
    {
        $bookingData = [
            'name' => 'Алексей Иванов',
            'phone' => '+7 (999) 111-22-33',
            'email' => 'alexey@example.com',
            'date' => date('Y-m-d', strtotime('+1 day')),
            'time' => '20:00',
            'guests' => 4,
            'zone' => 'Каминная Гостиная',
            'comment' => 'Столик у окна пожалуйста'
        ];

        $response = $this->postJson('/api/bookings', $bookingData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('bookings', [
            'name' => 'Алексей Иванов',
            'phone' => '+7 (999) 111-22-33',
            'zone' => 'Каминная Гостиная'
        ]);
    }

    public function test_table_booking_fails_validation_for_missing_required_fields()
    {
        $response = $this->postJson('/api/bookings', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'phone', 'date', 'time', 'guests', 'zone']);
    }
}
