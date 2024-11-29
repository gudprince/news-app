<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{   
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        $slug = Str::slug($title, '-');

        return [
            'title' => $title,
            'description' => $this->faker->paragraph,
            'author' => $this->faker->name,
            'source_name' => $this->faker->company,
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'category_id' => Category::factory(), // Generate a new category using the Category factory
            'article_url' => $this->faker->url,
            'slug' => $slug,
            'image_url' => $this->faker->imageUrl(640, 480, 'news', true),
        ];
    }
}
