<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('category_id')->nullable();
            $table->string('transaction_details', 250);
            $table->enum('type', ['credit', 'debit'])->default('debit');
            $table->decimal('amount', $precision = 8, $scale = 2)->default(0);
            $table->decimal('balance_amount', $precision = 8, $scale = 2)->default(0);
            $table->string('note', 250)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
