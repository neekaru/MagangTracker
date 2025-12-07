<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Logbook;
use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\Dosen;
use App\Models\UnitBisnis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogbookManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test mahasiswa can view their logbook list
     */
    public function test_mahasiswa_can_view_their_logbook_list(): void
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

        $response = $this->actingAs($user)->get('/mahasiswa/logbook');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.logbook.index');
    }

    /**
     * Test mahasiswa can view create logbook form
     */
    public function test_mahasiswa_can_view_create_logbook_form(): void
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

        $response = $this->actingAs($user)->get('/mahasiswa/logbook/create');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.logbook.create');
    }

    /**
     * Test mahasiswa can create logbook
     */
    public function test_mahasiswa_can_create_logbook(): void
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

        $response = $this->actingAs($user)->post('/mahasiswa/logbook', [
            'magang_id' => $magang->id,
            'tanggal_logbook' => '2024-01-15 08:00:00',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'deskripsi_kegiatan' => 'Belajar Laravel Testing',
            'hasil_kegiatan' => 'Unit test selesai',
        ]);

        $response->assertRedirect('/admin/logbook');
        $this->assertDatabaseHas('logbook', [
            'magang_id' => $magang->id,
            'deskripsi_kegiatan' => 'Belajar Laravel Testing',
        ]);
    }

    /**
     * Test mahasiswa can view edit logbook form
     */
    public function test_mahasiswa_can_view_edit_logbook_form(): void
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
        $logbook = Logbook::factory()->create([
            'magang_id' => $magang->id,
        ]);

        $response = $this->actingAs($user)->get("/mahasiswa/logbook/{$logbook->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.logbook.edit');
    }

    /**
     * Test mahasiswa can update their logbook
     */
    public function test_mahasiswa_can_update_their_logbook(): void
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
        $logbook = Logbook::factory()->create([
            'magang_id' => $magang->id,
            'deskripsi_kegiatan' => 'Old Activity',
        ]);

        $response = $this->actingAs($user)->put("/mahasiswa/logbook/{$logbook->id}", [
            'tanggal_logbook' => '2024-01-15 08:00:00',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'deskripsi_kegiatan' => 'Updated Activity',
            'hasil_kegiatan' => 'Updated description',
        ]);

        $response->assertRedirect('/admin/logbook');
        $this->assertDatabaseHas('logbook', [
            'id' => $logbook->id,
            'deskripsi_kegiatan' => 'Updated Activity',
        ]);
    }

    /**
     * Test admin can view all logbooks
     */
    public function test_admin_can_view_all_logbooks(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/logbook');

        $response->assertStatus(200);
        $response->assertViewIs('admin.logbook.index');
    }

    /**
     * Test admin can view logbook details
     */
    public function test_admin_can_view_logbook_details(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $mahasiswa = Mahasiswa::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
        ]);
        $logbook = Logbook::factory()->create([
            'magang_id' => $magang->id,
        ]);

        $response = $this->actingAs($admin)->get("/admin/logbook/{$logbook->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.logbook.show');
    }

    /**
     * Test admin can delete logbook
     */
    public function test_admin_can_delete_logbook(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $mahasiswa = Mahasiswa::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
        ]);
        $logbook = Logbook::factory()->create([
            'magang_id' => $magang->id,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/logbook/{$logbook->id}");

        $response->assertRedirect('/admin/logbook');
        $this->assertDatabaseMissing('logbook', [
            'id' => $logbook->id,
        ]);
    }

    /**
     * Test pembimbing can view logbook list
     */
    public function test_pembimbing_can_view_logbook_list(): void
    {
        $dosen = Dosen::factory()->create();
        $user = User::factory()->create([
            'role' => 'Pembimbing',
            'id_dosen' => $dosen->id,
        ]);

        $response = $this->actingAs($user)->get('/pembimbing/logbook');

        $response->assertStatus(200);
        $response->assertViewIs('pembimbing.logbook.index');
    }

    /**
     * Test pembimbing can update logbook status
     */
    public function test_pembimbing_can_update_logbook_status(): void
    {
        $dosen = Dosen::factory()->create();
        $user = User::factory()->create([
            'role' => 'Pembimbing',
            'id_dosen' => $dosen->id,
        ]);
        $mahasiswa = Mahasiswa::factory()->create();
        $unitBisnis = UnitBisnis::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'id_dosen' => $dosen->id,
        ]);
        $logbook = Logbook::factory()->create([
            'magang_id' => $magang->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->put("/pembimbing/logbook/{$logbook->id}", [
            'status' => 'approved',
            'tanggal_logbook' => $logbook->tanggal_logbook,
            'jam_mulai' => $logbook->jam_mulai,
            'jam_selesai' => $logbook->jam_selesai,
            'deskripsi_kegiatan' => $logbook->deskripsi_kegiatan,
            'hasil_kegiatan' => $logbook->hasil_kegiatan,
        ]);

        $this->assertDatabaseHas('logbook', [
            'id' => $logbook->id,
            'status' => 'approved',
        ]);
    }

    /**
     * Test logbook creation validation - tanggal required
     */
    public function test_logbook_creation_requires_tanggal(): void
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

        $response = $this->actingAs($user)->post('/mahasiswa/logbook', [
            'magang_id' => $magang->id,
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'deskripsi_kegiatan' => 'Test Activity',
            'hasil_kegiatan' => 'Test description',
        ]);

        $response->assertSessionHasErrors('tanggal_logbook');
    }

    /**
     * Test logbook creation validation - kegiatan required
     */
    public function test_logbook_creation_requires_kegiatan(): void
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

        $response = $this->actingAs($user)->post('/mahasiswa/logbook', [
            'magang_id' => $magang->id,
            'tanggal_logbook' => '2024-01-15 08:00:00',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'hasil_kegiatan' => 'Test description',
        ]);

        $response->assertSessionHasErrors('deskripsi_kegiatan');
    }
}
