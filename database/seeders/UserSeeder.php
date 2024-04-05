<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'product-list',
            'product-edit',
            'product-delete',
            'category-list',
            'category-edit',
            'category-delete',
            'ingredient-list',
            'ingredient-edit',
            'ingredient-delete',
            'order-edit',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $user = User::create([
            'first_name' => 'root',
            'last_name' => 'root',
            'father_name' => 'root',
            'phone' => '+7(923)435-34-66',
            'age' => 1,
            'email' => 'root@mail.com',
            'password' => Hash::make('qweqwe123')
        ]);
        $role = Role::create(['name' => 'root']);
        $rolePermissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($rolePermissions);
        $user->assignRole([$role->id]);
        User::create([
            'first_name' => 'user',
            'last_name' => 'user',
            'father_name' => 'user',
            'phone' => '+7(923)435-34-65',
            'age' => 77,
            'email' => 'user@mail.com',
            'password' => Hash::make('qweqwe123')
        ]);
    }
}
