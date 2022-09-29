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
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'insertions-list',
            'insertions-create',
            'insertions-edit',
            'insertions-delete',
            'companies-list',
            'companies-create',
            'companies-edit',
            'companies-delete',
            'media-list',
            'media-create',
            'media-edit',
            'media-delete',
            'invoice_statuses-list',
            'invoice_statuses-create',
            'invoice_statuses-edit',
            'invoice_statuses-delete',
            'issue_nrs-list',
            'issue_nrs-create',
            'issue_nrs-edit',
            'issue_nrs-delete',
         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
