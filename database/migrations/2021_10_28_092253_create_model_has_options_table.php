<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelHasOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_has_options', function (Blueprint $table) {
            $table->unsignedBigInteger('option_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->integer('order')->default(0);
            $table->index(['model_id', 'model_type'], 'model_has_option_model_id_model_type_index');

            $table->foreign('option_id')
                ->references('id')
                ->on('options')
                ->onDelete('cascade');

            $table->primary(['option_id', 'model_type', 'model_id'],
                    'model_has_options_question_model_type_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_options');
    }
}
