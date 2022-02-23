<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('post_sub_category_id')
                ->references('id')
                ->on('post_sub_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('delete_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('update_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['post_sub_category_id']);
            $table->dropForeign(['delete_user_id']);
            $table->dropForeign(['update_user_id']);
        });
    }
}
