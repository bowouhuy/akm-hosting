<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExamDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exam_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('answer_id')->unsigned();
            $table->integer('question_no');
            $table->enum('answer_status', ['1', '0'])->default('0');
            $table->enum('answer_key', ['yes', 'no'])->nullable();
            $table->timestamps();

            $table->foreign('exam_id')
                ->references('id')
                ->on('exams')
                ->onDelete('cascade');
            
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade');
            
            $table->foreign('answer_id')
                ->references('id')
                ->on('answers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_details');
    }
}
