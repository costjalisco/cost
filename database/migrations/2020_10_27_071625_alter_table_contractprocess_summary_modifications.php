<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableContractprocessSummaryModifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('contractprocess_summary_modifications', function (Blueprint $table) {
            $table->foreign('id_summary')->references('id')->on('summary')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_modifications')->references('id')->on('modifications')->onDelete('cascade')->onUpdate('cascade');
           

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
