<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissoes = [
            'criar',
            'editar',
            'deletar',
            'ler'
        ];
        $modulos = [
            'usuarios',
            'materiais',
            'permissoes',
            'niveis',
            'profissionais',
            'orcamentos',
            'projetos',
            'configuracoes',
            'clientes',
            'ativos',
            'energia',
            'km rodado',
            'custos adm',
            'custo condominio',
            'custos operacionais',
            'entregaveis',
            'logistica',
            'materiais consumo',
            'reagentes',
            'ingredientes dieta'

        ];
        $roles = [
            'Administrador',
            'Gestor',
            'Usuario'
        ];
        $perms = [];
        foreach ($modulos as $m) {
            foreach ($permissoes as $k => $p) {
                $perms[] = Permission::create(['name' => "$p $m"]);
            }
        }

        $admin = Role::create(['name' => 'Administrador']);
        $admin->givePermissionTo($perms);

        $gestor = Role::create(['name' => 'Gestor']);
        $gestor->givePermissionTo($perms);

        $usuario = Role::create(['name' => 'Usuario']);
        $usuario->givePermissionTo($perms);


        $superAdmin = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Usuário',
            'email' => 'user@teste.com',
            'status' => 1,
            'password' => \bcrypt('senha')
        ]);
        $user->assignRole($usuario);

        $user = \App\Models\User::factory()->create([
            'name' => 'Gestor do sistema',
            'email' => 'gestor@teste.com',
            'status' => 1,
            'password' => \bcrypt('senha')
        ]);
        $user->assignRole($gestor);

        $user = \App\Models\User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@teste.com',
            'status' => 1,
            'password' => \bcrypt('senha')
        ]);
        $user->assignRole($admin);

        $user = \App\Models\User::factory()->create([
            'name' => 'Jonatas Miler',
            'email' => 'jonatasmiler@gmail.com',
            'status' => 1,
            'password' => \bcrypt('senha')
        ]);
        $user->assignRole($superAdmin);

        $user = \App\Models\User::factory()->create([
            'name' => 'Vitor Dias',
            'email' => 'vitorp674@gmail.com',
            'status' => 1,
            'password' => \bcrypt('1234')
        ]);
        $user->assignRole($superAdmin);
    }
}
