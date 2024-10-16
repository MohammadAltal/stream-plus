<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('english_short_name')->nullable();
            $table->string('english_long_name')->nullable();
            $table->string('arabic_short_name')->nullable();
            $table->string('arabic_long_name')->nullable();
            $table->string('iso2')->nullable();
            $table->string('iso3')->nullable();
            $table->string('flag')->nullable();
            $table->string('cctld')->nullable();
            $table->string('calling_code')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');

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
        Schema::dropIfExists('countries');
    }
}
