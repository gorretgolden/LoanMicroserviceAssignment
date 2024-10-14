<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');//customer id foreignkey
            $table->integer('loan_amount');//loan amount
            $table->integer('repayment_period');//repayment
            $table->string('loan_purpose'); // Loan purpose
            $table->string('status')->default('PENDING'); // Loan status with default value as pending
            //relationship between customers and loan_applications
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('loan_applications');
    }
}
