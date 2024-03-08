<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->count(10)->create()->each(function ($post) {
            $post->categories()->save(Category::inRandomOrder()->first());
            $post->tags()->save(Tag::inRandomOrder()->first());
            $post->save();
        });
    }
}
