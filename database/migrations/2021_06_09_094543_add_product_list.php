<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_list', function (Blueprint $table) {
            $table->id();
            $table->text('product_name');
            $table->text('img_src');
            $table->integer('stock');
            $table->timestamp('failed_at')->useCurrent();
        });

        DB::table('product_list')->insert(
        array(
                [
                    'product_name' => "3070",
                    'img_src' => "images/3070.jpg",
                    'stock' => "1",
                ],
                [
                    'product_name' => "3080",
                    'img_src' => "images/3080.jpg",
                    'stock' => "1",
                ],
                [
                    'product_name' => "3090",
                    'img_src' => "images/3090.jpg",
                    'stock' => "2",
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
        Schema::table('product-list', function (Blueprint $table) {
            //
        });
    }
}
