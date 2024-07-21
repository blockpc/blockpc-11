<?php

declare(strict_types=1);

namespace Database\migrations;

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('password_changed_at')->nullable()->after('password');
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('image')->nullable();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
        });

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->morphs('imageable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('password_changed_at');
        });

        Schema::dropIfExists('profiles');
        Schema::dropIfExists('images');
    }
};
