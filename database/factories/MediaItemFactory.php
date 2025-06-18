<?php

namespace Database\Factories;

use App\Models\MediaItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MediaItem>
 */
class MediaItemFactory extends Factory
{
    protected $model = MediaItem::class;
   
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isFolder = $this->faker->boolean(30); 
        $parentId = MediaItem::where('type', 'folder')->inRandomOrder()->value('id');
        return [
            'name' => $isFolder ? $this->faker->unique()->word() : $this->faker->unique()->lexify('file_????'),
            'type' => $isFolder ? 'folder' : 'file',
            'parent_id' => $this->faker->randomElement([$parentId, null]),
            'path' => $isFolder ? null : 'uploads/' . $this->faker->uuid . '.jpg',
            'mime_type' => $isFolder ? null : 'image/jpeg',
            'size' => $isFolder ? 0 : $this->faker->numberBetween(1000, 5000000), 
            'user_id' => User::factory(),
        ];
    }
}
