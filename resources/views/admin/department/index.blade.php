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
                        <div class="card-header">ตารางข้อมูลแผนก</div>
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Department name</th>
                                <th scope="col">User</th>
                                <th scope="col">Manage</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $department)
                                <tr>
                                    <th scope="row">{{ $departments->firstItem()+$loop->index }}</th>
                                    <td>{{ $department->department_name }}</td>
                                    <td>{{ $department->user->name }}</td>  
                                    <td>
                                        <center>
                                            <a href="{{ url('/department/edit/'.$department->id) }}" class="btn btn-primary">Edit</a>
                                            <a href="{{ url('/department/softdelete/'.$department->id) }}" class="btn btn-warning">Delete to bin</a>   
                                        </center>   
                                    </td>                                                                
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $departments->links() }} {{-- Pagination --}}

                    
                    @if (count($trashDepartments) > 0)
                        <div class="card mt-4">
                            <div class="card-header">ถังขยะ</div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Department name</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trashDepartments as $trashDepartment)
                                    <tr>
                                        <th scope="row">{{ $trashDepartments->firstItem()+$loop->index }}</th>
                                        <td>{{ $trashDepartment->department_name }}</td>
                                        <td>{{ $trashDepartment->user->name }}</td>  
                                        <td>
                                            <center>
                                                <a href="{{ url('/department/restore/'.$trashDepartment->id) }}" class="btn btn-primary">Restore</a>
                                                <a href="{{ url('/department/forcedelete/'.$trashDepartment->id) }}" class="btn btn-danger">Force Delete</a>   
                                            </center>   
                                        </td>                                                                
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $trashDepartments->links() }}
                    @endif
                </div>



                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">แบบฟอร์ม</div>
                        <div class="card-body">
                            <form action="{{ route('addDepartment') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">ชื่อแผนก</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>
                                @error('department_name')
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
