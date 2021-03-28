<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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
            'ao-list',
            'ao-create',
            'ao-update',
            'ao-delete',
            'at-list',
            'at-create',
            'at-update',
            'at-delete',
            'company-list',
            'company-create',
            'company-update',
            'company-delete',
            'drugcat-list',
            'drugcat-create',
            'drugcat-update',
            'drugcat-delete',
            'drug-list',
            'drug-create',
            'drug-update',
            'drug-delete',
            'drug-repo-show',
            'drug-repo-update',
            'drug-repo-update-sell',
            'drug-repo-update-order',
            'drug-repo-update-prescription',
            'drug-shape-list',
            'drug-shape-create',
            'drug-shape-update',
            'drug-shape-delete',
            'ins-com-list',
            'ins-com-create',
            'ins-com-update',
            'ins-com-delete',
            'invoice-pay',
            'invoice-sell-create',
            'invoice-sell-insurance-create',
            'invoice-sell-list',
            'invoice-sell-show',
            'invoice-order-create',
            'invoice-order-list',
            'invoice-order-show',
            'invoice-order-receive',
            'invoice-type-list',
            'invoice-type-create',
            'invoice-type-update',
            'invoice-type-delete',
            'prescrption-list',
            'prescrption-create',
            'prescrption-update',
            'prescrption-delete',
            'report-show',
            'role-list',
            'role-create',
            'role-update',
            'role-delete',
            'user-list',
            'user-create',
            'user-update',
            'user-delete',
            'sp-cust-list',
            'sp-cust-create',
            'sp-cust-update',
            'sp-cust-delete',
            'ware-list',
            'ware-create',
            'ware-update',
            'ware-delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
