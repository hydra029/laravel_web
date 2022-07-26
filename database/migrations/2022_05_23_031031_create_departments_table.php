<?php

use App\Models\Department;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('departments', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softDeletes();
        });
        Department::insert(['name' => 'Accountant']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
}
