<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * https://wiki.squid-cache.org/ConfigExamples/Authenticate/Mysql
         * Changing column names will not work
         */
        Schema::create('squid_users', function (Blueprint $table) {
            $table->id();
            $table->string('user')->unique();
            $table->string('password');
            $table->tinyInteger('enabled')->default(1);
            $table->string('fullname')->default(null)->nullable();
            $table->string('comment')->default(null)->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('squid_users');
    }
};
