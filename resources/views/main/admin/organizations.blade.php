@extends("main.layouts.master")
@section("content")
    <div >
        <h4>Organizations</h4>
        <div class="mb-3">
            <a href="#" class="btn btn-primary">Add Account</a>
        </div>
        <div class="card">
            <div class="card-header">Accounts</div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orgs as $org)
                            <tr>
                                <td>{{$org->name}}</td>
                                <td>{{$org->email}}</td>
                                <td>{{$org->phone}}</td>
                                <td>{{$org->address}}</td>
                                <td>
                                    {{-- <a href="{{route('admin.client.edit', $org->id)}}" class="btn btn-primary">Edit</a> --}}
                                    {{-- @include('main.admin.clients._delete') --}}
                                </td>
                            </tr>
                        @empty
                            <td colspan="5" class="text-center">No Organizations registered</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$orgs->links()}}
            </div>
        </div>
    </div>
@endsection