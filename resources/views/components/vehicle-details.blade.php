<div class="modal fade" id="vehicleDetailsModal" tabindex="-1" aria-labelledby="vehicleDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vehicleDetailsModalLabel">Vehicle Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row mb-3">
                    <dt class="col-sm-3" >Model :</dt><dd id="model" class="col-sm-9"></dd>
                    <dt class="col-sm-3" >Brand :</dt><dd id="brand" class="col-sm-9"></dd>
                    <dt class="col-sm-3" >Category :</dt><dd id="category" class="col-sm-9"></dd>
                    <dt class="col-sm-3" >Owner :</dt><dd id="owner" class="col-sm-9"></dd>
                    <dt class="col-sm-3" >Rate :</dt><dd id="rate" class="col-sm-9">PHP</dd>
                    <dt class="col-sm-3" >Rate With Driver :</dt><dd id="rate_w_driver" class="col-sm-9">PHP</dd>
                </dl>
                <div class="">
                    <div class="alert alert-info"  role="alert">
                        <h5 class="h6 tw-font-bold" >Rent Options</h5>
                        <p id="rent_options"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showVehicleDetails(vehicle) {
        console.log(vehicle)
        $('#vehicleDetailsModal').find('.modal-title').text(vehicle.model + ' Details');
        $('#vehicleDetailsModal').find('#model').text(vehicle.model);
        $('#vehicleDetailsModal').find('#brand').text(vehicle.brand);
        $('#vehicleDetailsModal').find('#category').text(vehicle.vehicle_category.category_name);
        $('#vehicleDetailsModal').find('#owner').text(vehicle.user.organisation.org_name);
        $('#vehicleDetailsModal').find('#rate').text(`Php ${["Both", "Without Driver"].includes(vehicle.rent_options) ? vehicle.rate : "N/A"}`);
        $('#vehicleDetailsModal').find('#rate_w_driver').text(`Php ${["Both", "With Driver"].includes(vehicle.rent_options) ? vehicle.rate_w_driver : "N/A"}`);
        $('#vehicleDetailsModal').find('#rent_options').text(vehicle.rent_options == "Both" ? "Can be rented with or without driver" : `${vehicle.rent_options} only`);
        $('#vehicleDetailsModal').modal('show');
    }
</script>
