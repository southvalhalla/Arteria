<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeDocumentIdAndJobIdToTableDocumentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->bigInteger('document_type_id')->unsigned();
            $table->foreign('document_type_id')
            ->references('id')
            ->on('document_type')
            ->after('id');
            $table->bigInteger('job_id')->unsigned();
            $table->foreign('job_id')
            ->references('id')
            ->on('job')
            ->after('document_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['document_type_id']);
            $table->dropColumn('document_type_id');
            $table->dropForeign(['job_id']);
            $table->dropColumn('job_id');
        });
    }
}
