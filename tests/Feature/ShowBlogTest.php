<?php

namespace BinaryTorch\Blogged\Tests\Feature;

use BinaryTorch\Blogged\Tests\TestCase;
use BinaryTorch\Blogged\Models\Article;

class ShowBlogTest extends TestCase
{
    /** @test */
    public function a_guest_can_view_the_blog_home_page()
    {
        $article = factory(Article::class)->create(['title' => 'How to become a developer in 1 min?']);

        $this->get('/blog')
            ->assertStatus(200)
            ->assertSee('How to become a developer in 1 min?');
    }
}
