@extends("main.layouts.master")
@section("content")

<x-alerts></x-alerts>

<div class="">
    <h4 class="h4">Book Packages</h4>
    <form action="" method="GET" class="mb-3">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request()->query('start_date') }}">
            </div>
            <div class="form-group col-md-3">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request()->query('end_date') }}">
            </div>
            <div class="form-group col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary mr-2">Filter</button>
                <a href="{{ route('client.packages') }}" class="btn btn-secondary ">Clear</a>
            </div>
        </div>
    </form>

    
    <div class="row">
        @forelse ($packages as $package)
            <div class="col-md-4">
                <div class="card mb-3"> 
                    <div class="card-body p-0">
                        <div style="width: 100%; height: 200px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-image: url({{ $package->package_image ? asset("images/packages/$package->package_image") : ''}}); border-radius: 0.25rem;"></div>
                        <div class="p-3">
                            <a href="{{ route('feedbacks.index', ['type' => 'package', 'id' => $package->id]) }}" class="tw-text-yellow-500 small tw-block">
                                <i class="fas fa-star"></i> {{ $package->computeFeedbackAverage() }} / 5 out of {{ $package->countFeedbacks() }} feedbacks
                            </a>
                            <span class="badge badge-primary"><i class="fa-solid fa-user mr-2"></i>{{ $package->user->organisation->org_name }}</span>
                            <p class="tw-font-bold mb-0">{{ $package->package_name }}</p>
                            <p class="mb-0"><span>Duration :</span><span>{{ $package->package_duration }} day/s</span></p>
                            <div class="">
                                <span class="text-primary tw-font-bold">PHP {{ number_format($package->price_per_person, 2) }} / pax</span>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <button class="btn btn-sm btn-outline-primary my-2" onclick="setViewModal({{$package}})">Details</button>
                                    <a href="{{ route("client.packages.bookView", $package->id) }}" class="btn btn-sm btn-primary my-2" >Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12 text-center">
                <p class="lead">No packages available.</p>
            </div>
        @endforelse
    </div>
    {{ $packages->links() }}
</div>

<x-packages.view-package-modal />
@endsection