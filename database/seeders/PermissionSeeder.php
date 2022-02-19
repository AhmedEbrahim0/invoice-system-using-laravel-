<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions=[            "invoice-delete",'invoice-edit','invoice-update','invoice-create','user-create','user-update',
        'user-edit','user-delete','section-delete', 'section-edit', 'section-update','section-create',
        'product-create','product-delete','product-edit', 'product-update', 'excel',  'only_read',];
        foreach ($permissions as $permission) {
            Permission::create(["name"=>$permission]);
        }

    }
}


