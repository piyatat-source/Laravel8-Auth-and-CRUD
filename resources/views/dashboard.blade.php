<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello, {{Auth::user()->name}}
            <b class="float-end">Number of users : <span>{{ count($users) }} users</b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Created date</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php($i=1)
                        @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>  {{-- diffForHumans คือการหาผลต่างของวันที่ เวลา --}}
                                                            {{-- Carbon\Carbon::parse($user->created_at)->diffForHumans() ใช้ในกรณีไม่มี Model --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
