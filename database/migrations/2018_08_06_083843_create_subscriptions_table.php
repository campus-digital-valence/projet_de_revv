<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 8, 2);
            $table->boolean('opt_out_mail')->default(0); // 0 = opt_out OFF // 1 = opt_out ON
            $table->date('date_start');
            $table->date('date_end');
            $table->tinyInteger('subscription_source'); // 0 = Admin // 1 = web
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('subscription_type_id');
            $table->timestamps();

            $table->foreign('subscription_type_id')->references('id')->on('subscription_types');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
