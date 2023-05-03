<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataToTableDocumentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('document_type')->insert([
            [
                'document_type' => 'cedula de ciudadania',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'document_type' => 'tarjeta de identidad',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'document_type' => 'cedula de extranjeria',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('document_type')->whereIn('document_type', ['cedula de ciudadania', 'tarjeta de identidad', 'cedula de extranjeria'])->delete();
    }
}
