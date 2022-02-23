<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostMainCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('post_main_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('id');
            $table->string('main_category', 255)->unique()->comment('メインカテゴリー');
            $table->timestamp('created_at')->useCurrent()->comment('登録日時');
            $table->timestamp('updated_at')->default(DB::raw('current_timestamp on update current_timestamp'))->comment('更新日時');
            $table->softDeletes()->comment('削除日時');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_main_categories');
    }
}
