<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostSubCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('post_sub_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('id');
            $table->integer('post_main_category_id')->comment('メインカテゴリーid');
            $table->string('sub_category', 255)->unique()->comment('サブカテゴリー');
            $table->timestamp('created_at')->useCurrent()->comment('登録日時');
            $table->timestamp('updated_at')->default(DB::raw('current_timestamp on update current_timestamp'))->comment('更新日時');
            $table->softDeletes()->comment('削除日時');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_sub_categories');
    }
}
