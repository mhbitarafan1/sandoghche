<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchaseFieldsToLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lotteries', function (Blueprint $table) {
            $table->timestamp('purchase_time')->nullable();
            $table->string('purchase_product_id')->nullable();
            $table->string('purchase_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lotteries', function (Blueprint $table) {
            $table->dropColumn('purchase_time');
            $table->dropColumn('purchase_product_id');
            $table->dropColumn('purchase_token');
        });
    }
}
