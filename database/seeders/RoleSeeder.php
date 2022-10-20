<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $masterUser = User::firstWhere('email', 'master@larabox.dev');

        // Roles
        $masterRole = Role::updateOrCreate(
            ['name' => 'System Master'],
            [
                'description' => 'System Master',
                'author_id' => $masterUser->id,
            ]
        );
        $adminRole = Role::updateOrCreate(
            ['name' => 'System Admin'],
            [
                'description' => 'System Admin',
                'author_id' => $masterUser->id,
            ]
        );
        $moderatorRole = Role::updateOrCreate(
            ['name' => 'System Moderator'],
            [
                'description' => 'System Moderator',
                'author_id' => $masterUser->id,
            ]
        );

        // Permissions
        $createAdmins = Permission::updateOrCreate(
            ['name' => 'admins: create'],
            [
                'description' => 'Create Admins',
                'author_id' => $masterUser->id,
            ]
        );
        $editAdmins = Permission::updateOrCreate(
            ['name' => 'admins: edit'],
            [
                'description' => 'Edit Admins',
                'author_id' => $masterUser->id,
            ]
        );
        $viewAdmins = Permission::updateOrCreate(
            ['name' => 'admins: view'],
            [
                'description' => 'View Admins',
                'author_id' => $masterUser->id,
            ]
        );

        $createUsers = Permission::updateOrCreate(
            ['name' => 'users: create'],
            [
                'description' => 'Create Users',
                'author_id' => $masterUser->id,
            ]
        );
        $editUsers = Permission::updateOrCreate(
            ['name' => 'users: edit'],
            [
                'description' => 'Edit Users',
                'author_id' => $masterUser->id,
            ]
        );
        $viewUsers = Permission::updateOrCreate(
            ['name' => 'users: view'],
            [
                'description' => 'View Users',
                'author_id' => $masterUser->id,
            ]
        );

        $adminUser = User::firstWhere('email', 'admin@larabox.dev');
        $moderatorUser = User::firstWhere('email', 'moderator@larabox.dev');

        $masterUser->giveRoles('System Master', 'System Admin', 'System Moderator');
        $adminUser->giveRoles('System Admin');
        $moderatorUser->giveRoles('System Moderator');

        $masterRole->permissions()->attach([$createAdmins->id, $editAdmins->id, $viewAdmins->id, $createUsers->id, $editUsers->id, $viewUsers->id]);
        $adminRole->permissions()->attach([$createUsers->id, $editUsers->id, $viewUsers->id]);
        $moderatorRole->permissions()->attach([$viewUsers->id]);
    }
}
