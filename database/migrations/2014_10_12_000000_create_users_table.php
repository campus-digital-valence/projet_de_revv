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
            $table->tinyInteger('gender');
            $table->string('lastname', 45);
            $table->string('firstname', 45);
            $table->date('birthdate');
            $table->string('password');
            $table->string('address_line1', 100);
            $table->string('address_line2', 100)->nullable();
            $table->string('zipcode', 20);
            $table->string('city', 45);
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('gender_joint')->nullable();
            $table->string('lastname_joint', 45)->nullable();
            $table->string('firstname_joint', 45)->nullable();
            $table->date('birthdate_joint')->nullable();
            $table->string('email_joint')->nullable();
            $table->string('phone_1', 10)->nullable();
            $table->string('phone_2', 10)->nullable();
            $table->boolean('volonteer')->default(0);
            $table->text('details_volonteer', 600)->nullable();
            $table->boolean('delivery')->default(0);
            $table->boolean('newspaper')->default(0);
            $table->boolean('newsletter')->default(0);
            $table->boolean('mailing')->default(0);
            $table->text('comment')->nullable();
            $table->boolean('alert')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
