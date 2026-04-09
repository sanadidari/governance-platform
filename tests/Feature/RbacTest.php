<?php

namespace Tests\Feature;

use App\Models\Acte;
use App\Models\Huissier;
use App\Models\Region;
use App\Models\Tribunal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    // ─── Helpers ────────────────────────────────────────────────────────────────

    private function createRegion(string $name = 'Casablanca-Settat'): Region
    {
        return Region::create(['name' => $name, 'code' => strtoupper(substr($name, 0, 3))]);
    }

    private function createTribunal(Region $region, string $name = 'TPI Casablanca'): Tribunal
    {
        return Tribunal::create([
            'region_id' => $region->id,
            'name'      => $name,
            'type'      => 'TPI',
            'code'      => 'TPI-CAS',
        ]);
    }

    private function createHuissier(Tribunal $tribunal, string $nom = 'Alami'): Huissier
    {
        return Huissier::create([
            'tribunal_id' => $tribunal->id,
            'nom'         => $nom,
            'prenom'      => 'Mohamed',
            'email'       => strtolower($nom) . '@test.ma',
            'status'      => 'active',
        ]);
    }

    private function createActe(Huissier $huissier, string $reference = 'ACTE-2026-001'): Acte
    {
        return Acte::create([
            'huissier_id' => $huissier->id,
            'reference'   => $reference,
            'type'        => 'notification',
            'status'      => 'pending',
            'objet'       => 'Acte de test',
            'date_depot'  => now()->toDateString(),
        ]);
    }

    private function createUser(string $role, ?Huissier $huissier = null, ?Region $region = null): User
    {
        return User::factory()->create([
            'role'        => $role,
            'huissier_id' => $huissier?->id,
            'region_id'   => $region?->id,
            'status'      => 'active',
        ]);
    }

    // ─── GET /api/actes ──────────────────────────────────────────────────────────

    public function test_unauthenticated_user_cannot_list_actes(): void
    {
        $this->getJson('/api/actes')->assertStatus(401);
    }

    public function test_super_admin_sees_all_actes(): void
    {
        $region    = $this->createRegion();
        $tribunal  = $this->createTribunal($region);
        $huissier1 = $this->createHuissier($tribunal, 'Alami');
        $huissier2 = $this->createHuissier($tribunal, 'Benali');

        $this->createActe($huissier1, 'ACTE-001');
        $this->createActe($huissier2, 'ACTE-002');

        $admin = $this->createUser('super_admin');
        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/actes');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data') ?? $response->json());
    }

    public function test_huissier_sees_only_own_actes(): void
    {
        $region    = $this->createRegion();
        $tribunal  = $this->createTribunal($region);
        $huissier1 = $this->createHuissier($tribunal, 'Alami');
        $huissier2 = $this->createHuissier($tribunal, 'Benali');

        $this->createActe($huissier1, 'ACTE-001');
        $this->createActe($huissier2, 'ACTE-002');

        $user = $this->createUser('huissier', $huissier1);
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/actes');

        $response->assertStatus(200);
        $data = $response->json('data') ?? $response->json();
        $this->assertCount(1, $data);
        $this->assertEquals('ACTE-001', $data[0]['reference']);
    }

    public function test_huissier_without_binding_sees_all_actes(): void
    {
        $region   = $this->createRegion();
        $tribunal = $this->createTribunal($region);
        $huissier = $this->createHuissier($tribunal, 'Alami');

        $this->createActe($huissier, 'ACTE-001');
        $this->createActe($huissier, 'ACTE-002');

        // User with no huissier_id → no filter applied
        $user = $this->createUser('national_admin');
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/actes');

        $response->assertStatus(200);
        $data = $response->json('data') ?? $response->json();
        $this->assertCount(2, $data);
    }

    // ─── PATCH /api/actes/{id}/status ───────────────────────────────────────────

    public function test_huissier_can_update_own_acte_status(): void
    {
        $region   = $this->createRegion();
        $tribunal = $this->createTribunal($region);
        $huissier = $this->createHuissier($tribunal, 'Alami');
        $acte     = $this->createActe($huissier);

        $user = $this->createUser('huissier', $huissier);
        Sanctum::actingAs($user);

        $response = $this->patchJson("/api/actes/{$acte->id}/status", [
            'status' => 'in_progress',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('actes', [
            'id'     => $acte->id,
            'status' => 'in_progress',
        ]);
    }

    public function test_huissier_cannot_update_another_huissiers_acte(): void
    {
        $region    = $this->createRegion();
        $tribunal  = $this->createTribunal($region);
        $huissier1 = $this->createHuissier($tribunal, 'Alami');
        $huissier2 = $this->createHuissier($tribunal, 'Benali');
        $acte      = $this->createActe($huissier2); // belongs to huissier2

        $user = $this->createUser('huissier', $huissier1); // logged in as huissier1
        Sanctum::actingAs($user);

        $response = $this->patchJson("/api/actes/{$acte->id}/status", [
            'status' => 'completed',
        ]);

        $response->assertStatus(403);
    }

    public function test_super_admin_can_update_any_acte_status(): void
    {
        $region   = $this->createRegion();
        $tribunal = $this->createTribunal($region);
        $huissier = $this->createHuissier($tribunal, 'Alami');
        $acte     = $this->createActe($huissier);

        $admin = $this->createUser('super_admin');
        Sanctum::actingAs($admin);

        $response = $this->patchJson("/api/actes/{$acte->id}/status", [
            'status' => 'completed',
        ]);

        $response->assertStatus(200);
    }

    public function test_status_update_rejects_invalid_status(): void
    {
        $region   = $this->createRegion();
        $tribunal = $this->createTribunal($region);
        $huissier = $this->createHuissier($tribunal, 'Alami');
        $acte     = $this->createActe($huissier);

        $user = $this->createUser('huissier', $huissier);
        Sanctum::actingAs($user);

        $this->patchJson("/api/actes/{$acte->id}/status", [
            'status' => 'statut_invalide',
        ])->assertStatus(422);
    }
}
