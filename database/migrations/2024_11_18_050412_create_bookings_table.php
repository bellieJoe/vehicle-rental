<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // booking details
            $table->string('transaction_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('contact_number');
            $table->string('name');
            $table->enum('booking_type', ['Package', 'Vehicle'])->default('Vehicle');
            $table->foreignId('package_id')->nullable()->constrained();
            $table->foreignId('vehicle_id')->nullable()->constrained();

            // payment details
            $table->float('computed_price');    
            $table->float('paid_amount')->default(0);
            $table->enum('payment_status', ['Paid', 'Unpaid', 'Partially Paid'])->default('Unpaid');
            $table->enum('payment_method', ['Cash', "Online"]);
            $table->dateTime('payment_datetime')->nullable();

            // status
            $table->string('status')->default('Pending');
            $table->foreignId("cancelled_by")->nullable()->constrained('users');

            // others
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
