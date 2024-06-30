<?php

declare(strict_types=1);

namespace Database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('guard_name');
            $table->text('description')->nullable()->after('guard_name');
            $table->string('key')->nullable()->after('guard_name');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('guard_name');
            $table->text('description')->nullable()->after('guard_name');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('display_name');
            $table->dropColumn('description');
            $table->dropColumn('key');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('display_name');
            $table->dropColumn('description');
            $table->dropColumn('deleted_at');
        });
    }

};
