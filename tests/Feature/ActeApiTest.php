<?php
 
namespace Tests\Feature;
 
use App\Models\User;
use App\Models\Acte;
use App\Models\Huissier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
 
class ActeApiTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_can_list_actes_authenticated(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
 
        $huissier = Huissier::create([
            'name' => 'John Doe',
            'email' => 'john@bailiff.com',
            'phone' => '123456789',
        ]);
 
        Acte::create([
            'huissier_id' => $huissier->id,
            'reference' => 'ACTE-2023-001',
            'type' => 'Notification',
            'status' => 'Draft',
            'objet' => 'Test Act',
            'date_depot' => now(),
        ]);
 
        $response = $this->getJson('/api/actes');
 
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonPath('0.reference', 'ACTE-2023-001');
    }
 
    public function test_cannot_list_actes_unauthenticated(): void
    {
        $response = $this->getJson('/api/actes');
        $response->assertStatus(401);
    }
}
