<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('notificationToken')->nullable()->unique();
            $table->string('deviceID')->nullable()->unique();

            $table->string('deviceModel', 100)->index()->nullable();
            $table->string('deviceOS', 50)->index()->nullable();
            $table->string('deviceOSVersion', 50)->index()->nullable();

            $table->string('appBuild', 50)->index()->nullable();
            $table->string('appLang', 50)->index()->nullable();
            $table->string('appThemeMode', 50)->index()->nullable();

            $table->ipAddress('ip')->nullable();
            $table->string('countryIp', 50)->index()->nullable();
            $table->string('countryCodeIp', 50)->index()->nullable();
            $table->string('cityIp', 50)->index()->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('devices');
    }
};
