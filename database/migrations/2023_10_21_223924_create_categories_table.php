<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //        Schema::create('categories', function (Blueprint $table) {
        //            $table->id();
        //            $table->foreign('id_user')->references('id')->on('users');
        //            $table->string('categories');
        //            $table->string('badge');
        //            $table->timestamps();
        //        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //        Schema::dropIfExists('categories');
    }
};
