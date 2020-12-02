<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name ="Terror";
        $category->description = "Libros que dan mucho miedo";
        $category->save();

        $category = new Category();
        $category->name ="Romance";
        $category->description = "Libros que te hacen suspirar";
        $category->save();

        $category = new Category();
        $category->name ="Aventura";
        $category->description = "Libros que te emocionan";
        $category->save();

        $category = new Category();
        $category->name ="Suspenso";
        $category->description = "Libros que te quiebran la cabeza";
        $category->save();

        $category = new Category();
        $category->name ="Ciencia ficción";
        $category->description = "Libros con waifus";
        $category->save();
    }
}
