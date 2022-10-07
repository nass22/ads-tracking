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
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade');
            $table->string('job_id');
            $table->foreignId('company')->constrained('companies')->onUpdate('cascade');
            $table->foreignId('issue_nr')->constrained('issue_nrs')->onUpdate('cascade');
            $table->foreignId('media')->constrained('media')->onUpdate('cascade');
            $table->string('type')->nullable();
            $table->string('placement')->nullable();
            $table->string('brand')->nullable();
            $table->text('comment')->nullable();
            $table->string('quantity');
            $table->float('fare', 10, 2);
            $table->foreignId('invoiced')->constrained('invoice_statuses')->onUpdate('cascade');
            $table->string('rcvd')->default('NO');
            $table->string('invoice_status');
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
