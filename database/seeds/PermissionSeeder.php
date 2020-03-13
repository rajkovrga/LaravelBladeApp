<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{

    private $reg;

    public function __construct(PermissionRegistrar $reg)
    {
        $this->reg = $reg;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->reg->forgetCachedPermissions();

        $permissions = [
            'add-post',
            'update-post',
            'delete-post',
            'change-role',
            'use-dashboard',

            'change-avatar',
            'change-email',
            'chage-username',
            'like',
            'create-comment',
            'update-comment',
            'remove-own-comment'
        ];

        foreach ($permissions as $p)
        {
            Permission::create(['name' => $p]);
        }

        Role::create(['name' => 'admin'])->givePermissionTo($permissions);

        Role::create(['name' => 'user'])->givePermissionTo([
            'change-avatar',
            'change-email',
            'chage-username',
            'like',
            'create-comment',
            'update-comment',
            'remove-own-comment'
        ]);

    }
}
