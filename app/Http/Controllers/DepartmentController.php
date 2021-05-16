<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index() {
        $departments = Department::paginate(3);
        $trashDepartments = Department::onlyTrashed()->paginate(3);
        return view('admin.department.index', compact('departments' , 'trashDepartments'));
    }

    public function store(Request $request) {
        // ตรวจสอบข้อมูล
        $request->validate(
        [
            'department_name' => 'required|unique:departments|max:255'
        ],
        [
            'department_name.required' => "กรุณากรอกชื่อแผนก",
            'department_name.max' => "ชื่อแผนกต้องไม่เกิน 255 อักษร",
            'department_name.unique' => "มีข้อมูลแผนกนี้อยู่แล้ว"
        ]);

        // Save data
        $department = new Department; // model

        $department->department_name = $request->department_name;
        $department->user_id = Auth::user()->id;
        $department->save();

        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
    }

    public function edit($id) {
        $department = Department::find($id);
        return view('admin.department.edit', compact('department'));
    }

    public function update(Request $request, $id) {
        // ตรวจสอบข้อมูล
        $request->validate(
            [
                'department_name' => 'required|unique:departments|max:255'
            ],
            [
                'department_name.required' => "กรุณากรอกชื่อแผนก",
                'department_name.max' => "ชื่อแผนกต้องไม่เกิน 255 อักษร",
                'department_name.unique' => "มีข้อมูลแผนกนี้อยู่แล้ว"
            ]);

        $department = Department::find($id)->update([
            'department_name' => $request->department_name,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('department')->with('success', "อัพเดตข้อมูลเรียบร้อย");
    }

    public function softdelete($id) {
        $department = Department::find($id)->delete();
        return redirect()->back()->with('success', "ลบข้อมูลเรียบร้อย");
    }

    public function restore($id) {
        $department = Department::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success', "กู้คืนข้อมูลเรียบร้อย");
    }

    public function forceDelete($id) {
        $department = Department::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success', "ลบข้อมูลถาวรเรียบร้อยแล้ว");
    }
}
