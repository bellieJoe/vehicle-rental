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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_category_id')->constrained();
            $table->string('brand');
            $table->string('model');
            $table->enum('rent_options', ["With Driver", "Without Driver", "Both"])->default("Both");
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(false);
            $table->float('rate')->default(0)->nullable();
            $table->float('rate_w_driver')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
