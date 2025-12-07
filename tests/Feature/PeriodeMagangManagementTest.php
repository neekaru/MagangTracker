<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PeriodeMagang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeriodeMagangManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can view periode magang list
     */
    public function test_admin_can_view_periode_magang_list(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/periode-magang');

        $response->assertStatus(200);
        $response->assertViewIs('admin.periode.index');
    }

    /**
     * Test admin can view create periode magang form
     */
    public function test_admin_can_view_create_periode_magang_form(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/periode-magang/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.periode.create');
    }

    /**
     * Test admin can create periode magang
     */
    public function test_admin_can_create_periode_magang(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/periode-magang', [
            'nama_periode' => 'Periode 2024 Semester 1',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-06-30',
            'status_magang' => 'Aktif',
        ]);

        $response->assertRedirect('/admin/periode-magang');
        $this->assertDatabaseHas('periode_magang', [
            'nama_periode' => 'Periode 2024 Semester 1',
            'status_magang' => 'Aktif',
        ]);
    }

    /**
     * Test admin can view periode magang details
     */
    public function test_admin_can_view_periode_magang_details(): void
    {
        $this->markTestIncomplete('View admin.periode.show does not exist yet');
    }

    /**
     * Test admin can view edit periode magang form
     */
    public function test_admin_can_view_edit_periode_magang_form(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $periode = PeriodeMagang::factory()->create();

        $response = $this->actingAs($admin)->get("/admin/periode-magang/{$periode->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.periode.edit');
    }

    /**
     * Test admin can update periode magang
     */
    public function test_admin_can_update_periode_magang(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $periode = PeriodeMagang::factory()->create([
            'nama_periode' => 'Old Name',
            'status_magang' => 'Aktif',
        ]);

        $response = $this->actingAs($admin)->put("/admin/periode-magang/{$periode->id}", [
            'nama_periode' => 'Updated Name',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-06-30',
            'status_magang' => 'Nonaktif',
        ]);

        $response->assertRedirect('/admin/periode-magang');
        $this->assertDatabaseHas('periode_magang', [
            'id' => $periode->id,
            'nama_periode' => 'Updated Name',
            'status_magang' => 'Nonaktif',
        ]);
    }

    /**
     * Test admin can delete periode magang
     */
    public function test_admin_can_delete_periode_magang(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $periode = PeriodeMagang::factory()->create();

        $response = $this->actingAs($admin)->delete("/admin/periode-magang/{$periode->id}");

        $response->assertRedirect('/admin/periode-magang');
        $this->assertDatabaseMissing('periode_magang', [
            'id' => $periode->id,
        ]);
    }

    /**
     * Test periode magang creation validation - nama required
     */
    public function test_periode_magang_creation_requires_nama(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/periode-magang', [
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-06-30',
        ]);

        $response->assertSessionHasErrors('nama_periode');
    }

    /**
     * Test periode magang creation validation - tanggal_mulai required
     */
    public function test_periode_magang_creation_requires_tanggal_mulai(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/periode-magang', [
            'nama_periode' => 'Periode Test',
            'tanggal_selesai' => '2024-06-30',
        ]);

        $response->assertSessionHasErrors('tanggal_mulai');
    }

    /**
     * Test periode magang creation validation - tanggal_selesai required
     */
    public function test_periode_magang_creation_requires_tanggal_selesai(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/periode-magang', [
            'nama_periode' => 'Periode Test',
            'tanggal_mulai' => '2024-01-01',
        ]);

        $response->assertSessionHasErrors('tanggal_selesai');
    }

    /**
     * Test non-admin cannot access periode magang management
     */
    public function test_non_admin_cannot_access_periode_magang_management(): void
    {
        $user = User::factory()->create(['role' => 'Mahasiswa']);

        $response = $this->actingAs($user)->get('/admin/periode-magang');

        $response->assertStatus(403);
    }
}
