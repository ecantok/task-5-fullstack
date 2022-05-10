<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_redirect_if_user_not_authenticated()
    {
        $this->get('/articles')->assertRedirect('/login');
        $this->get('/articles/create')->assertRedirect('/login');
        $this->get('/categories')->assertRedirect('/login');
        $this->get('/categories/create')->assertRedirect('/login');
    }

    public function test_register_success()
    {

        $response = $this->post('/register', [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response->assertRedirect('/articles');
    }

    public function test_login_success()
    {
        $response = $this->post('/login', [
            'email' => 'usertest@email.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/articles');
    }

    public function test_login_failed()
    {
        $response = $this->post('/login', [
            'email' => 'usertest@email.com',
            'password' => 'invalid-password'
        ]);

        $response->assertRedirect('/');
    }

    // Jika ada cacing merah di bawah $user abaikan saja

    public function test_list_all_articles_can_be_rendered()
    {
        $user = User::factory()->create();
 
        $response = $this->actingAs($user)->get('/articles');
        $response->assertStatus(200);
        $response->assertSee('List All Articles');
    }

    public function test_show_detail_articles()
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user)->create();

        $response = $this->actingAs($user)->get('/articles/'.$article->id);
        $response->assertStatus(200);
        $response->assertSee($article->title)
            ->assertSee("By: ".$article->user->name);
    }

    public function test_article_form_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/articles/create');
        $response->assertStatus(200);
        $response->assertSee("Create New Article");
    }

    public function test_create_article_success()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/articles', [
            'title' => $this->faker->title(),
            'content' => $this->faker->sentence(),
            // Image dikosongkan jadi pakai placeholder.png
            'user_id' => $user->id,
            'category_id' => 2
        ]);
        $response->assertRedirect('/articles');
        $response->assertSessionHas('success', 'New Article has been added!');
    }

    public function test_edit_article_form_can_be_rendered()
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user)->create();

        $response = $this->actingAs($user)->get('/articles/'.$article->id.'/edit');
        $response->assertStatus(200)
            ->assertSee("Edit Article");
    }

    public function test_edit_article_success()
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user)->create();

        $response = $this->actingAs($user)->put('/articles/'.$article->id, [
            'title' => $this->faker->title(),
            'content' => $this->faker->sentence(),
            // Image tidak diedit
            'user_id' => $user->id,
            'category_id' => 2
        ]);
        $response->assertRedirect('/articles');
        $response->assertSessionHas('success', 'Article has been edited!');
    }

    public function test_delete_article()
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete('/articles/'.$article->id);

        $response->assertStatus(302);
        $response->assertSessionHas('delete', 'Article successfully removed');
    }

        public function categories_can_be_rendered()
    {
        $user = User::factory()->create();
 
        $response = $this->actingAs($user)->get('/categories');
        $response->assertStatus(200);
        $response->assertSee('List All Categories');
    }
    public function test_category_form_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/categories/create');
        $response->assertStatus(200);
        $response->assertSee("Create New Category");
    }

    public function test_create_category_success()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/categories', [
            'name' => $this->faker->title(),
            'user_id' => $user->id,
        ]);
        $response->assertRedirect('/categories');
        $response->assertSessionHas('success', 'New category has been added!');
    }

    public function test_edit_category_form_can_be_rendered()
    {
        $user = User::factory()->create();
        $category = Category::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("categories/".$category->id."/edit");
        $response->assertStatus(200);
        $response->assertSee('Edit Category');
        $response->assertSee($category->name);
    }

    public function test_edit_category_success()
    {
        $user = User::factory()->create();
        $category = Category::factory()->for($user)->create();

        $response = $this->actingAs($user)->put('/categories/'.$category->id, [
            'name' => $this->faker->title(),
            'user_id' => $user->id,
        ]);
        $response->assertRedirect('/categories');
        $response->assertSessionHas('success', 'Category has been edited!');
    }

    public function test_delete_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete('/categories/'.$category->id);

        $response->assertStatus(302);
        $response->assertSessionHas('delete', 'Category successfully removed');
    }
}
