<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\UnitBisnis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PembimbingFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test pembimbing can view dashboard
     */
    public function test_pembimbing_can_view_dashboard(): void
    {
        $dosen = Dosen::factory()->create();
        $user = User::factory()->create([
            'role' => 'Pembimbing',
            'id_dosen' => $dosen->id,
        ]);

        $response = $this->actingAs($user)->get('/pembimbing');

        $response->assertStatus(200);
        $response->assertViewIs('pembimbing.dashboard');
    }

    /**
     * Test pembimbing can view peserta list
     */
    public function test_pembimbing_can_view_peserta_list(): void
    {
        $dosen = Dosen::factory()->create();
        $user = User::factory()->create([
            'role' => 'Pembimbing',
            'id_dosen' => $dosen->id,
        ]);

        $response = $this->actingAs($user)->get('/pembimbing/peserta');

        $response->assertStatus(200);
        $response->assertViewIs('pembimbing.peserta.index');
    }

    /**
     * Test pembimbing can view peserta detail
     */
    public function test_pembimbing_can_view_peserta_detail(): void
    {
        $dosen = Dosen::factory()->create();
        $user = User::factory()->create([
            'role' => 'Pembimbing',
            'id_dosen' => $dosen->id,
        ]);
        
        $unitBisnis = UnitBisnis::factory()->create();
        $mahasiswa = Mahasiswa::factory()->create();
        $magang = Magang::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'id_dosen' => $dosen->id,
        ]);

        $response = $this->actingAs($user)->get("/pembimbing/peserta/{$magang->id}");

        $response->assertStatus(200);
        $response->assertViewIs('pembimbing.peserta.show');
    }

    /**
     * Test pembimbing can view logbook index
     */
    public function test_pembimbing_can_view_logbook_index(): void
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
     * Test pembimbing cannot access admin routes
     */
    public function test_pembimbing_cannot_access_admin_routes(): void
    {
        $dosen = Dosen::factory()->create();
        $user = User::factory()->create([
            'role' => 'Pembimbing',
            'id_dosen' => $dosen->id,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    /**
     * Test pembimbing cannot access mahasiswa routes
     */
    public function test_pembimbing_cannot_access_mahasiswa_routes(): void
    {
        $dosen = Dosen::factory()->create();
        $user = User::factory()->create([
            'role' => 'Pembimbing',
            'id_dosen' => $dosen->id,
        ]);

        $response = $this->actingAs($user)->get('/mahasiswa');

        $response->assertStatus(403);
    }

    /**
     * Test non-pembimbing cannot access pembimbing routes
     */
    public function test_non_pembimbing_cannot_access_pembimbing_routes(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->get('/pembimbing');

        $response->assertStatus(403);
    }
}
