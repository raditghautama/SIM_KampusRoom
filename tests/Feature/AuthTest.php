<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{


    public function test_login_page_renders_with_required_elements(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        // Sisi Kiri
        $response->assertSee('PORTAL AKADEMIK');
        $response->assertSee('CampusRoom');
        $response->assertSee('SISTEM INFORMASI PEMINJAMAN RUANGAN KAMPUS');
        $response->assertSee('Terintegrasi dengan SIMPT Kampus');
        $response->assertSee('Akses Keamanan Data Terenkripsi');

        // Sisi Kanan
        $response->assertSee('Masuk ke Akun');
        $response->assertSee('USERNAME (NIDN / NIM / NIP)');
        $response->assertSee('Masukkan NIDN / NIM / Identity Number');
        $response->assertSee('PASSWORD');
        $response->assertSee('togglePasswordBtn');
        $response->assertSee('Masuk Sistem Sekarang');
    }

    public function test_admin_can_login_with_identity_number_and_redirects_to_admin_dashboard(): void
    {
        $response = $this->post('/login', [
            'identity_number' => 'ADM001',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertEquals('admin', auth()->user()->role);
    }

    public function test_peminjam_can_login_with_identity_number_and_redirects_to_room_catalog(): void
    {
        $response = $this->post('/login', [
            'identity_number' => '2421400096',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('peminjam.room-catalog'));
        $this->assertAuthenticated();
        $this->assertEquals('peminjam', auth()->user()->role);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'identity_number' => 'ADM001',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('identity_number');
        $this->assertGuest();
    }

    public function test_peminjam_cannot_access_admin_dashboard_and_is_redirected(): void
    {
        $peminjam = User::where('role', 'peminjam')->first();
        $this->actingAs($peminjam);

        $response = $this->get('/admin/dashboard');
        $response->assertRedirect(route('peminjam.room-catalog'));
        $response->assertSessionHas('error');
    }

    public function test_admin_accessing_peminjam_area_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        $response = $this->get('/peminjam/room-catalog');
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_guest_accessing_dashboard_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect(route('login'));
    }
}
