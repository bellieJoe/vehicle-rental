@extends("main.layouts.master")
@section("content")
    <div >
        <h4 class="h4">Clients</h4>

        <div class="card">
            <div class="card-header">Accounts</div>
            <div class="card-body p-0">
                <table class="table bg-white table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr> 
                                <td>{{$client->name}}</td>
                                <td>{{$client->email}}</td>
                                <td>{{ $client->phone ?? 'N/A' }}</td>
                                <td>
                                    {{-- <a href="{{route('admin.client.edit', $client->id)}}" class="btn btn-primary">Edit</a>
                                    @include('main.admin.clients._delete') --}}
                                </td>
                            </tr>
                        @empty
                            <td colspan="5" class="text-center">No clients</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$clients->links()}}
            </div>
        </div>
    </div>
@endsection
