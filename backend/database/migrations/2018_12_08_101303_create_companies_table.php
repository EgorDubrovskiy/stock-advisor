<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('industry_id');
                $table->unsignedInteger('issue_type_id');
                $table->unsignedInteger('sector_id');
                $table->string('symbol', 8)->unique();
                $table->string('name', 255);
                $table->string('exchange', 255);
                $table->string('website', 180);
                $table->string('description', 255);
                $table->string('ceo', 64);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('companies');
    }
}
