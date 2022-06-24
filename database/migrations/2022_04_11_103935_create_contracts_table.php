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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->date('start_contract');
            $table->date('end_contract');
            $table->string('contract_no');
            $table->string('contract_companyTH');
            $table->string('contract_companyEN');
            $table->string('contract_address');
            $table->string('kWh_meter_SN');
            $table->string('type');
            $table->string('voltage');
            // $table->string('CT_VT_Factor');
            // $table->date('meter_date');
            $table->integer('date_billing');

            $table->string('update_by')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
};
