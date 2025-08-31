<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_submit_comment(): void
    {
        $article = Article::factory()->create();

        $res = $this->post(route('articles.comments.store', $article->slug), [
            'body' => 'Nice post',
        ]);

        $res->assertSessionHasErrors('auth');
    }

    public function test_authenticated_user_can_submit_comment_and_is_unapproved(): void
    {
        $this->be(User::factory()->create());
        $article = Article::factory()->create();

        $res = $this->post(route('articles.comments.store', $article->slug), [
            'body' => 'Nice post',
        ]);

        $res->assertSessionHas('status');
        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'body' => 'Nice post',
            'is_approved' => false,
        ]);
    }

    public function test_comment_validation_requires_body(): void
    {
        $this->be(User::factory()->create());
        $article = Article::factory()->create();

        $res = $this->post(route('articles.comments.store', $article->slug), [
            'body' => '',
        ]);

        $res->assertSessionHasErrors('body');
    }
}
