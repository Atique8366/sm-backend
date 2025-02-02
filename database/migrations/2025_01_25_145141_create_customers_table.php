<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_no')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('payment_rcv', 10, 2)->default(0);
            $table->decimal('pending_payment', 10, 2)->default(0);
            $table->decimal('total_bill', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('profit_from_customer', 10, 2)->default(0);
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
        Schema::dropIfExists('customers');
    }
}
