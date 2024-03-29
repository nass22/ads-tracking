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
        Schema::create('issue_nrs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->foreignId('media_id')->constrained();
            $table->string('media');
            $table->string('numero')->nullable();
            $table->string('year');
            $table->string('month')->nullable();
            $table->string('day')->nullable();
            $table->string('week')->nullable();
            $table->string('final_issue');
            $table->string('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_nrs');
    }
};
