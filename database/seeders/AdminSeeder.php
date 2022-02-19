<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{

    public function run()
    {
        $permissions=["invoice-delete","invoice-edit","invoice-create","invoice-update"
    ,"section-delete","section-edit","section-create","section-update",
    "product-create","product-edit","product-update","product-delete",
    "excel","only_read",

    ];
        $role=Role::findByName("admin");
        $role->givePermissionTo($permissions);  

    }
}
