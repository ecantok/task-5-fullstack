<?php

namespace Tests\Feature;

use App\Models\Article;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ApiTest extends TestCase
{

    use RefreshDatabase, WithFaker;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->seed();
    }

    public function test_api_register()
    {
        $response = $this->postJson('api/v1/register', [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password'  => '12345678'
            
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'code' => 200,
            'message' => 'User succesfully registered, you may now login'
        ]);
    }

    public function test_api_login_success()
    {
        $login = UserFactory::new()->create();
        $response = $this->postJson('api/v1/login', [
            'email' => $login->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);

        $this->assertArrayHasKey('access-token', $response->json());

    }

    public function test_api_login_failed()
    {
        $login = [
            'email' => 'usertest@email.com',
            'password' => 'invalid-password'
        ];
        $response = $this->postJson('api/v1/login', $login);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'Invalid Login Credentials'
        ]);
    }

    public function test_api_list_all_posts()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );

        $response = $this->getJson('api/v1/posts');

        $response->assertStatus(200);
    }

    public function test_api_list_all_posts_pagination()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );

        $response = $this->getJson('api/v1/posts?page=2');

        $response->assertStatus(200);
    }
    
    public function test_api_show_detail_post_by_id()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );

        $this->getJson('api/v1/posts/5')
            ->assertJson([
                'message' => 'Show detail'
            ])
            ->assertStatus(200);
    }

    public function test_api_store_post()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );

        $store = [
            'title' => $this->faker->title(),
            'content' => $this->faker->sentence(),
            'image' => 'placeholder.png',
            'user_id' => 1,
            'category_id' => 2
        ];

        $this->postJson('api/v1/posts', $store)
            ->assertJson([
                'message' => 'Post Succesfully created'
            ])
            ->assertStatus(201);
    }

    public function test_api_store_post_without_image()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );

        $store = [
            'title' => $this->faker->title(),
            'content' => $this->faker->sentence(),
            'user_id' => 1,
            'category_id' => 2
        ];

        $this->postJson('api/v1/posts', $store)
            ->assertJson([
                'message' => 'Post Succesfully created'
            ])
            ->assertStatus(201);
    }

    public function test_api_update_post()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );

        $post = Article::factory()->create();

        $edit = [
            'title' => $this->faker->title(),
            'content' => $this->faker->paragraph(),
            'image' => 'placeholder.png',
            'user_id' => 1,
            'category_id' => 2
        ];

        $this->putJson('api/v1/posts/'.$post->id, $edit)
            ->assertJson([
                'message' => 'Posts successfully updated'
            ])
            ->assertStatus(200);
    }

    public function test_api_update_post_without_image()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );

        $post = Article::factory()->create();

        $edit = [
            'title' => $this->faker->title(),
            'content' => $this->faker->paragraph(),
            'image' => 'placeholder.png',
            'user_id' => 1,
            'category_id' => 2
        ];

        $this->putJson('api/v1/posts/'.$post->id, $edit)
            ->assertJson([
                'message' => 'Posts successfully updated'
            ])
            ->assertStatus(200);
    }

    public function test_api_delete_post()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );

        $article = Article::factory()->create();

        $response = $this->delete('/api/v1/posts/'.$article->id);

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Post successfully deleted'
        ]);
    }
}
