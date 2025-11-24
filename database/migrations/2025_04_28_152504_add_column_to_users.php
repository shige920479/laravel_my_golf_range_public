<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('firstname')->after('id');
            $table->string('lastname')->after('firstname');
            $table->string('firstnamekana')->after('lastname');
            $table->string('lastnamekana')->after('firstnamekana');
            $table->string('phone')->after('email');
            $table->tinyInteger('gender')->comment('0:male,1:female,2:others')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('firstnamekana');
            $table->dropColumn('lastnamekana');
            $table->dropColumn('phone');
            $table->dropColumn('gender');          
        });
    }
};
