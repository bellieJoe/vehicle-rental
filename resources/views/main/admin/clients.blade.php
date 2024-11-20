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
                                    @if ($client->is_banned)
                                        <form action="{{ route('admin.unban-account', $client->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{$client->id}}">
                                            <button type="submit" class="btn btn-sm btn-success">Unban</button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-danger" onclick="showBanAccountModal({{$client->id}})">Ban</button>
                                    @endif
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

    <x-ban-account-modal />
@endsection
