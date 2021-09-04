<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('category_id');
            $table->integer('status');
            $table->text('content')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_desription')->nullabel();
            $table->string('tags')->nullable();
            $table->integer('author');
            $table->integer('like')->default(0);
            $table->integer('view')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->integer('status');
            $table->string('tags')->nullable();
            $table->integer('like')->default(0);
            $table->integer('view')->default(0);
            $table->string('seo_title')->nullable();
            $table->text('seo_desription')->nullabel();
            $table->timestamps();
        });
        
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullabel();
            $table->text('description')->nullable();
            $table->integer('status');
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('seo_title')->nullable();
            $table->text('seo_desription')->nullabel();
            $table->integer('like')->default(0);
            $table->integer('view')->default(0);
            $table->timestamps();
        });

        Schema::create('constants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value')->nullabel();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('comments');
            $table->integer('comment_id')->default(0);
            $table->integer('author');
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
        Schema::dropIfExists('posts');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('medias');
        Schema::dropIfExists('constants');
        Schema::dropIfExists('comments');
    }
}
