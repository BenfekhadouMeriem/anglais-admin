<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les permissions
        $permissions = ['edit-user', 'destroy-user'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Créer le rôle admin s'il n'existe pas et lui assigner les permissions
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->syncPermissions($permissions);

        // Assigner le rôle admin à un utilisateur spécifique
        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user && !$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}
