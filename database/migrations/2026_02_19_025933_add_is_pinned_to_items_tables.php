<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documentations', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false)->after('status');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false)->after('status');
        });
    }

    public function down()
    {
        Schema::table('documentations', function (Blueprint $table) {
            $table->dropColumn('is_pinned');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('is_pinned');
        });
    }
};