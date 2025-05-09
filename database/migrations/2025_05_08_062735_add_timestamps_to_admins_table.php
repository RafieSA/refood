<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'created_at') && !Schema::hasColumn('admins', 'updated_at')) {
                $table->timestamps(); // Tambahkan kolom created_at dan updated_at
            }
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'created_at') && Schema::hasColumn('admins', 'updated_at')) {
                $table->dropTimestamps(); // Hapus kolom created_at dan updated_at
            }
        });
    }
};