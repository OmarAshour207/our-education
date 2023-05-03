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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('paidAmount');
            $table->string('currency');
            $table->string('parentEmail');
            $table->foreign('parentEmail')->references('email')->on('users')->onDelete('cascade');
            $table->enum('statusCode', [1, 2, 3]);
            $table->date('paymentDate');
            $table->string('parentIdentification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
