<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('email');
            $table->string('mobile');
            $table->string('image');
            $table->string('password');
            $table->string('type')->comment('1=admin,2=vendor|service-provider');
            $table->string('login_type');
            $table->string('description');
            $table->text('token');
            $table->string('payment_id');
            $table->string('plan_id');
            $table->string('purchase_amount');
            $table->string('purchase_date');
            $table->string('payment_type');
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->double('wallet')->default('0.0');
            $table->string('referral_code')->nullable();
            $table->string('otp')->nullable();
            $table->boolean('is_verified')->comment('1=yes,2=no');
            $table->boolean('is_available')->comment('1=yes,2=no');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
