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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->double('ft');
            $table->double('cp');
            $table->double('cop');

            $table->double('ch');
            $table->date('effective_start')->nullable();
            $table->date('effective_end')->nullable();
            // $table->double('ec');
            // $table->double('fc');
            // $table->double('epp');
            // $table->integer('df');

            $table->double('kwhp');
            $table->bigInteger('kwhp_first_ts')->nullable();
            $table->double('kwhp_first');
            $table->bigInteger('kwhp_last_ts')->nullable();
            $table->double('kwhp_last');

            $table->double('kwhop');
            $table->bigInteger('kwhop_first_ts')->nullable();
            $table->double('kwhop_first');
            $table->bigInteger('kwhop_last_ts')->nullable();
            $table->double('kwhop_last');

            $table->double('kwhh');
            $table->bigInteger('kwhh_first_ts')->nullable();
            $table->double('kwhh_first');
            $table->bigInteger('kwhh_last_ts')->nullable();
            $table->double('kwhh_last');

            $table->double('sum_kwh');

            $table->double('energy_money_kwhp');
            $table->double('energy_money_kwhop');
            $table->double('energy_money_kwhh');

            $table->double('ec');

            $table->double('money_ft');

            $table->double('EC_Plus_money_ft');
            $table->double('discount');
            $table->integer('df');
            $table->double('amount');
            $table->double('vat');
            $table->double('total_amount');

            $table->string('month_billing');
            $table->string('pdf');

            $table->string('type')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('billings');
    }
};
