<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\UnitBisnis;
use App\Models\PeriodeMagang;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MagangManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Provide the route name expected by the controller redirects
        Route::middleware('web')->get('/admin/magang-alias', [\App\Http\Controllers\Admin\MagangController::class, 'index'])->name('admin.magang.index');
        Route::getRoutes()->refreshNameLookups();
    }

    /**
     * Test admin can view magang list
     */
    public function test_admin_can_view_magang_list(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/magang');

        $response->assertStatus(200);
        $response->assertViewIs('admin.magang.index');
    }

    /**
     * Test admin can view create magang form
     */
    public function test_admin_can_view_create_magang_form(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/magang/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.magang.create');
    }

    /**
     * Test admin can create magang
     */
    public function test_admin_can_create_magang(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $mahasiswa = Mahasiswa::factory()->create();
        $periode = PeriodeMagang::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create();
        $dosen = Dosen::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/magang', [
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'periode_id' => $periode->id,
            'id_dosen' => $dosen->id,
            'pembimbing_lapangan' => 'Pembimbing Lapangan',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-06-30',
            'tugas_description' => 'Kegiatan magang',
            'target_book_mingguan' => 2,
        ]);

        $response->assertRedirect('/admin/magang-alias');
        $this->assertDatabaseHas('magang', [
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'periode_id' => $periode->id,
        ]);
    }

    /**
     * Test admin can view magang details
     */
    public function test_admin_can_view_magang_details(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $mahasiswa = Mahasiswa::factory()->create();
        $periode = PeriodeMagang::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'periode_id' => $periode->id,
        ]);

        $response = $this->actingAs($admin)->get("/admin/magang/{$magang->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.magang.show');
    }

    /**
     * Test admin can view edit magang form
     */
    public function test_admin_can_view_edit_magang_form(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $mahasiswa = Mahasiswa::factory()->create();
        $periode = PeriodeMagang::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'periode_id' => $periode->id,
        ]);

        $response = $this->actingAs($admin)->get("/admin/magang/{$magang->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.magang.edit');
    }

    /**
     * Test admin can update magang
     */
    public function test_admin_can_update_magang(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $mahasiswa = Mahasiswa::factory()->create();
        $periode = PeriodeMagang::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create();
        $dosen = Dosen::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'periode_id' => $periode->id,
            'id_dosen' => $dosen->id,
            'pembimbing_lapangan' => 'Pembimbing Lama',
            'status_magang' => 'Aktif',
        ]);

        $response = $this->actingAs($admin)->put("/admin/magang/{$magang->id}", [
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'periode_id' => $periode->id,
            'id_dosen' => $dosen->id,
            'pembimbing_lapangan' => 'Pembimbing Lapangan Baru',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-06-30',
            'status_magang' => 'selesai',
            'tugas_description' => 'Tugas diperbarui',
            'target_book_mingguan' => 3,
        ]);

        $response->assertRedirect('/admin/magang-alias');
        $this->assertDatabaseHas('magang', [
            'id' => $magang->id,
            'status_magang' => 'selesai',
            'pembimbing_lapangan' => 'Pembimbing Lapangan Baru',
        ]);
    }

    /**
     * Test admin can delete magang
     */
    public function test_admin_can_delete_magang(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $mahasiswa = Mahasiswa::factory()->create();
        $periode = PeriodeMagang::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'periode_id' => $periode->id,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/magang/{$magang->id}");

        $response->assertRedirect('/admin/magang-alias');
        $this->assertDatabaseMissing('magang', [
            'id' => $magang->id,
        ]);
    }

    /**
     * Test magang creation validation - id_mahasiswa required
     */
    public function test_magang_creation_requires_id_mahasiswa(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $periode = PeriodeMagang::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create();
        $dosen = Dosen::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/magang', [
            'unit_id' => $unitBisnis->id,
            'periode_id' => $periode->id,
            'id_dosen' => $dosen->id,
            'pembimbing_lapangan' => 'Pembimbing Lapangan',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-06-30',
            'tugas_description' => 'Deskripsi tugas',
            'target_book_mingguan' => 2,
        ]);

        $response->assertSessionHasErrors('id_mahasiswa');
    }

    /**
     * Test magang creation validation - unit_id required
     */
    public function test_magang_creation_requires_unit_id(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $mahasiswa = Mahasiswa::factory()->create();
        $periode = PeriodeMagang::factory()->create();
        $dosen = Dosen::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/magang', [
            'id_mahasiswa' => $mahasiswa->id,
            'periode_id' => $periode->id,
            'id_dosen' => $dosen->id,
            'pembimbing_lapangan' => 'Pembimbing Lapangan',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-06-30',
            'tugas_description' => 'Deskripsi tugas',
            'target_book_mingguan' => 2,
        ]);

        $response->assertSessionHasErrors('unit_id');
    }

    /**
     * Test non-admin cannot access magang management
     */
    public function test_non_admin_cannot_access_magang_management(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->get('/admin/magang');

        $response->assertStatus(403);
    }
}
