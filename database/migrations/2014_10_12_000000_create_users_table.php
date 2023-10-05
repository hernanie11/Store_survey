<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments("id");
            $table->string("id_prefix");
            $table->string("id_no")->unique();
            $table->string("first_name");
            $table->string("middle_name")->nullable();
            $table->string("last_name");
            $table->enum("sex", ["male", "female"]);
            $table->string('username');
            $table->string('password');
            $table->string("location_name");

            $table->string("department_name");

            $table->string("company_name");
            $table->unsignedInteger("role_id");
            // $table->integer('role_id');
            $table->boolean('is_active')->default(true);
            $table->foreign('role_id')
            ->references('id')
            ->on('role_management')
            ->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
