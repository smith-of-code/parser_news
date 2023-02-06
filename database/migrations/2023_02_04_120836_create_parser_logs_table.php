<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parser_logs', function (Blueprint $table) {
            $table->id();
            $table->string('req_method',6)->comment('Request Method');
            $table->text('req_url')->comment('Request URL');
            $table->string('res_status',3)->comment('Response HTTP Code');
            $table->longText('res_body')->comment('Response Body');
            $table->string('duration')->comment('Время выполнения запроса в миллисекундах');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parser_logs');
    }
};
