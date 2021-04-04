<?php

namespace Cupplisser\Blog\Contracts;

use Cupplisser\Blog\Models\CPosts;

interface BlogPostPolicyInterface
{
    public function view($user);
    public function view_draft_post($user, CPosts $post);
    public function create($user);
    public function edit($user, CPosts $post);
    public function delete($user, CPosts $post);
}
