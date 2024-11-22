@extends("main.layouts.master")
@section("content")
    <div >
        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p>{{ session('message') }}</p> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        
        <h4 class="h4">Organizations</h4>
        <div class="mb-3">
            <button data-toggle="modal" data-target="#addOrgModal" href="#" class="btn btn-primary">Add Account</button>
        </div>
        <div class="card">
            <div class="card-header">Accounts</div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Gcash</th>
                            <th scope="col">Address</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orgs as $org)
                            <tr>
                                <td>{{$org->name}}</td>
                                <td>{{$org->email}}</td>
                                <td>{{$org->organisation->gcash_number}}</td>
                                <td>{{$org->organisation->address}}</td>
                                <td>
                                    @if ($org->is_banned)
                                        <form action="{{ route('admin.unban-account', $org->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{$org->id}}">
                                            <button type="submit" class="btn btn-sm btn-success">Unban</button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-danger" onclick="showBanAccountModal({{$org->id}})">Ban</button>
                                    @endif
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

    <div class="modal fade" id="addOrgModal" tabindex="-1" aria-labelledby="addOrgModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{route('admin.register-org')}}" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOrgModalLabel">Add Organization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="name"><span class="tw-text-red-500">*</span>Representative Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name" placeholder="Name">
                        @error('name', 'org_register')
                            <span class="text-danger">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="email"><span class="tw-text-red-500">*</span>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email" placeholder="Email">
                        @error('email', 'org_register')
                            <span class="text-danger">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone"><span class="tw-text-red-500">*</span>GCash Number</label>
                        <input type="text" class="form-control" name="gcash_number" value="{{ old('gcash_number') }}" id="gcash_number" placeholder="Gcash Number">
                        @error('gcash_number', 'org_register')
                            <span class="text-danger">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address"><span class="tw-text-red-500">*</span>Address</label>
                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" id="address" placeholder="Address">
                        @error('address', 'org_register')
                            <span class="text-danger">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address"><span class="tw-text-red-500">*</span>Organization Name</label>
                        <input type="text" class="form-control" name="org_name" id="org_name" value="{{ old('org_name') }}" placeholder="Address">
                        @error('org_name', 'org_register')
                            <span class="text-danger">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="address"><span class="tw-text-red-500">*</span>Password</label>
                            <input type="text" class="form-control" name="password" id="password" placeholder="Address">
                            @error('password', 'org_register')
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror
                        </div>
                        <div class="col">
                            <label for="address"><span class="tw-text-red-500">*</span>Password Confirmation</label>
                            <input type="text" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Address">
                            @error('password_confirmation', 'org_register')
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                    <p>Payment Info</p>
                    <div class="form-group">
                        <label for="address"><span class="tw-text-red-500">*</span>Stripe Secret Key</label>
                        <input type="text" class="form-control" name="stripe_secret_key" id="stripe_secret_key" value="{{ old('stripe_secret_key') }}" placeholder="Address">
                        @error('stripe_secret_key', 'org_register')
                            <span class="text-danger">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>

    <x-ban-account-modal />

    <script>
        $(document).ready(function() {
            $('#addOrgModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

            @if ($errors->org_register->any())
                $('#addOrgModal').modal('show');
            @endif
        });
    </script>

@endsection