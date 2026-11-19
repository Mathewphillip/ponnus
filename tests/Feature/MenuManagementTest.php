<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features as FortifyFeatures;
use Laravel\Jetstream\Features as JetstreamFeatures;
use Tests\TestCase;

class MenuManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed database before each test so seeded users and menus exist
        $this->seed();
    }

    /**
     * Test: Unauthenticated users cannot access dashboard or menu management.
     */
    public function test_unauthenticated_users_are_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        $responseMenu = $this->get('/menu/list');
        $responseMenu->assertRedirect('/login');

        $responseAdd = $this->get('/menu/create');
        $responseAdd->assertRedirect('/login');
    }

    /**
     * Test: Administrator account can authenticate and access dashboard.
     */
    public function test_admin_account_can_authenticate_and_access_dashboard(): void
    {
        $user = User::where('email', 'admin@ponnus.test')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Admin', $user->role);

        $response = $this->post('/login', [
            'email'    => 'admin@ponnus.test',
            'password' => 'password123',
        ]);
        $response->assertRedirect('/dashboard');

        $dash = $this->actingAs($user)->get('/dashboard');
        $dash->assertStatus(200);
        $dash->assertSee('Restaurant Administrator');
        $dash->assertSee('Admin');
    }

    /**
     * Test: Staff account can authenticate and access dashboard.
     */
    public function test_staff_account_can_authenticate_and_access_dashboard(): void
    {
        $user = User::where('email', 'staff@ponnus.test')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Staff', $user->role);

        $response = $this->post('/login', [
            'email'    => 'staff@ponnus.test',
            'password' => 'password123',
        ]);
        $response->assertRedirect('/dashboard');

        $dash = $this->actingAs($user)->get('/dashboard');
        $dash->assertStatus(200);
        $dash->assertSee('Restaurant Staff');
        $dash->assertSee('Staff');
    }

    /**
     * Test: Manager account can authenticate and access dashboard.
     */
    public function test_manager_account_can_authenticate_and_access_dashboard(): void
    {
        $user = User::where('email', 'manager@ponnus.test')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Manager', $user->role);

        $response = $this->post('/login', [
            'email'    => 'manager@ponnus.test',
            'password' => 'password123',
        ]);
        $response->assertRedirect('/dashboard');

        $dash = $this->actingAs($user)->get('/dashboard');
        $dash->assertStatus(200);
        $dash->assertSee('Restaurant Manager');
        $dash->assertSee('Manager');
    }

    /**
     * Test: Scope exclusion - Two-Factor Authentication, API, and Teams are disabled.
     */
    public function test_excluded_features_are_disabled_by_configuration(): void
    {
        // 2FA disabled in Fortify configuration
        $this->assertFalse(FortifyFeatures::canManageTwoFactorAuthentication());

        // API tokens disabled in Jetstream configuration
        $this->assertFalse(JetstreamFeatures::hasApiFeatures());

        // Team management disabled in Jetstream configuration
        $this->assertFalse(JetstreamFeatures::hasTeamFeatures());

        // API routes are not registered (returns 404)
        $response = $this->get('/api/user');
        $response->assertStatus(404);
    }

    /**
     * Test: User profile does not render 2FA or API token forms.
     */
    public function test_profile_page_omits_excluded_features(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get(route('profile.show'));
        $response->assertStatus(200);

        // Standard profile info and password updates are active
        $response->assertSee('Profile Information');
        $response->assertSee('Update Password');

        // Excluded features are NOT rendered
        $response->assertDontSee('Two Factor Authentication');
        $response->assertDontSee('API Tokens');
        $response->assertDontSee('Create API Token');
    }

    /**
     * Test: Authenticated user can view menu list.
     */
    public function test_authenticated_user_can_view_menu_list(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get(route('menu.create'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.menu');
        $response->assertSee('Chicken Pilau');
        $response->assertSee('Beef Burger');
        $response->assertSee('Vegetable Pizza');
        $response->assertSee('Fresh Juice');
        $response->assertSee('Grilled Chicken');
    }

    /**
     * Test: Authenticated user can view add-menu form.
     */
    public function test_authenticated_user_can_view_add_menu_form(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get(route('menu.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.add-menu');
        $response->assertSee('Create New Menu Item');
    }

    /**
     * Test: Authenticated user can create a new menu item.
     */
    public function test_authenticated_user_can_create_menu_item(): void
    {
        $user = User::first();

        $itemData = [
            'name'         => 'Fish Curry',
            'category'     => 'Main Course',
            'price'        => 13.50,
            'availability' => 'Available',
            'description'  => 'Traditional coconut fish curry with aromatic spices.',
        ];

        $response = $this->actingAs($user)->post(route('menu.store'), $itemData);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('menus', [
            'name'     => 'Fish Curry',
            'category' => 'Main Course',
            'price'    => 13.50,
        ]);
    }

    /**
     * Test: Authenticated user can update an existing menu item.
     */
    public function test_authenticated_user_can_update_menu_item(): void
    {
        $user = User::first();
        $menu = Menu::where('name', 'Chicken Pilau')->first();

        $updatedData = [
            'name'         => 'Special Chicken Pilau',
            'category'     => 'Main Course',
            'price'        => 15.00,
            'availability' => 'Unavailable',
            'description'  => 'Deluxe portion with extra spiced boiled egg.',
        ];

        $response = $this->actingAs($user)->put(route('menu.update', $menu->id), $updatedData);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('menus', [
            'id'           => $menu->id,
            'name'         => 'Special Chicken Pilau',
            'price'        => 15.00,
            'availability' => 'Unavailable',
        ]);
    }

    /**
     * Test: Authenticated user can delete a menu item.
     */
    public function test_authenticated_user_can_delete_menu_item(): void
    {
        $user = User::first();
        $menu = Menu::where('name', 'Fresh Juice')->first();

        $response = $this->actingAs($user)->delete(route('menu.destroy', $menu->id));

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('menus', [
            'id' => $menu->id,
        ]);
    }

    /**
     * Test: Form validation fails with invalid data.
     */
    public function test_form_validation_rejects_invalid_menu_data(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->post(route('menu.store'), [
            'name'         => '',
            'category'     => '',
            'price'        => 'not-a-number',
            'availability' => 'InvalidStatus',
        ]);

        $response->assertSessionHasErrors(['name', 'category', 'price', 'availability']);
    }
}
