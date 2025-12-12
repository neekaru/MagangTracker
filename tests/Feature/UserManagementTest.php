<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can view users list
     */
    public function test_admin_can_view_users_list(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    /**
     * Test admin can view create user form
     */
    public function test_admin_can_view_create_user_form(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/users/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.create');
    }

    /**
     * Test admin can create a new admin user
     */
    public function test_admin_can_create_admin_user(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'email' => 'newadmin@example.com',
            'password' => 'password123',
            'role' => 'Admin',
        ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'email' => 'newadmin@example.com',
            'role' => 'Admin',
        ]);
    }

    /**
     * Test admin can create a new pembimbing user
     */
    public function test_admin_can_create_pembimbing_user(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'email' => 'pembimbing@example.com',
            'password' => 'password123',
            'role' => 'Pembimbing',
            'nama_lengkap' => 'Pembimbing Test',
            'nidn' => '123456789',
        ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'email' => 'pembimbing@example.com',
            'role' => 'Pembimbing',
        ]);
        $this->assertDatabaseHas('dosen', [
            'nama_lengkap' => 'Pembimbing Test',
            'nidn' => '123456789',
        ]);
    }

    /**
     * Test admin can create a new mahasiswa user
     */
    public function test_admin_can_create_mahasiswa_user(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'email' => 'mahasiswa@example.com',
            'password' => 'password123',
            'role' => 'Mahasiswa',
            'nama_lengkap' => 'Mahasiswa Test',
            'nim' => '202401001',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-06-30',
        ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'email' => 'mahasiswa@example.com',
            'role' => 'Mahasiswa',
        ]);
        $this->assertDatabaseHas('mahasiswa', [
            'nama_lengkap' => 'Mahasiswa Test',
            'nim' => '202401001',
        ]);
    }

    /**
     * Test admin can view user details
     */
    public function test_admin_can_view_user_details(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->get("/admin/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.show');
        $response->assertViewHas('user');
    }

    /**
     * Test admin can view edit user form
     */
    public function test_admin_can_view_edit_user_form(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->get("/admin/users/{$user->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');
        $response->assertViewHas('user');
    }

    /**
     * Test admin can update user
     */
    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $user = User::factory()->create([
            'email' => 'old@example.com',
            'role' => 'Admin',
        ]);

        $response = $this->actingAs($admin)->put("/admin/users/{$user->id}", [
            'email' => 'updated@example.com',
            'role' => 'Admin',
        ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'updated@example.com',
        ]);
    }

    /**
     * Test admin can delete user
     */
    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->delete("/admin/users/{$user->id}");

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /**
     * Test user creation validation - email required
     */
    public function test_user_creation_requires_email(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'password' => 'password123',
            'role' => 'Admin',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test user creation validation - password required
     */
    public function test_user_creation_requires_password(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'email' => 'test@example.com',
            'role' => 'Admin',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test user creation validation - role required
     */
    public function test_user_creation_requires_role(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('role');
    }

    /**
     * Test mahasiswa creation requires nama_lengkap
     */
    public function test_mahasiswa_creation_requires_nama_lengkap(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'email' => 'mahasiswa@example.com',
            'password' => 'password123',
            'role' => 'Mahasiswa',
            'nim' => '202401001',
        ]);

        $response->assertSessionHasErrors('nama_lengkap');
    }

    /**
     * Test non-admin cannot access user management
     */
    public function test_non_admin_cannot_access_user_management(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $user = User::factory()->create([
            'role' => 'Mahasiswa',
            'id_mahasiswa' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertStatus(403);
    }
}
