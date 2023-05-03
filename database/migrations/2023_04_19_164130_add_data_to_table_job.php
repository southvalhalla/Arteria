<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataToTableJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('job')->insert([
            [
                'job' => 'Gerente',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'job' => 'Vendedor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'job' => 'Desarrollador',
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
        DB::table('job')->whereIn('job', ['Gerente', 'Vendedor', 'Desarrollador'])->delete();
    }
}
