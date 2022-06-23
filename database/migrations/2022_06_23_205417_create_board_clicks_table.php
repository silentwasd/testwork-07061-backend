<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('board_clicks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('board_item_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // If not authenticated
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('board_clicks');
    }
};
