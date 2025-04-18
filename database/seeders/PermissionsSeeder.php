<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view-users']);
        Permission::create(['name' => 'view-category']);
        Permission::create(['name' => 'view-podcast']);
        Permission::create(['name' => 'view-favorites']);
    }
}
