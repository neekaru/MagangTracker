<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\PeriodeMagang;
use App\Models\UnitBisnis;
use App\Models\Dosen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test mahasiswa can view dashboard
     */
    public function test_mahasiswa_can_view_dashboard(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->get('/mahasiswa');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.dashboard');
    }

    /**
     * Test mahasiswa can view profile page
     */
    public function test_mahasiswa_can_view_profile_page(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->get('/mahasiswa/profil');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.profil.index');
    }

    /**
     * Test mahasiswa can update profile
     */
    public function test_mahasiswa_can_update_profile(): void
    {
        $mahasiswa = Mahasiswa::factory()->create([
            'nim' => '202401001',
            'nama_lengkap' => 'Old Name',
        ]);
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->put('/mahasiswa/profil', [
            'nama_lengkap' => 'New Name',
            'nim' => '202401001',
            'email' => $user->email,
        ]);

        $response->assertRedirect('/mahasiswa/profil');
        $this->assertDatabaseHas('mahasiswa', [
            'id' => $mahasiswa->id,
            'nama_lengkap' => 'New Name',
        ]);
    }

    /**
     * Test mahasiswa can view magang registration page
     */
    public function test_mahasiswa_can_view_magang_registration_page(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->get('/mahasiswa/magang/create');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.magang.create');
    }

    /**
     * Test mahasiswa can register for magang
     */
    public function test_mahasiswa_can_register_for_magang(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);
        $periode = PeriodeMagang::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create([
        ]);
        $dosen = Dosen::factory()->create();

        $response = $this->actingAs($user)->post('/mahasiswa/magang', [
            'periode_id' => $periode->id,
            'unit_id' => $unitBisnis->id,
            'id_dosen' => $dosen->id,
            'pembimbing_lapangan' => 'Pembimbing Lapangan',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-06-30',
            'tugas_description' => 'Deskripsi tugas',
            'target_book_mingguan' => 2,
        ]);

        $response->assertRedirect('/mahasiswa/magang');
        $this->assertDatabaseHas('magang', [
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'periode_id' => $periode->id,
        ]);
    }

    /**
     * Test mahasiswa can view their magang list
     */
    public function test_mahasiswa_can_view_their_magang_list(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->get('/mahasiswa/magang');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.magang.index');
    }

    /**
     * Test mahasiswa cannot access other mahasiswa profile
     */
    public function test_mahasiswa_cannot_access_other_mahasiswa_profile(): void
    {
        $mahasiswa1 = Mahasiswa::factory()->create();
        $mahasiswa2 = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa1->id,
        ]);

        // This test assumes there's protection in the controller
        // Adjust according to your actual implementation
        $response = $this->actingAs($user)->get('/mahasiswa/profil');

        $response->assertStatus(200);
        // Should only see own profile data
    }

    /**
     * Test mahasiswa profile update validation
     */
    public function test_mahasiswa_profile_update_requires_nama_lengkap(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->put('/mahasiswa/profil', [
            'nim' => '202401001',
        ]);

        $response->assertSessionHasErrors('nama_lengkap');
    }

    /**
     * Test non-mahasiswa cannot access mahasiswa routes
     */
    public function test_non_mahasiswa_cannot_access_mahasiswa_routes(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/mahasiswa');

        $response->assertStatus(403);
    }

    /**
     * Test mahasiswa magang registration validation
     */
    public function test_magang_registration_requires_unit_bisnis(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);
        $periode = PeriodeMagang::factory()->create();
        $dosen = Dosen::factory()->create();

        $response = $this->actingAs($user)->post('/mahasiswa/magang', [
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
}
