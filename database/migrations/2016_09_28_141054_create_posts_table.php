<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('points_idFrom');
            $table->integer('points_idTo');
            $table->integer('users_id');
            $table->string('totalPlace', 1);
            $table->string('freePlace', 1);
            $table->enum('status', ['wait', 'filled', 'done']);
            $table->string('cost', 10);
            $table->string('distance', 10);
            $table->string('duration', 10);
            $table->string('createdTime', 10);
            $table->text('startTime', 10);
            $table->text('endTime', 10);
            $table->enum('luggage', ['none', 'small', 'medium', 'large']);
            $table->mediumText('comment');
            $table->engine = 'MYISAM';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
