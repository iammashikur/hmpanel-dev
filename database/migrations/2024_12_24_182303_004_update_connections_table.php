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
        Schema::table('connections', function (Blueprint $table) {
            $table
                ->bigInteger('application_id')
                ->unsigned()
                ->after('connection_type_id');
            $table
                ->bigInteger('user_id')
                ->unsigned()
                ->after('application_id');
            $table
                ->foreign('application_id')
                ->references('id')
                ->on('applications')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::table('connections', function (Blueprint $table) {
            $table->dropColumn('application_id');
            $table->dropColumn('user_id');
            $table->dropForeign('connections_application_id_foreign');
            $table->dropForeign('connections_user_id_foreign');
        });
    }
};
