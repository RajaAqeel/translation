<?php

namespace Tests\Feature;

use App\Models\Translation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TranslationApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        Sanctum::actingAs(User::factory()->create());
    }

    public function test_can_create_translation()
    {
        $this->authenticate();

        $data = [
            'key' => 'greeting',
            'locale' => 'en',
            'value' => 'Hello',
            'tags' => ['web', 'mobile']
        ];

        $response = $this->postJson('/api/translations', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['key' => 'greeting']);

        $this->assertDatabaseHas('translations', ['key' => 'greeting', 'locale' => 'en']);
    }

    public function test_can_update_translation()
    {
        $this->authenticate();

        $translation = Translation::factory()->create();

        $data = [
            'key' => $translation->key,
            'locale' => $translation->locale,
            'value' => 'Updated value',
            'tags' => ['desktop']
        ];

        $response = $this->putJson("/api/translations/{$translation->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['value' => 'Updated value']);
    }

    public function test_can_list_translations()
    {
        $this->authenticate();

        Translation::factory()->count(5)->create();

        $response = $this->getJson('/api/translations');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_can_search_by_key()
    {
        $this->authenticate();

        Translation::factory()->create(['key' => 'welcome_message']);

        $response = $this->getJson('/api/translations?key=welcome');

        $response->assertStatus(200)
                 ->assertJsonFragment(['key' => 'welcome_message']);
    }

    public function test_can_filter_by_tags()
    {
        $this->authenticate();

        Translation::factory()->create(['tags' => ['web']]);
        Translation::factory()->create(['tags' => ['mobile']]);

        $response = $this->getJson('/api/translations?tags=web');

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data');
    }

    public function test_can_export_translations_by_locale()
    {
        $this->authenticate();

        Translation::factory()->create(['locale' => 'en', 'key' => 'logout', 'value' => 'Log Out']);

        $response = $this->getJson('/api/translations/export/en');

        $response->assertStatus(200)
                 ->assertJsonFragment(['logout' => 'Log Out']);
    }

    public function test_validation_errors_when_creating()
    {
        $this->authenticate();

        $response = $this->postJson('/api/translations', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['key', 'locale', 'value']);
    }
}
