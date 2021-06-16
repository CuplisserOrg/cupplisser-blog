<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->create_blog();
        $this->create_categories();
        $this->create_tag();
        $this->create_image();
        $this->create_comments();
        $this->create_likes();
        $this->create_newletter();
        $this->create_pages();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_pages');
        Schema::dropIfExists("blog_newsletter_subscriptions");
        Schema::dropIfExists("blog_likes");
        Schema::dropIfExists("blog_comments");
        Schema::dropIfExists("blog_post_images");
        Schema::dropIfExists("blog_post_comments");
        Schema::dropIfExists("blog_post_destinations");
        Schema::dropIfExists("blog_taggables");
        Schema::dropIfExists("blog_tags");;
        Schema::dropIfExists("blog_categoryable");
        Schema::dropIfExists("blog_categories");
        Schema::dropIfExists("blog_posts");
    }

    private function create_blog()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $users = config('cblog.users.table');
            $table->increments('id');
            $table->unsignedBigInteger("author_id")->nullable();
            $table->string("title");
            $table->string("slug")->nullable();
            $table->longText("content");
            $table->unsignedInteger("blog_image_id")->nullable();
            $table->char("status", 1)->default("D");
            $table->char("format", 1)->default("S");
            $table->boolean("is_featured")->default(0);
            $table->boolean("is_approved");
            $table->unsignedBigInteger("approved_by")->nullable();
            $table->boolean("comments_enabled")->nullable();
            $table->timestamp("published_at")->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->timestamps();
            $table->softDeletes();

            if (Schema::hasTable($users)) {
                $table->foreign("author_id")
                    ->references("id")
                    ->on($users);

                $table->foreign("approved_by")
                    ->references("id")
                    ->on($users);
            }

        });
    }

    private function create_categories()
    {
        Schema::create("blog_categories", function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->text("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("blog_categoryable", function (Blueprint $table) {
            $table->unsignedBigInteger("category_id");
            $table->morphs('categoryable');
        });
    }

    public function create_tag()
    {
        Schema::create("blog_tags", function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("blog_taggables", function (Blueprint $table) {
            $table->unsignedInteger("blog_tag_id");
            $table->morphs('taggables');


            $table->foreign("blog_tag_id")
                ->references("id")
                ->on("blog_tags")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }



    public function create_image()
    {
        Schema::create("blog_post_images", function (Blueprint $table) {
            $table->increments("id");
            $table->string("storage_location");
            $table->string("path");
            $table->string("caption")->nullable();
            $table->string("alt_text")->nullable();
            $table->morphs("imageable");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function create_comments(){
        Schema::create('blog_comments', function (Blueprint $table) {

            $users = config('cblog.users.table');
            $table->increments('id');

            $table->unsignedInteger("parent_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string("name")->nullable();
            $table->string("email")->nullable();
            $table->text("body");
            $table->char("status", 1);
            $table->unsignedBigInteger("moderated_by")->nullable();
            $table->datetime("moderated_at")->nullable();
            $table->morphs("commentable");
            $table->timestamps();
            $table->timestamp("deleted_at")->nullable();


            $table->foreign("user_id")
                ->references("id")
                ->on($users)
                ->onUpdate("cascade")
                ->onDelete("no action");

            $table->foreign("moderated_by")
                ->references("id")
                ->on($users)
                ->onUpdate("cascade")
                ->onDelete("no action");

            $table->foreign("parent_id")->references("id")->on("blog_comments")
                ->onUpdate("cascade")->onDelete("set null");
        });
    }

    public function create_likes(){
       Schema::create('blog_likes', function (Blueprint $table) {
            $users = config('cblog.users.table');
            $table->increments('id');
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on($users);

            $table->nullableMorphs('likeable');

            $table->timestamps();
        });
    }

    public function create_newletter()
    {
        Schema::create('blog_newsletter_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function create_pages(){
        Schema::create('blog_pages', function (Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('title', 200);
            $table->string('slug', 100);
            $table->text('content');
            $table->timestamps();
        });
    }
}
