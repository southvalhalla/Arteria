<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataToTableRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = ['cliente','administrador','Vendedor en punto','coordinador de pedidos','coordinador de inventario'];
        $i = 0;
        while($i < count($roles)){
            DB::table('roles')->insert([
                [
                    'role' => $roles[$i],
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]);
            $i++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            DB::table('document_type')->whereIn('document_type', ['cliente','administrador','Vendedor en punto','coordinador de pedidos','coordinador de inventario'])->delete();
        });
    }
}
