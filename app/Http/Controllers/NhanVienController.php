<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NhanVienController extends Controller
{
    public function index(){
        $danhSachNhanVien = User::where('status', User::STATUS_ACTIVE)->where('type', User::EMPLOYEE)->get();

        return view('danh-sach-nhan-vien.index', ['danhSachNhanVien' => $danhSachNhanVien]);
    }

    // public function create(){
    //     return view('danh-sach-nhan-vien.create');
    // }

    // public function store(Request $request){
    //     $validated = $request->validate([
    //         'ho_ten' => 'required',
    //         'email' => 'required|email',
    //         'mat_khau' => 'required'
    //     ]);

    //     $createUser = User::create([
    //         'name' => $validated['ho_ten'],
    //         'email' => $validated['email'],
    //         'password' => Hash::make($validated['mat_khau']),
    //     ]);
    //     if($createUser){
    //         $createNhanVien = NhanVien::create([
    //             'user_id' => $createUser->id,
    //             'ho_ten' => $createUser->name,
    //         ]);
    //         return redirect()->route('nhan-vien.index')->with('status', 'Thêm nhân viên thành công!');
    //     }else{
    //         return redirect()->route('nhan-vien.index')->with('error', 'Thêm nhân viên thất bại!');

    //     }
    // }

    public function show(User $danhSachNhanVien){
        // dd($danhSachNhanVien);
        $diemThang = $danhSachNhanVien->diemThang;
        // dd($diemThang);
        return view('danh-sach-nhan-vien.show', ['danhSachNhanVien' => $danhSachNhanVien,
                                                'diemThang' => $diemThang]);
    }

    public function edit(User $danhSachNhanVien){

        return view('danh-sach-nhan-vien.edit', ['danhSachNhanVien' => $danhSachNhanVien]);
    }

    public function update(Request $request, User $danhSachNhanVien){

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mat_khau' => 'nullable',
        ], [
            'name.required' => "Nhập tên",
            'email.required' => " Nhập email"
        ]);

        $danhSachNhanVien->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['mat_khau'])
        ]);

        $diemThang = $danhSachNhanVien->diemThang;

        return redirect()->route('nhan-vien.show',['danhSachNhanVien' => $danhSachNhanVien,
                                                    'diemThang' => $diemThang])
                                                    ->with('status', "Cập nhật thành công!");
    }
}
