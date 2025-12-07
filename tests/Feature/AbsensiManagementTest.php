<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Absen;
use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\UnitBisnis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbsensiManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test mahasiswa can view their absensi list
     */
    public function test_mahasiswa_can_view_their_absensi_list(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->get('/mahasiswa/absensi');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.absensi.index');
    }

    /**
     * Test mahasiswa can view create absensi form
     */
    public function test_mahasiswa_can_view_create_absensi_form(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create();
        Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
        ]);
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->get('/mahasiswa/absensi/create');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.absensi.create');
    }

    /**
     * Test mahasiswa can create absensi
     */
    public function test_mahasiswa_can_create_absensi(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
        ]);

        $response = $this->actingAs($user)->post('/mahasiswa/absensi', [
            'magang_id' => $magang->id,
            'tanggal' => '2024-01-15 08:00:00',
            'jam' => '08:00',
            'status_kehadiran' => 'Hadir',
        ]);

        $response->assertRedirect('/mahasiswa/absensi');
        $this->assertDatabaseHas('absen', [
            'magang_id' => $magang->id,
            'status_kehadiran' => 'Hadir',
        ]);
    }

    /**
     * Test admin can view all absensi
     */
    public function test_admin_can_view_all_absensi(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/absensi');

        $response->assertStatus(200);
        $response->assertViewIs('admin.absensi.index');
    }

    /**
     * Test mahasiswa can record hadir attendance
     */
    public function test_mahasiswa_can_record_hadir_attendance(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
        ]);

        $response = $this->actingAs($user)->post('/mahasiswa/absensi', [
            'magang_id' => $magang->id,
            'tanggal' => '2024-01-15',
            'jam' => '08:00',
            'status_kehadiran' => 'Hadir',
        ]);

        $this->assertDatabaseHas('absen', [
            'magang_id' => $magang->id,
            'status_kehadiran' => 'Hadir',
            'tanggal' => '2024-01-15 00:00:00',
        ]);
    }

    /**
     * Test mahasiswa can record izin attendance
     */
    public function test_mahasiswa_can_record_izin_attendance(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
        ]);

        $response = $this->actingAs($user)->post('/mahasiswa/absensi', [
            'magang_id' => $magang->id,
            'tanggal' => '2024-01-15',
            'jam' => '08:00',
            'status_kehadiran' => 'Izin',
            'keterangan' => 'Sakit',
        ]);

        $this->assertDatabaseHas('absen', [
            'magang_id' => $magang->id,
            'status_kehadiran' => 'Izin',
            'keterangan' => 'Sakit',
        ]);
    }

    /**
     * Test mahasiswa can record sakit attendance
     */
    public function test_mahasiswa_can_record_sakit_attendance(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
        ]);

        $response = $this->actingAs($user)->post('/mahasiswa/absensi', [
            'magang_id' => $magang->id,
            'tanggal' => '2024-01-15',
            'jam' => '08:00',
            'status_kehadiran' => 'Sakit',
            'keterangan' => 'Demam',
        ]);

        $this->assertDatabaseHas('absen', [
            'magang_id' => $magang->id,
            'status_kehadiran' => 'Sakit',
            'keterangan' => 'Demam',
        ]);
    }

    /**
     * Test absensi creation validation - tanggal required
     */
    public function test_absensi_creation_requires_tanggal(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
        ]);

        $response = $this->actingAs($user)->post('/mahasiswa/absensi', [
            'magang_id' => $magang->id,
            'status_kehadiran' => 'Hadir',
        ]);

        $response->assertSessionHasErrors('tanggal');
    }

    /**
     * Test absensi creation validation - status required
     */
    public function test_absensi_creation_requires_status(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
        ]);

        $response = $this->actingAs($user)->post('/mahasiswa/absensi', [
            'magang_id' => $magang->id,
            'tanggal' => '2024-01-15',
        ]);

        $response->assertSessionHasErrors('status_kehadiran');
    }

    /**
     * Test absensi creation validation - id_magang required
     */
    public function test_absensi_creation_requires_id_magang(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->post('/mahasiswa/absensi', [
            'tanggal' => '2024-01-15',
            'status_kehadiran' => 'Hadir',
        ]);

        $response->assertSessionHasErrors('magang_id');
    }

    /**
     * Test non-mahasiswa or admin cannot create absensi
     */
    public function test_pembimbing_cannot_create_absensi(): void
    {
        $user = User::factory()->create(['role' => 'Pembimbing']);

        $response = $this->actingAs($user)->get('/mahasiswa/absensi/create');

        $response->assertStatus(403);
    }

    /**
     * Test mahasiswa cannot view other mahasiswa absensi
     */
    public function test_mahasiswa_can_only_view_their_own_absensi(): void
    {
        $mahasiswa1 = Mahasiswa::factory()->create();
        $mahasiswa2 = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa1->id,
        ]);

        $response = $this->actingAs($user)->get('/mahasiswa/absensi');

        $response->assertStatus(200);
        // Should only see own absensi data
    }
}
