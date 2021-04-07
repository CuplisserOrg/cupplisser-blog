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
        // $this->create_comment();
        $this->create_image();
        $this->create_comments();
        $this->create_likes();
        $this->create_newletter();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("newsletter_subscriptions");
        Schema::dropIfExists("blog_likes");
        Schema::dropIfExists("blog_comments");
        Schema::dropIfExists("blog_post_images");
        Schema::dropIfExists("blog_post_comments");
        Schema::dropIfExists("blog_post_destinations");
        Schema::dropIfExists("blog_post_tags");
        Schema::dropIfExists("blog_tags");;
        Schema::dropIfExists("blog_post_categories");
        Schema::dropIfExists("blog_categories");
        Schema::dropIfExists("blog_posts");
    }

    private function create_blog()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("author_id")->nullable();
            $table->string("title");
            $table->string("slug")->nullable();
            $table->string("fb_slug");
            $table->longText("content");
            $table->unsignedInteger("blog_image_id")->nullable();
            $table->char("status", 1)->default("D");
            $table->char("format", 1)->default("S");
            $table->boolean("is_featured")->default(0);
            $table->boolean("is_approved");
            $table->unsignedInteger("approved_by")->nullable();
            $table->boolean("comments_enabled")->nullable();
            $table->timestamp("published_at")->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->timestamps();
            $table->softDeletes();

            if (Schema::hasTable("users")) {
                $table->foreign("author_id")
                    ->references("id")
                    ->on("users");

                $table->foreign("approved_by")
                    ->references("id")
                    ->on("users");
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

        Schema::create("blog_post_categories", function (Blueprint $table) {
            $table->increments("id");
            $table->morphs('categories');
            $table->unsignedInteger("blog_post_id");
            $table->unsignedInteger("blog_category_id");

            $table->unique(['blog_post_id', 'blog_category_id']);

            $table->foreign("blog_post_id")
                ->references("id")
                ->on("blog_posts")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->foreign("blog_category_id")
                ->references("id")
                ->on("blog_categories")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }

    public function create_tag()
    {
        Schema::create("blog_tags", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("site_id")->nullable();
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("blog_post_tags", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("blog_post_id");
            $table->unsignedInteger("blog_tag_id");
            $table->morphs('taggables');

            $table->unique(['blog_tag_id', 'blog_post_id']);

            $table->foreign("blog_post_id")
                ->references("id")
                ->on("blog_posts")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->foreign("blog_tag_id")
                ->references("id")
                ->on("blog_tags")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }

    public function create_comment()
    {
        Schema::create("blog_post_comments", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("blog_post_id");
            $table->unsignedInteger("author_id");
            $table->unsignedInteger("parent_id")->nullable();
            $table->integer("depth")->default(1);
            $table->char("status", 1)->default("P");
            $table->text("content");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("blog_post_id")
                ->references("id")
                ->on("blog_posts");

            if (Schema::hasTable("users")) {
                $table->foreign("author_id")
                    ->references("id")
                    ->on("users");
            }

            $table->foreign("parent_id")
                ->references("id")
                ->on("blog_post_comments");
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
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function create_comments(){
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("post_id");
            $table->unsignedInteger("parent_id")->nullable();
            $table->unsignedInteger("user_id")->nullable();
            $table->string("name")->nullable();
            $table->string("email")->nullable();
            $table->text("body");
            $table->char("status", 1);
            $table->unsignedInteger("moderated_by")->nullable();
            $table->datetime("moderated_at")->nullable();
            $table->timestamps();
            $table->timestamp("deleted_at")->nullable();

            $table->foreign("post_id")
                ->references("id")
                ->on("blog_posts")
                ->onUpdate("cascade")
                ->onDelete("no action");

            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onUpdate("cascade")
                ->onDelete("no action");

            $table->foreign("moderated_by")
                ->references("id")
                ->on("users")
                ->onUpdate("cascade")
                ->onDelete("no action");

            $table->foreign("parent_id")->references("id")->on("blog_comments")
                ->onUpdate("cascade")->onDelete("set null");
        });
    }

    public function create_likes(){
       Schema::create('blog_likes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('users');

            $table->nullableMorphs('likeable');

            $table->timestamps();
        });
    }

    public function create_newletter()
    {
        Schema::create('newsletter_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }
}
