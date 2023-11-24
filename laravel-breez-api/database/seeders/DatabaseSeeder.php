<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'active users']);
        Permission::create(['name' => 'deactive users']);


        Role::create(['name' => 'user']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo([
            'edit users',
            'active users',
            'delete users',
            'deactive users',
        ]);


        $roleSuperAdmin = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user1 = \App\Models\User::factory()->create([
            'name' => 'CustomerUser',
            'email' => 'test@a.com',
            'password' => Hash::make('12345678')
        ]);


        $user = \App\Models\User::factory()->create([
            'name' => 'ManagerUser',
            'email' => 'manager@a.com',
            'password' => Hash::make('12345678'),
            'suspend' => false
        ]);
        $user->assignRole('admin');

        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin',
            'email' => 'superadmin@a.com',
            'password' => Hash::make('12345678'),
            'suspend' => false
        ]);
        $user->assignRole('Super-Admin');
    }
}
