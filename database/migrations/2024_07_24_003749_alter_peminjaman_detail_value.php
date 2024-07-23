<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPeminjamanDetailValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman_detail', function (Blueprint $table) {
            $table->dropColumn('type_payment');
        });
        Schema::table('peminjaman_detail', function (Blueprint $table) {
            $table->enum('type_payment', ['Transfer','Cash','Potong Nota'])->default('Cash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peminjaman_detail', function (Blueprint $table) {
            //
        });
    }
}
