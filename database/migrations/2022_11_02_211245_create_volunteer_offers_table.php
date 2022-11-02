<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('npo_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            // $table->foreignId('occupation_id')
            //     ->constrained()
            //     ->cascadeOnUpdate()
            //     ->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->date('due_date');
            $table->boolean('is_published')->default(1);
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
        Schema::dropIfExists('volunteer_offers');
    }
}