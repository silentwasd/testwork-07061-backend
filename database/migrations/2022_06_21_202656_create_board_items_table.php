<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('board_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->text('content')->fulltext();
            $table->string('item_type');

            $table->string('price_type')->default('simple');
            $table->string('price_range')->default('exact');
            $table->integer('price_value')->unsigned();

            $table->timestamp('published_at')->nullable();
            $table->timestamp('removed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('board_items');
    }
};
