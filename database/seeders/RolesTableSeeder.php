<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'delete cabinet']);
        Permission::create(['name' => 'create cabinet']);
        Permission::create(['name' => 'edit cabinet']);
        Permission::create(['name' => 'update cabinet']);
        Permission::create(['name' => 'view cabinet']);

        Permission::create(['name' => 'delete category']);
        Permission::create(['name' => 'create category']);
        Permission::create(['name' => 'edit category']);
        Permission::create(['name' => 'update category']);
        Permission::create(['name' => 'view category']);

        Permission::create(['name' => 'delete status']);
        Permission::create(['name' => 'create status']);
        Permission::create(['name' => 'edit status']);
        Permission::create(['name' => 'update status']);
        Permission::create(['name' => 'view status']);

        Permission::create(['name' => 'delete priority']);
        Permission::create(['name' => 'create priority']);
        Permission::create(['name' => 'edit priority']);
        Permission::create(['name' => 'update priority']);
        Permission::create(['name' => 'view priority']);

        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'view user']);

        Permission::create(['name' => 'delete news']);
        Permission::create(['name' => 'create news']);
        Permission::create(['name' => 'edit news']);
        Permission::create(['name' => 'update news']);
        Permission::create(['name' => 'view news']);

        Permission::create(['name' => 'delete help']);
        Permission::create(['name' => 'create help']);
        Permission::create(['name' => 'edit help']);
        Permission::create(['name' => 'update help']);
        Permission::create(['name' => 'view help']);
        Permission::create(['name' => 'accept help']);
        Permission::create(['name' => 'reject help']);
        Permission::create(['name' => 'redefine help']);
        Permission::create(['name' => 'execute help']);
        Permission::create(['name' => 'count help']);
        Permission::create(['name' => 'loader help']);
        Permission::create(['name' => 'all help']);
        Permission::create(['name' => 'new help']);
        Permission::create(['name' => 'dismiss help']);
        Permission::create(['name' => 'worker help']);
        Permission::create(['name' => 'completed help']);
        Permission::create(['name' => 'create home help']);
        Permission::create(['name' => 'new home help']);
        Permission::create(['name' => 'dismiss home help']);
        Permission::create(['name' => 'worker home help']);
        Permission::create(['name' => 'completed home help']);

        Permission::create(['name' => 'edit settings']);
        Permission::create(['name' => 'update settings']);

        Permission::create(['name' => 'all search']);
        Permission::create(['name' => 'prefix search']);

        Permission::create(['name' => 'view stats']);
        Permission::create(['name' => 'all directory list']);
        Permission::create(['name' => 'work directory list']);
        Permission::create(['name' => 'home directory list']);

        Role::create(['name' => 'superAdmin'])->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin']);
        //web
        $role->givePermissionTo(['new help', 'create help', 'dismiss help', 'worker help', 'completed help', 'edit help', 'view help',
            'create news', 'edit news', 'view news',
            'worker home help', 'completed home help', 'dismiss home help', 'create home help',
            'edit settings', 'all search', 'prefix search', 'view stats', 'work directory list', 'home directory list']);
        //api
        $role->givePermissionTo(['update help', 'accept help', 'reject help', 'redefine help', 'execute help', 'count help',
            'create news', 'update news', 'delete news',
            'update settings', 'loader help']);

        $role = Role::create(['name' => 'manager']);
        //web
        $role->givePermissionTo(['worker help', 'completed help', 'view help', 'view news',
            'worker home help', 'completed home help', 'dismiss home help', 'create home help',
            'edit settings', 'all search', 'prefix search', 'view stats', 'work directory list', 'home directory list']);
        //api
        $role->givePermissionTo(['update help', 'execute help', 'count help',
            'update settings', 'loader help']);

        $role = Role::create(['name' => 'user']);
        //web
        $role->givePermissionTo(['view help', 'view news',
            'worker home help', 'completed home help', 'dismiss home help', 'create home help',
            'edit settings', 'all search', 'prefix search', 'view stats', 'home directory list']);
        //api
        $role->givePermissionTo(['count help', 'update settings', 'loader help']);

    }
}
