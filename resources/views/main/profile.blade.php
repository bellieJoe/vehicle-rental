<x-master>
    <h4 class="h4">Profile</h4>
    <div class="card mt-4 ">
        <div class="card-body">
            <div class="row align-items-start ">
                <div class="text-center p-3 ">
                    @php
                        $profile = auth()->user()->profile_picture;
                        $user = auth()->user();
                    @endphp
                    <img src="{{ auth()->user()->profile_picture ? asset("images/profiles/$profile") : "https://api.dicebear.com/9.x/fun-emoji/svg?seed=$user->name" }}" class="img-fluid " width="200" height="200" alt="">
                </div>
                <dl class="row mt-4 p-3 ">
                    <dt class="col-sm-3">Name :</dt>
                    <dd class="col-sm-9">{{ auth()->user()->name }}</dd>
    
                    <dt class="col-sm-3">Email :</dt>
                    <dd class="col-sm-9">{{ auth()->user()->email }}</dd>
    
                    <dt class="col-sm-3">Role :</dt>
                    <dd class="col-sm-9">{{ ucfirst(auth()->user()->role == 'org' ? 'organization' : auth()->user()->role) }}</dd>
                </dl>
            </div>
        </div>
    </div>
</x-master>