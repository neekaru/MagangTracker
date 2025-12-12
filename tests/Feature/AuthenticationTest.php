<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login page can be displayed
     */
    public function test_login_page_is_displayed(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /**
     * Test admin can login with valid credentials
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test mahasiswa can login with valid credentials
     */
    public function test_mahasiswa_can_login_with_valid_credentials(): void
    {
        $mahasiswa = Mahasiswa::factory()->create([
            'nim' => '123456',
            'nama_lengkap' => 'Test Mahasiswa',
        ]);

        $user = User::factory()->create([
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->post('/login', [
            'email' => 'mahasiswa@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/mahasiswa');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test pembimbing can login with valid credentials
     */
    public function test_pembimbing_can_login_with_valid_credentials(): void
    {
        $dosen = Dosen::factory()->create([
            'nama_lengkap' => 'Test Pembimbing',
            'nidn' => '0123456789',
            'status' => 'aktif',
        ]);

        $user = User::factory()->create([
            'email' => 'pembimbing@example.com',
            'password' => Hash::make('password'),
            'role' => 'Pembimbing',
            'id_dosen' => $dosen->id,
        ]);

        $response = $this->post('/login', [
            'email' => 'pembimbing@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/pembimbing');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test user cannot login with invalid credentials
     */
    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /**
     * Test user can logout
     */
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Test unauthenticated user is redirected to login
     */
    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    /**
     * Test admin cannot access mahasiswa routes
     */
    public function test_admin_cannot_access_mahasiswa_routes(): void
    {
        $user = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($user)->get('/mahasiswa');

        $response->assertStatus(403);
    }

    /**
     * Test mahasiswa cannot access admin routes
     */
    public function test_mahasiswa_cannot_access_admin_routes(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
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
}
