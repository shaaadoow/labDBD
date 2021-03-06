<?php

namespace Database\Factories;

use App\Models\Commentary;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commentary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contenido' => $this->faker->text(200), 
            'id_usuario' => User::all()->random()->id,
            'id_video' => Video::all()->random()->id
        ];
    }
}
