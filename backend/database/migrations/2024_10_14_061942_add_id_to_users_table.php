<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Checking if the 'id' column doesn't exist and adding it
            if (!Schema::hasColumn('users', 'id')) {
                $table->id()->first(); // Adding the 'id' column as the first column
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Dropping the 'id' column if it exists
            if (Schema::hasColumn('users', 'id')) {
                $table->dropColumn('id');
            }
        });
    }
}
