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
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif


                    <div class="card">
                        <div class="card-header">ตารางข้อมูลบริการ</div>
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Image</th>
                                <th scope="col">Service name</th>
                                <th scope="col">Manage</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                <tr>
                                    <th scope="row">{{ $services->firstItem()+$loop->index }}</th>
                                    <td>
                                        <center><img src="{{ asset($service->service_image) }}" alt="" style="width: 100px; height: 100px;"></center>
                                    </td>
                                    <td>{{ $service->service_name }}</td>  
                                    <td>
                                        <center>
                                            <a href="{{ url('/service/edit/'.$service->id) }}" class="btn btn-primary">Edit</a>
                                            <a href="{{ url('/service/delete/'.$service->id) }}" class="btn btn-danger" onclick='return confirm("คุณต้องการลบข้อมูลบริการ {{ $service->service_name }} หรือไม่ ?")'>Delete</a>   
                                        </center>   
                                    </td>                                                                
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $services->links() }} {{-- Pagination --}}
                </div>



                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">แบบฟอร์ม</div>
                        <div class="card-body">
                            <form action="{{ route('addService') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- Service Name --}}
                                <div class="form-group">
                                    <label for="service_name">ชื่อบริการ</label>
                                    <input type="text" class="form-control" name="service_name">
                                </div>
                                @error('service_name')
                                <div class="my-2">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                                {{-- Service Image --}}
                                <div class="form-group">
                                    <label for="service_image">รูปภาพ</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>
                                @error('service_image')
                                <div class="my-2">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                                <input type="submit" class="btn btn-primary mt-3" value="Save">
                            </form>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</x-app-layout>
