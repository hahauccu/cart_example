<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DiscountCundition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_cundition', function (Blueprint $table) {
            $table->id();
            $table->text('discountCode');
            $table->text('discount_content');
            $table->integer('type');
            $table->integer('price_condition');
            $table->float('price');
            $table->timestamp('created_at')->useCurrent();
        });

        DB::table('discount_cundition')->insert(
        array(
                [
                    'discountCode' => "tenpErcentOff",
                    'type' => "1",
                    'price_condition' => "40000",
                    'price' => "0.9",
                    "discount_content"=>"if check price bigger than condition than get ten percent off"
                ],
                [
                    'discountCode' => "buy30000get1000Back",
                    'type' => "2",
                    'price_condition' => "30000",
                    'price' => "1000",
                    "discount_content"=>"if check price bigger than condition than get 1000 back"
                ],
                [
                    'discountCode' => "buy60000get3000Back",
                    'type' => "2",
                    'price_condition' => "60000",
                    'price' => "3000",
                    "discount_content"=>"if check price bigger than condition than get 3000 back"
                ],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('discount_cundition');
    }
}
