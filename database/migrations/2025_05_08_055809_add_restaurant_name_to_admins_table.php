<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('Restaurant_Name')->nullable()->after('email'); // Tambahkan kolom Restaurant_Name
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('Restaurant_Name');
        });
    }
};