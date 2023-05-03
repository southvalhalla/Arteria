<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod');
            $table->timestamp('date');
            $table->bigInteger('client_id');
            $table->foreign('client_id')
                ->references('id')
                ->on('clients');
            $table->string('status');
            $table->bigInteger('methods_payment_id');
            $table->foreign('methods_payment_id')
                ->references('id')
                ->on('methods_payments');
            $table->integer('total');
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
        Schema::dropIfExists('sales');
    }
}
