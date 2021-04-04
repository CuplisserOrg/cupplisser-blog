<?php

namespace Cupplisser\Blog\Contracts;

use Cupplisser\Blog\Models\CCategory;

interface BlogCategoryPolicyInterface
{
    public function view($user);
    public function create($user);
    public function edit($user, CCategory $category);
    public function delete($user, CCategory $category);
}