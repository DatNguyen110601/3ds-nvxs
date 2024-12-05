<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class DefaultRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $role = Role::where('name', 'Admin')->first();
        $permissionList = [
            'add_danh_muc_thang_nam',
            'edit_danh_muc_thang_nam',
            'export_excel',
            'duyet_diem',
            'add_edit_diem',
            'delete_nhan_vien_trong_dmtn',
            'add_danh_sach_tieu_chi',
            'edit_danh_sach_tieu_chi',
            'delete_danh_sach_tieu_chi',
            'add_tieu_chi_theo_thang',
            'edit_tieu_chi_theo_thang',
            'delete_tieu_chi_theo_thang',
            'edit_nhan_vien'
        ];
        foreach ($permissionList as $permissionName) {
            $wherePermission = Permission::where('name' , $permissionName)->first();
            if(!$wherePermission){

                $permission = Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
                $role->givePermissionTo($permission);
            }


        }
        // $permission = Permission::create(['name' => 'add_danh_muc_thang_nam', 'guard_name' => 'web']);

        // $permission = Permission::create(['name' => 'edit_danh_muc_thang_nam', 'guard_name' => 'web']);
        // $role->givePermissionTo($permission);
        // $permission = Permission::create(['name' => 'export_excel', 'guard_name' => 'web']);
        // $role->givePermissionTo($permission);
        // $permission = Permission::create(['name' => 'duyet_diem', 'guard_name' => 'web']);
        // $role->givePermissionTo($permission);
        // $permission = Permission::create(['name' => 'add_edit_diem', 'guard_name' => 'web']);
        // $role->givePermissionTo($permission);
        //     'edit_danh_muc_thang_nam',
        //     'export_excel',
        //     'duyet_diem',
        //     'add_edit_diem'
        // ])->get();
        // dd($permissions);
        // $role->givePermissionTo($permissions);
    }
}
