<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    public function test_admin_login_page_can_be_accessed(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200); // ✅ Cek apakah halaman bisa diakses
        $response->assertSee('Login'); // (Opsional) cek apakah ada tulisan 'Login'
    }
}
