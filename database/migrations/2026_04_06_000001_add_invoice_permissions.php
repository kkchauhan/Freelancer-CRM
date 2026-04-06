<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $permissions = [
            ['title' => 'invoice_create'],
            ['title' => 'invoice_edit'],
            ['title' => 'invoice_show'],
            ['title' => 'invoice_delete'],
            ['title' => 'invoice_access'],
        ];

        foreach ($permissions as $permission) {
            $inserted = DB::table('permissions')->insertGetId([
                'title' => $permission['title'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Assign to admin role (id 1 usually)
            DB::table('permission_role')->insert([
                'permission_id' => $inserted,
                'role_id' => 1
            ]);
        }
    }

    public function down()
    {
        $titles = ['invoice_create', 'invoice_edit', 'invoice_show', 'invoice_delete', 'invoice_access'];
        $permissionIds = DB::table('permissions')->whereIn('title', $titles)->pluck('id');
        
        DB::table('permission_role')->whereIn('permission_id', $permissionIds)->delete();
        DB::table('permissions')->whereIn('title', $titles)->delete();
    }
};
