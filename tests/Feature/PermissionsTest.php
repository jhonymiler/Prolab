<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function test_should_be_able_to_give_a_permission_to_an_user()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Admin']);
        $permission = Permission::create(['name' => 'edit-user']);
        $role->givePermissionTo('edit-user');
        $permission->assignRole($role);
        $user->assignRole($role);

        $this->assertTrue($user->hasPermissionTo('edit-user'));
        $this->assertDatabaseHas('permissions', [
            'name' => 'edit-user'
        ]);
    }

    /** @test */
    public function test_authorize_access_to_a_base_on_the_permission()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Admin']);

        $user->assignRole($role);

        Route::get('test-something-weird', function () {
            return 'teste';
        })->middleware('role:Editor');
        Route::get('editar', function () {
            return 'teste';
        })->middleware('role:Admin');

        $this->actingAs($user)->get('test-something-weird')->assertForbidden();
        $this->actingAs($user)->get('editar')->assertSuccessful();
    }

    public function test_be_should_authorize_rota_with_permission()
    {
        $user = User::factory()->create();
        $permission = Permission::create(['name' => 'todo']);
        $user->givePermissionTo($permission);

        Route::get('test-something-weird', function () {
            return 'teste';
        })->middleware('permission:editar|role:Admin');
        Route::get('editar', function () {
            return 'teste';
        })->middleware('permission:todo|role:Admin');

        $this->actingAs($user)->get('test-something-weird')->assertForbidden();
        $this->actingAs($user)->get('editar')->assertSuccessful();
    }
}
