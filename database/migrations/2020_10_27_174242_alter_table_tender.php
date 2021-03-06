<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTender extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tender', function (Blueprint $table) {
            $table->foreign('tenders_id')->references('id')->on('tender')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('procuringEntity_id')->references('id')->on('organization')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('administrativeEntity_id')->references('id')->on('organization')->onDelete('set null')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
