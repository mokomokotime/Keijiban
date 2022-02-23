<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('id');
            $table->integer('user_id')->comment('ユーザーid');
            $table->integer('post_sub_category_id')->comment('投稿サブカテゴリーid');
            $table->integer('delete_user_id')->nullable()->comment('誰が消したか');
            $table->integer('update_user_id')->nullable()->comment('誰が編集したか');
            $table->string('title', 255)->comment('タイトル');
            $table->string('post', 5000)->comment('投稿');
            $table->datetime('event_at')->comment('何年何月何日の投稿か');
            $table->timestamp('created_at')->useCurrent()->comment('登録日時');
            $table->timestamp('updated_at')->default(DB::raw('current_timestamp on update current_timestamp'))->comment('更新日時');
            $table->softDeletes()->comment('削除日時');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
