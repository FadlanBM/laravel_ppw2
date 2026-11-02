<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiddlewareAdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'name' => 'Fadlan Buwono Mukti',
            'email' => 'fadlan@mail.ugm.ac.id',
            'level' => 'admin',
        ]);

        $this->regularUser = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@mail.ugm.ac.id',
            'level' => 'user',
        ]);
    }

    /**
     * Pengunjung tamu (guest) tidak dapat mengakses menu /users dan diarahkan ke login.
     */
    public function test_guest_cannot_access_users_management_and_redirected_to_login(): void
    {
        $response = $this->get('/users');

        $response->assertRedirect('/login');
    }

    /**
     * Pengguna biasa (level user) ditolak dengan HTTP 403 Forbidden saat mengakses menu /users.
     */
    public function test_regular_user_is_forbidden_from_accessing_users_index(): void
    {
        $response = $this->actingAs($this->regularUser)->get('/users');

        $response->assertForbidden();
    }

    /**
     * Pengguna biasa ditolak dengan HTTP 403 saat mengakses form tambah user.
     */
    public function test_regular_user_is_forbidden_from_accessing_create_user_form(): void
    {
        $response = $this->actingAs($this->regularUser)->get('/users/create');

        $response->assertForbidden();
    }

    /**
     * Administrator dapat mengakses halaman daftar pengguna dengan HTTP 200 OK.
     */
    public function test_admin_can_access_users_index(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/users');

        $response->assertOk();
        $response->assertViewIs('users.index');
        $response->assertSee('Daftar Pengguna Sistem');
        $response->assertSee('fadlan@mail.ugm.ac.id');
        $response->assertSee('budi@mail.ugm.ac.id');
    }

    /**
     * Administrator dapat menambahkan pengguna baru ke dalam sistem.
     */
    public function test_admin_can_create_new_user(): void
    {
        $response = $this->actingAs($this->adminUser)->post('/users', [
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@mail.ugm.ac.id',
            'password' => 'password123',
            'level' => 'user',
        ]);

        $response->assertRedirect('/users');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'siti@mail.ugm.ac.id',
            'level' => 'user',
        ]);
    }

    /**
     * Administrator dapat memperbarui data pengguna lain.
     */
    public function test_admin_can_update_existing_user(): void
    {
        $response = $this->actingAs($this->adminUser)->put("/users/{$this->regularUser->id}", [
            'name' => 'Budi Santoso Updated',
            'email' => 'budi.baru@mail.ugm.ac.id',
            'level' => 'admin',
        ]);

        $response->assertRedirect('/users');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $this->regularUser->id,
            'name' => 'Budi Santoso Updated',
            'email' => 'budi.baru@mail.ugm.ac.id',
            'level' => 'admin',
        ]);
    }

    /**
     * Administrator dapat menghapus pengguna lain dari database.
     */
    public function test_admin_can_delete_other_user(): void
    {
        $userToDelete = User::factory()->create([
            'email' => 'hapus@mail.ugm.ac.id',
            'level' => 'user',
        ]);

        $response = $this->actingAs($this->adminUser)->delete("/users/{$userToDelete->id}");

        $response->assertRedirect('/users');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id,
        ]);
    }

    /**
     * Administrator dicegah menghapus akun aktif miliknya sendiri.
     */
    public function test_admin_cannot_delete_own_active_account(): void
    {
        $response = $this->actingAs($this->adminUser)->delete("/users/{$this->adminUser->id}");

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $this->adminUser->id,
        ]);
    }

    /**
     * Pengguna biasa dapat mengakses modul buku (diizinkan untuk level user).
     */
    public function test_regular_user_can_access_books_module(): void
    {
        $response = $this->actingAs($this->regularUser)->get('/buku');

        $response->assertOk();
        $response->assertViewIs('buku.index');
    }
}
