<?php

namespace Tests\Feature;

use App\Models\Booking;
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
        $response->assertSee('Пространство');
        $response->assertSee('Забронировать');
    }

    public function test_menu_page_loads_successfully()
    {
        $response = $this->get('/menu');

        $response->assertStatus(200);
        $response->assertSee('МЕНЮ');
        $response->assertSee('ОРБИТА');
        $response->assertSee('Авторская Миксология');
        $response->assertSee('Гастрономия &amp; Авторские Тапас', false);
        $response->assertSee('Орбита T-15 Kinetic');
    }

    public function test_table_booking_can_be_submitted_successfully()
    {
        $response = $this->postJson('/api/bookings', [
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'date' => now()->addDays(2)->format('Y-m-d'),
            'time' => '19:00',
            'guests' => 4,
            'zone' => 'Главный Бар',
            'comment' => 'Просьба у окна'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('bookings', [
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'zone' => 'Главный Бар',
            'guests' => 4
        ]);
    }

    public function test_table_booking_fails_validation_for_missing_required_fields()
    {
        $response = $this->postJson('/api/bookings', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'phone', 'date', 'time', 'guests', 'zone']);
    }
}
