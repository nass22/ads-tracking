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
        Schema::create('insertions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('job_id');
            $table->string('company');
            $table->string('brand')->nullable();
            $table->text('comment')->nullable();
            $table->string('media');
            $table->string('type')->nullable();
            $table->string('placement')->nullable();
            $table->string('month');
            $table->string('issue_nr');
            $table->string('number_of_pages');
            $table->string('quantity');
            $table->float('fare', 10, 2);
            $table->string('invoiced');
            $table->string('year');
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
        Schema::dropIfExists('insertions');
    }
};
