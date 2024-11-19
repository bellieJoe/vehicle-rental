<x-master>
    <h4 class="h4">Settings</h4>
    <div class="row ">
        <div class="col-sm-12 col-md-4">
            <div class="card m-4">
                <div class="card-body">
                    <div class=" align-items-start ">
                        <div class="text-center p-3 mx-auto">
                            @php
                                $profile = auth()->user()->profile_picture;
                                $user = auth()->user();
                            @endphp
                            <img src="{{ auth()->user()->profile_picture ? asset("images/profile/$profile") : "https://api.dicebear.com/9.x/fun-emoji/svg?seed=$user->name" }}" class="img-fluid tw-block mx-auto" width="200" height="200" alt="">
                        </div>
                        <dl class="row mt-4 p-3">
                            <dt class="col-sm-3">Name:</dt>
                            <dd class="col-sm-9">{{ auth()->user()->name }}</dd>

                            <dt class="col-sm-3">Email:</dt>
                            <dd class="col-sm-9">{{ auth()->user()->email }}</dd>
                        </dl>
                        <div class="card mt-4">
                            <div class="card-header">Change Profile Picture</div>
                            <div class="card-body">
                                <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mt-3">
                                        <x-forms.input errorBag="profile" name="profile_picture" type="file" accept="image/jpg, image/jpeg, image/png" placeholder="Choose Profile Picture" />
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="card m-4">
                <div class="card-body">
                    <form action="{{ route('updatePassword') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h5 class="h5">Reset Password</h5>
                        <div class="form-group">
                            <x-forms.input errorBag="reset_passsword" name="old_password" label="Old Password" placeholder="Enter old password" type="password" required />
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 mt-3">
                                <x-forms.input errorBag="reset_passsword" name="new_password" label="New Password" placeholder="Enter new password" type="password" required />
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 mt-3">
                                <x-forms.input errorBag="reset_passsword" name="confirm_new_password" label="Confirm New Password" placeholder="Confirm new password" type="password" required />
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-master>