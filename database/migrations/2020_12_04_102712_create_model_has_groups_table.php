<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelHasGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_has_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->integer('order')->default(0);
            $table->index(['model_id', 'model_type'], 'model_has_group_model_id_model_type_index');

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');

            $table->primary(['group_id', 'model_type', 'model_id'],
                    'model_has_groups_group_model_type_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_groups');
    }
}
