<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'insertion-list',
            'insertion-create',
            'insertion-edit',
            'insertion-delete',
            'company-list',
            'company-create',
            'company-edit',
            'company-delete',
            'media-list',
            'media-create',
            'media-edit',
            'media-delete',
            'invoice_status-list',
            'invoice_status-create',
            'invoice_status-edit',
            'invoice_status-delete'
         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
