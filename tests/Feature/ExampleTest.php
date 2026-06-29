<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/about');
        $response->assertStatus(200);

        $response = $this->get('/pricing');
        $response->assertStatus(200);

        $response = $this->get('/faq');
        $response->assertStatus(200);

        $response = $this->get('/contact');
        $response->assertStatus(200);
    }

    public function test_login_page_renders(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_admin_can_login_with_correct_credentials(): void
    {
        // Use a transaction or clean up to keep local DB clean
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            ]
        );

        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '12345678',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_cannot_login_with_incorrect_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'wrong_password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect(route('login'));
    }

    public function test_vendor_register_page_renders(): void
    {
        $response = $this->get('/vendor/register');
        $response->assertStatus(200);
    }

    public function test_vendor_can_register_and_is_redirected_to_dashboard(): void
    {
        \App\Models\User::where('email', 'john.vendor@example.com')->delete();

        $response = $this->post('/vendor/register', [
            'first_name' => 'John',
            'email' => 'john.vendor@example.com',
            'contact_number' => '1234567890',
            'country_code' => '+91',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('vendor.dashboard'));
        $this->assertAuthenticated();
        
        $user = \App\Models\User::where('email', 'john.vendor@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('vendor', $user->role);
        $this->assertEquals('John', $user->first_name);
    }

    public function test_vendor_login_redirects_to_vendor_dashboard(): void
    {
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'vendor@gmail.com'],
            [
                'name' => 'Vendor Test',
                'first_name' => 'Vendor',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'vendor',
            ]
        );

        $response = $this->post('/login', [
            'email' => 'vendor@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('vendor.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_can_access_admin_vendors_list(): void
    {
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'first_name' => 'Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'role' => 'admin',
            ]
        );

        $response = $this->actingAs($admin)->get('/admin/vendor');
        $response->assertStatus(200);
        $response->assertViewHas('vendors');
    }

    public function test_vendor_cannot_access_admin_vendors_list(): void
    {
        $vendor = \App\Models\User::firstOrCreate(
            ['email' => 'vendor@gmail.com'],
            [
                'name' => 'Vendor Test',
                'first_name' => 'Vendor',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'vendor',
            ]
        );

        $response = $this->actingAs($vendor)->get('/admin/vendor');
        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_access_admin_vendors_list(): void
    {
        $response = $this->get('/admin/vendor');
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_toggle_vendor_status(): void
    {
        $admin = \App\Models\User::where('email', 'admin@gmail.com')->first();
        $vendor = \App\Models\User::where('email', 'vendor@gmail.com')->first();

        // Ensure status is active initially
        $vendor->update(['status' => 'active']);

        $response = $this->actingAs($admin)->post("/admin/vendor/{$vendor->id}/toggle-status");
        $response->assertRedirect();
        
        $vendor->refresh();
        $this->assertEquals('inactive', $vendor->status);
    }

    public function test_admin_can_edit_vendor_details(): void
    {
        $admin = \App\Models\User::where('email', 'admin@gmail.com')->first();
        $vendor = \App\Models\User::where('email', 'vendor@gmail.com')->first();

        $response = $this->actingAs($admin)->get("/admin/vendor/{$vendor->id}/edit");
        $response->assertStatus(200);
        $response->assertViewHas('vendor');
    }

    public function test_admin_can_update_vendor_details(): void
    {
        \App\Models\User::where('email', 'updated.vendor@example.com')->delete();

        $admin = \App\Models\User::where('email', 'admin@gmail.com')->first();
        $vendor = \App\Models\User::where('email', 'vendor@gmail.com')->first();

        $response = $this->actingAs($admin)->put("/admin/vendor/{$vendor->id}", [
            'first_name' => 'UpdatedVendor',
            'email' => 'updated.vendor@example.com',
            'contact_number' => '9876543210',
            'country_code' => '+1',
            'status' => 'inactive',
        ]);

        $response->assertRedirect(route('admin.vendors.index'));
        
        $vendor->refresh();
        $this->assertEquals('UpdatedVendor', $vendor->first_name);
        $this->assertEquals('updated.vendor@example.com', $vendor->email);
        $this->assertEquals('inactive', $vendor->status);
    }

    public function test_admin_can_delete_vendor(): void
    {
        $admin = \App\Models\User::where('email', 'admin@gmail.com')->first();
        $vendor = \App\Models\User::firstOrCreate(
            ['email' => 'vendor_delete@gmail.com'],
            [
                'name' => 'Delete Me',
                'first_name' => 'Delete',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'vendor',
            ]
        );

        $response = $this->actingAs($admin)->delete("/admin/vendor/{$vendor->id}");
        $response->assertRedirect(route('admin.vendors.index'));
        
        $this->assertNull(\App\Models\User::find($vendor->id));
    }

    public function test_super_admin_can_login_and_is_redirected_to_dashboard(): void
    {
        $superAdmin = \App\Models\User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'first_name' => 'Super',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'role' => 'super_admin',
            ]
        );

        $response = $this->post('/login', [
            'email' => 'superadmin@gmail.com',
            'password' => '12345678',
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    public function test_super_admin_can_access_dashboard(): void
    {
        $superAdmin = \App\Models\User::where('email', 'superadmin@gmail.com')->first();
        $response = $this->actingAs($superAdmin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }
}
