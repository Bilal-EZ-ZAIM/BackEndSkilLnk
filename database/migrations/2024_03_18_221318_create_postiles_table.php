<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('postiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_freelancer');
            $table->unsignedBigInteger('id_offerdeomplis');
            
            $table->string('description');
            $table->timestamps();

            $table->foreign('id_freelancer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_offerdeomplis')->references('id')->on('offer_de_emplois')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postiles');
    }
};
