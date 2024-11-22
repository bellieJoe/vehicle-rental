<div class="modal fade" id="viewPackageModal" tabindex="-1" role="dialog" aria-labelledby="viewPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPackageModalLabel">View Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  
            <div class="modal-body">
                <div id="package_image" class="mb-4"></div>
                <dl class="row">
                    <dt class="col-sm-3">Package Name :</dt>
                    <dd class="col-sm-9" id="package_name"></dd>
                    <dt class="col-sm-3">Price Per Pax :</dt>
                    <dd class="col-sm-9" id="price_per_pax"></dd>
                    <dt class="col-sm-3">Duration :</dt>
                    <dd class="col-sm-9" id="duration"></dd>
                    <dt class="col-sm-3">Minimum :</dt>
                    <dd class="col-sm-9" id="minimum_pax"></dd>
                </dl>
                <div>
                    <p id="description"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function setViewModal(package) {
        $('#viewPackageModal').find('#package_name').text(package.package_name);
        $('#viewPackageModal').find('#package_image').html("<img class='tw-w-full' src='{{ asset('images/packages/') }}/" + package.package_image + "' class='img-fluid' />");
        // $('#viewPackageModal').find('#vehicle_name').text(package.vehicle.model + " - " + package.vehicle.brand);
        $('#viewPackageModal').find('#price_per_pax').text(package.price_per_person);
        $('#viewPackageModal').find('#duration').text(package.package_duration + " day/s");
        $('#viewPackageModal').find('#minimum_pax').text(package.minimum_pax + " pax");
        $('#viewPackageModal').find('#description').html(package.package_description);
        $('#viewPackageModal').modal('show');
    }
</script>
