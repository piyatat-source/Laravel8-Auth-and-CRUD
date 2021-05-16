<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello, {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">แบบฟอร์มแก้ไขข้อมูลบริการ</div>
                        <div class="card-body">
                            <form action="{{ url('/service/update/'.$service->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- ชื่อบริการ --}}
                                <div class="form-group">
                                    <label for="service_name">ชื่อบริการ</label>
                                    <input type="text" class="form-control" name="service_name" value="{{ $service->service_name }}">
                                </div>
                                @error('service_name')
                                <div class="my-2">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                                {{-- รูปภาพ --}}
                                <div class="form-group">
                                    <label for="service_image">รูปภาพ</label>
                                    <input type="file" class="form-control" name="service_image" value="{{ $service->service_name }}">
                                </div>
                                @error('service_image')
                                <div class="my-2">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                                <br>
                                {{-- รูปภาพ preview --}}
                                <div class="form-group">
                                    <img src="{{ asset($service->service_image) }}" alt="" style="width: 300px; height: 300px;">
                                </div>

                                <input type="hidden" name="old_image" value="{{ $service->service_image }}">

                                <input type="submit" class="btn btn-primary mt-3" value="Update">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
