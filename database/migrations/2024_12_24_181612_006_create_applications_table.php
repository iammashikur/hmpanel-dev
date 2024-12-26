<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('technology_id');
            $table->bigInteger('technology_version_id')->unsigned();
            $table->string('domain');
            $table->string('directory');
            $table->bigInteger('database_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table
                ->foreign('technology_id')
                ->references('id')
                ->on('technologies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('technology_version_id')
                ->references('id')
                ->on('technology_version')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('database_id')
                ->references('id')
                ->on('databases')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
