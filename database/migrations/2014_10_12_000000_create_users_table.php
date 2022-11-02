<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('profile')->nullable();
            // 追加
            // $table->date('birthdate')->nullable(); //comment('生年月日');
            // $table->tinyInteger('gender')->unsigned()->comment('性別');
            // $table->string('zip', 10)->comment('郵便番号');
            // $table->tinyInteger('prefecture_code')->unsigned()->comment('都道府県コード');
            // $table->string('prefecture', 40)->comment('都道府県名 フリーテキスト検索で使用');
            // $table->string('address')->nullable()->comment('住所2');
            // $table->string('tel', 20)->comment('電話番号');
            // $table->softDeletes()->comment('削除日時：削除・退会を行った日時 この値がnillでなかったら');
            // $table->text('want_to_do')->nullable()->comment('したいこと');
            // $table->string('my_job')->comment('現在の仕事');
            // $table->string('language')->comment('話せる言語');
            // $table->string('university_name')->nullable()->comment('大学名');
            // $table->string('university_major')->nullable()->comment('大学専攻');
            // $table->string('university_grade')->nullable()->comment('大学学年');
            // $table->date('volunteer_start')->comment('ボランティア開始日');
            // $table->string('volunteer_region')->nullable()->comment('ボランティア地域');
            // $table->tinyInteger('volunteer_type')->comment('場所:1:現地へ行く 2:テレワーク');
            // $table->string('volunteer_cause')->comment('ボランティアしたい問題');
            // $table->tinyInteger('volunteer_length')->nullable()->comment('期間:1:1ヶ月未満 2:1ヶ月以上');
            // ここまで追加
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
