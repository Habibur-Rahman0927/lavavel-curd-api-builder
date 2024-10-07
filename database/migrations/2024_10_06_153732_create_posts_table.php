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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 55)->nullable()->default('test')->unique()->index()->comment('test');
            $table->integer('integer')->unsigned()->nullable()->default(1)->unique()->index()->comment('test');
            $table->boolean('status')->nullable()->default(0)->comment('test');
            $table->text('description1')->nullable()->comment('test');
            $table->mediumText('description2')->nullable()->comment('test');
            $table->longText('description3')->nullable()->comment('test');
            $table->date('event_date')->nullable()->default(now())->index()->unique()->comment('The date of the event');
            $table->dateTime('event_date_time')->nullable()->default(now())->index()->unique()->comment('The date and time of the event');
            $table->float('float_field', 8, 2)->unsigned()->nullable()->default(0)->index()->unique()->comment('The float_field');
            $table->double('double_field', 8, 2)->unsigned()->nullable()->default(0)->index()->unique()->comment('The double_field');
            $table->decimal('decimal_field', 8, 2)->unsigned()->nullable()->default(0)->index()->unique()->comment('The decimal_field');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
