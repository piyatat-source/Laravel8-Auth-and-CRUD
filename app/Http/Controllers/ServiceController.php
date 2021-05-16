<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index() {
        $services = Service::paginate(3);
        return view('admin.service.index', compact('services'));
    }

    public function store(Request $request) {
        $request->validate(
        [
            'service_name' => 'required|unique:services|max:255',
            'service_image' => 'required|mimes: jpg,jpeg,png'
        ],
        [
            'service_name.required' => "กรุณากรอกชื่อบริการ",
            'service_name.max' => "ชื่อบริการต้องไม่เกิน 255 อักษร",
            'service_name.unique' => "มีข้อมูลบริการนี้อยู่แล้ว",

            'service_image.required' => "กรุณาใส่รูปภาพ",
            'service_image.mimes' => "รูปภาพต้องเป็นไฟล์ jpg, jpeg, png เท่านั้น",
        ]);

        // Encrypt Image
        $service_image = $request->file('service_image');
        $rand_num = hexdec(uniqid()); // ชื่อภาพ
        $file_ext = strtolower($service_image->getClientOriginalExtension()); // นามสกุลไฟล์

        $filename = $rand_num . '.' . $file_ext;
        
        
        // Upload image & Save data to database
        $upload_location = 'image/services/';
        $fullPath = $upload_location . $filename;

        

        $service = new Service;
        $service->service_name = $request->service_name;
        $service->service_image = $fullPath;
        $service->created_at = Carbon::now();
        $service->save(); // Save data to DB

        $service_image->move($upload_location, $filename); // Upload image to your location

        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
    }

    public function edit($id) {
        $service = Service::find($id);
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id) {
        // ตรวจสอบข้อมูล
        $request->validate(
            [
                'service_name' => 'required|max:255',
            ],
            [
                'service_name.required' => "กรุณากรอกชื่อบริการ",
                'service_name.max' => "ชื่อบริการต้องไม่เกิน 255 อักษร",
            ]);

        
        $service_image = $request->file('service_image');

        // อัพเดตภาพและชื่อ
        if ($service_image) {
            $rand_num = hexdec(uniqid()); // ชื่อภาพ
            $file_ext = strtolower($service_image->getClientOriginalExtension()); // นามสกุลไฟล์

            $filename = $rand_num . '.' . $file_ext;
            
            // Upload image & Update data to database
            $upload_location = 'image/services/';
            $fullPath = $upload_location . $filename;


            $service = Service::find($id);
            $service->service_name = $request->service_name;
            $service->service_image = $fullPath;
            $service->update(); // Update data to DB

            // delete old image
            $old_image = $request->old_image;
            unlink($old_image);

            $service_image->move($upload_location, $filename); // Upload image to your location

            return redirect()->route('service')->with('success', "อัพเดตรูปภาพเรียบร้อย");
        }
        // อัพเดตชื่ออย่างเดียว
        else {
            $service = Service::find($id);
            $service->service_name = $request->service_name;
            $service->update();

            return redirect()->route('service')->with('success', "อัพเดตชื่อบริการเรียบร้อย");
        }
    }

    public function delete($id) {
        // ลบภาพออกจากโฟลเดอร์
        $img = Service::find($id)->service_image;
        unlink($img);

        // ลบข้อมูลใน DB
        $service = Service::find($id)->delete();
        return redirect()->back()->with('success', "ลบข้อมูลเรียบร้อยแล้ว");
    }
}
