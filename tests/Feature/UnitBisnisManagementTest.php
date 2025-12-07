<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UnitBisnis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitBisnisManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can view unit bisnis list
     */
    public function test_admin_can_view_unit_bisnis_list(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/unit-bisnis');

        $response->assertStatus(200);
        $response->assertViewIs('admin.unit-bisnis.index');
    }

    /**
     * Test admin can view create unit bisnis form
     */
    public function test_admin_can_view_create_unit_bisnis_form(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/unit-bisnis/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.unit-bisnis.create');
    }

    /**
     * Test admin can create unit bisnis
     */
    public function test_admin_can_create_unit_bisnis(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/unit-bisnis', [
            'nama_unit_bisnis' => 'IT Department',
        ]);

        $response->assertRedirect('/admin/unit-bisnis');
        $this->assertDatabaseHas('unit_bisnis', [
            'nama_unit_bisnis' => 'IT Department',
        ]);
    }

    /**
     * Test admin can view unit bisnis details
     */
    public function test_admin_can_view_unit_bisnis_details(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $unitBisnis = UnitBisnis::factory()->create();

        $response = $this->actingAs($admin)->get("/admin/unit-bisnis/{$unitBisnis->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.unit-bisnis.show');
    }

    /**
     * Test admin can view edit unit bisnis form
     */
    public function test_admin_can_view_edit_unit_bisnis_form(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $unitBisnis = UnitBisnis::factory()->create();

        $response = $this->actingAs($admin)->get("/admin/unit-bisnis/{$unitBisnis->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.unit-bisnis.edit');
    }

    /**
     * Test admin can update unit bisnis
     */
    public function test_admin_can_update_unit_bisnis(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $unitBisnis = UnitBisnis::factory()->create([
            'nama_unit_bisnis' => 'Old Name',
        ]);

        $response = $this->actingAs($admin)->put("/admin/unit-bisnis/{$unitBisnis->id}", [
            'nama_unit_bisnis' => 'Updated Name',
        ]);

        $response->assertRedirect('/admin/unit-bisnis');
        $this->assertDatabaseHas('unit_bisnis', [
            'id' => $unitBisnis->id,
            'nama_unit_bisnis' => 'Updated Name',
        ]);
    }

    /**
     * Test admin can delete unit bisnis
     */
    public function test_admin_can_delete_unit_bisnis(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $unitBisnis = UnitBisnis::factory()->create();

        $response = $this->actingAs($admin)->delete("/admin/unit-bisnis/{$unitBisnis->id}");

        $response->assertRedirect('/admin/unit-bisnis');
        $this->assertDatabaseMissing('unit_bisnis', [
            'id' => $unitBisnis->id,
        ]);
    }

    /**
     * Test unit bisnis creation validation - nama required
     */
    public function test_unit_bisnis_creation_requires_nama(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/unit-bisnis', [
        ]);

        $response->assertSessionHasErrors('nama_unit_bisnis');
    }

    /**
     * Test unit bisnis creation validation - nama must be unique
     */
    public function test_unit_bisnis_creation_requires_unique_name(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        UnitBisnis::factory()->create(['nama_unit_bisnis' => 'IT Department']);

        $response = $this->actingAs($admin)->post('/admin/unit-bisnis', [
            'nama_unit_bisnis' => 'IT Department',
        ]);

        $response->assertSessionHasErrors('nama_unit_bisnis');
    }

    /**
     * Test unit bisnis creation works with minimal required fields
     */
    public function test_unit_bisnis_creation_with_minimal_fields(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/unit-bisnis', [
            'nama_unit_bisnis' => 'IT Department',
        ]);

        $response->assertRedirect('/admin/unit-bisnis');
        $this->assertDatabaseHas('unit_bisnis', [
            'nama_unit_bisnis' => 'IT Department',
        ]);
    }

    /**
     * Test non-admin cannot access unit bisnis management
     */
    public function test_non_admin_cannot_access_unit_bisnis_management(): void
    {
        $user = User::factory()->create(['role' => 'Mahasiswa']);

        $response = $this->actingAs($user)->get('/admin/unit-bisnis');

        $response->assertStatus(403);
    }
}
