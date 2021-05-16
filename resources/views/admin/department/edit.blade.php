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
                        <div class="card-header">แบบฟอร์มแก้ไขแผนก</div>
                        <div class="card-body">
                            <form action="{{ url('/department/update/'.$department->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">ชื่อแผนก</label>
                                    <input type="text" class="form-control" name="department_name" value="{{ $department->department_name }}">
                                </div>
                                @error('department_name')
                                <div class="my-2">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                                <input type="submit" class="btn btn-primary mt-3" value="Update">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
