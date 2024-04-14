<?php

namespace Tests\Feature;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_all_countries()
    {
        // Arrange
        $post = Country::factory()->create();

        // Act
        $response = $this->get('/parametre/countries');

        // Assert
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }
}
