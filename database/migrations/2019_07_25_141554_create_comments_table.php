<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appid')->index()->comment('数据所属项目id');
            $table->string('commentable_id')->nullable(); // 暂定评论的内容id
            $table->string('commentable_type')->nullable(); // 暂定内容：文章
            $table->index(['commentable_id', 'commentable_type']);
            $table->string('commented_id')->nullable(); // 暂定评论的用户id   评论人用 commented
            $table->string('commented_type')->nullable(); // 暂定用户
            $table->index(['commented_id', 'commented_type']);
            $table->longText('comment'); // 评论正文
            $table->integer('rank')->default(0); // 认可热度排序 用户的评论，别人可以支持或者反对
            $table->integer('reply_id')->default(0);  // 回复id，如果有引用别人的话咯
            $table->integer('like')->default(0);    //喜欢
            $table->integer('upvote')->default(0);  //认同人数
            $table->integer('downvote')->default(0);  //否定人数
            $table->integer('reply')->default(0);   //回复人数
            $table->tinyInteger('approve')->default(0);     // 0是未经过审核的 1是审核通过的 -1是审核不通过的
            $table->timestamp('approved_at')->nullable();   // 审核时间
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
        Schema::dropIfExists('comments');
    }
}
