<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsAndForeingToEmployeeIdAndClientIdFromUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('id_employee')
            ->nullable()
            ->references('id')
            ->on('employees')
            ->after('id');
            $table->foreign('id_client')
            ->nullable()
            ->references('id')
            ->on('clients')
            ->after('id');
            $table->dropColumn('employee');
            $table->dropColumn('client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_employee']);
            $table->dropForeign(['id_client']);
            $table->string('employee');
            $table->string('client');
        });
    }
}
