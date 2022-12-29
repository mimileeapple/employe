<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create33Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //他會創建一個名稱為33的表格
        Schema::create('33', function (Blueprint $table) {
            //這是ID 有自增 裡面的字串是欄位名
            $table->bigIncrements('id');
            //這是VARCHAR 並且長度是100
            $table->string('name',50);
            //unique 是唯一索引 代表這個欄位內容不能重複
            $table->string('email',50)->unique();
            //	加入 created_at 和 updated_at 欄位。 並且此欄位允許寫入 NULL 值
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',50);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //這邊則是如果你要透過CMD刪除表格的話 他會做啥動作 現在就只是很簡單的刪除33這張表
        Schema::dropIfExists('33');
    }
}
