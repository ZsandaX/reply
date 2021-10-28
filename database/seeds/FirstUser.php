<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FirstUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);
        DB::table('roles')->insert([
            'name' => 'SuperAdmin',
            'guard' => 'web',
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\Entities\System\User',
            'model_id' => 1
        ]);
        $menus = array(
            array(
                "path" => "permissions",
                "label" => "權限",
                "icon" => "el-icon-star-off",
                "component" => "Permission",
                "controller" => "\\App\\Http\\Controllers\\System\\PermissionController",
                "order" => 0,
                "menu_id" => NULL,
                "disabled" => 0,
                "created_at" => NULL,
                "updated_at" => NULL,
                "deleted_at" => NULL,
            ),
            array(
                "path" => "menus",
                "label" => "選單",
                "icon" => "el-icon-star-off",
                "component" => "Menu",
                "controller" => "\\App\\Http\\Controllers\\System\\MenuController",
                "order" => 1,
                "menu_id" => NULL,
                "disabled" => 0,
                "created_at" => NULL,
                "updated_at" => NULL,
                "deleted_at" => NULL,
            ),
            array(
                "path" => "users",
                "label" => "使用者",
                "icon" => "el-icon-star-off",
                "component" => "User",
                "controller" => "\\App\\Http\\Controllers\\System\\UserController",
                "order" => 2,
                "menu_id" => NULL,
                "disabled" => 0,
                "created_at" => "2021-10-12 15:59:31",
                "updated_at" => "2021-10-12 16:09:01",
                "deleted_at" => NULL,
            ),
            array(
                "path" => "roles",
                "label" => "角色",
                "icon" => "el-icon-star-off",
                "component" => "Role",
                "controller" => "\\App\\Http\\Controllers\\System\\RoleController",
                "order" => 3,
                "menu_id" => NULL,
                "disabled" => 0,
                "created_at" => "2021-10-12 16:07:10",
                "updated_at" => "2021-10-12 16:07:10",
                "deleted_at" => NULL,
            ),
            array(
                "path" => "papers",
                "label" => "問卷",
                "icon" => "el-icon-star-off",
                "component" => "Paper",
                "controller" => "\\App\\Http\\Controllers\\Paper\\PaperController",
                "order" => 4,
                "menu_id" => NULL,
                "disabled" => 0,
                "created_at" => "2021-10-27 16:27:46",
                "updated_at" => "2021-10-27 16:29:44",
                "deleted_at" => NULL,
            ),
            array(
                "path" => "groups",
                "label" => "題組",
                "icon" => "el-icon-star-off",
                "component" => "Group",
                "controller" => "\\App\\Http\\Controllers\\Paper\\GroupController",
                "order" => 5,
                "menu_id" => NULL,
                "disabled" => 0,
                "created_at" => "2021-10-27 16:31:47",
                "updated_at" => "2021-10-27 16:31:47",
                "deleted_at" => NULL,
            ),
            array(
                "path" => "questions",
                "label" => "題目",
                "icon" => "el-icon-star-off",
                "component" => "Question",
                "controller" => "\\App\\Http\\Controllers\\Paper\\QuestionController",
                "order" => 6,
                "menu_id" => NULL,
                "disabled" => 0,
                "created_at" => "2021-10-27 17:22:47",
                "updated_at" => "2021-10-27 17:22:47",
                "deleted_at" => NULL,
            ),
            array(
                "path" => "options",
                "label" => "題項",
                "icon" => "el-icon-star-off",
                "component" => "Option",
                "controller" => "\\App\\Http\\Controllers\\Paper\\OptionController",
                "order" => 7,
                "menu_id" => NULL,
                "disabled" => 0,
                "created_at" => "2021-10-28 09:03:26",
                "updated_at" => "2021-10-28 09:03:26",
                "deleted_at" => NULL,
            ),
        );
        foreach($menus as $menu){
            DB::table('menus')->insert($menu);
        }

    }
}
