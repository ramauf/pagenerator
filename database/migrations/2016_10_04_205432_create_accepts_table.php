<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accepts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->integer('posts_id');
            $table->string('time', 10);
            $table->string('uniq', 32);
            $table->enum('status', ['wait', 'accepted']);
            $table->unique('uniq');
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
        Schema::drop('accepts');
    }
}
