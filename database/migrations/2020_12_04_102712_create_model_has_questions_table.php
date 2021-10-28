<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelHasQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_has_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->integer('order')->default(0);
            $table->index(['model_id', 'model_type'], 'model_has_question_model_id_model_type_index');

            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade');

            $table->primary(['question_id', 'model_type', 'model_id'],
                    'model_has_questions_question_model_type_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_questions');
    }
}
