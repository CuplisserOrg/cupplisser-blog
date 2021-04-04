<?php namespace Cupplisser\Blog\Policies;

use Cupplisser\Blog\Contracts\BlogPostPolicyInterface;
use Cupplisser\Blog\Models\CPosts;

class BlogPostPolicy extends BasePolicy implements BlogPostPolicyInterface{
    public function view($user)
    {
        return true;
    }

    public function view_draft_post($user, CPosts $post)
    {
        return true;
    }

    public function create($user)
    {
        return true;
    }

    public function edit($user, CPosts $post)
    {
        return true;
    }

    public function delete($user, CPosts $post)
    {
        return true;
    }
}