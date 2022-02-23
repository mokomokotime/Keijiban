<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToPostSubCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('post_sub_categories', function (Blueprint $table) {

            $table->foreign('post_main_category_id')
                ->references('id')
                ->on('post_main_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('post_sub_categories', function (Blueprint $table) {
            $table->dropForeign(['post_main_category_id']);
        });
    }
}
