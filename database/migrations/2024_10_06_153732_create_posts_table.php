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
            $table->bigInteger('user_id')->nullable()->default(1)->unsigned()->index()->unique()->comment('test');
            $table->binary('file_data')->nullable()->comment('Binary file data');
            $table->boolean('status')->nullable()->default(0)->comment('test');
            $table->char('code', 10)->nullable()->default('XXXXXX')->index()->unique()->comment('Unique code for identifying records'); 
            $table->date('event_date')->nullable()->default(now())->index()->unique()->comment('The date of the event');
            $table->dateTime('event_date_time')->nullable()->default(now())->index()->unique()->comment('The date and time of the event');
            $table->float('float_field', 8, 2)->unsigned()->nullable()->default(0)->index()->unique()->comment('The float_field');
            $table->decimal('decimal_field', 8, 2)->unsigned()->nullable()->default(0)->index()->unique()->comment('The decimal_field');
            $table->double('double_field', 8, 2)->unsigned()->nullable()->default(0)->index()->unique()->comment('The double_field');
            $table->integer('integer')->unsigned()->nullable()->default(1)->unique()->index()->comment('test');
            $table->ipAddress('ip_address', 30)->nullable()->default('null')->index()->unique()->comment('User IP address');
            $table->json('settings', 33)->nullable()->comment('Settings in JSON format'); 
            $table->longText('description3')->nullable()->comment('test');
            $table->macAddress('mac_address', 33)->nullable()->default('null')->unique()->index()->comment('MAC address of the device'); 
            $table->mediumInteger('example_field')->unsigned()->nullable()->default(0)->unique()->index()->comment('Example medium integer field');
            $table->mediumText('description2')->nullable()->comment('test');
            $table->smallInteger('small_int')->unsigned()->nullable()->default(1)->index()->unique()->comment('Small integer field for example');  
            $table->string('title', 55)->nullable()->default('test')->unique()->index()->comment('test');
            $table->text('description1')->nullable()->comment('test');
            $table->time('opening_time')->nullable()->default('09:00:00')->index()->unique()->comment('Opening time of the store');
            $table->tinyInteger('tinyInteger')->unsigned()->default(1)->nullable()->index()->unique()->comment('Status of the record');
            $table->tinyText('short_description', 255)->nullable()->comment('Short description of the record'); 
            $table->unsignedBigInteger('un_user_id')->unsigned()->nullable()->default(1)->index()->unique()->comment('Foreign key for user ID');
            $table->unsignedInteger('unsignedInteger')->unsigned()->nullable()->default(1)->index()->unique()->comment('Foreign key for user ID');
            $table->unsignedMediumInteger('unsignedMediumInteger')->unsigned()->nullable()->default(1)->index()->unique()->comment('Foreign key for user ID');
            $table->unsignedSmallInteger('unsignedSmallInteger')->unsigned()->nullable()->default(1)->index()->unique()->comment('Foreign key for user ID');
            $table->unsignedTinyInteger('unsignedTinyInteger')->unsigned()->nullable()->default(1)->index()->unique()->comment('Foreign key for user ID');
            $table->uuid('uuid')->nullable()->default('fkjsa')->index()->unique()->comment('Universally unique identifier');
            $table->year('published_year')->nullable()->default('1901')->index()->unique()->comment('Year of publication');
            
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
