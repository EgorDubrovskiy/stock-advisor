<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedInteger('industry_id')->nullable()->change();
            $table->unsignedInteger('issue_type_id')->nullable()->change();
            $table->unsignedInteger('sector_id')->nullable()->change();
            $table->string('name', 255)->nullable()->change();
            $table->string('exchange', 255)->nullable()->change();
            $table->string('website', 180)->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('ceo', 64)->nullable()->change();
            $table->boolean('is_enabled')->nullable();
            $table->date('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedInteger('industry_id')->change();
            $table->unsignedInteger('issue_type_id')->change();
            $table->unsignedInteger('sector_id')->change();
            $table->string('name', 255)->change();
            $table->string('exchange', 255)->change();
            $table->string('website', 180)->change();
            $table->string('description', 255)->change();
            $table->string('ceo', 64)->change();
            $table->dropColumn(['is_enabled', 'created_at']);
        });
    }
}
