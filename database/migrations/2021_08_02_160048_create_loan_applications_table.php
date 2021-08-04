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
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('request_id')->unique();
            $table->foreignId('loan_type_id')->constrained();
            $table->foreignId('loan_interest_id')->constrained();
            $table->integer('term');
            $table->unsignedFloat('amount', 14);
            $table->unsignedFloat('emi', 14)->nullable();
            $table->boolean('is_approved')->nullable()->default(false);
            $table->integer('payment_count')->nullable()->default(0);
            $table->integer('pending_payment_count')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->dateTime('approved_at')->nullable();
            $table->softDeletes();
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
