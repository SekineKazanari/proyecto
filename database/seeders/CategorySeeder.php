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
        $category->name = "Terror";
        $category->description = "Matemáticas, en pocas palabras. ";
        $category->save();

        $category = new Category();
        $category->name = "Romance";
        $category->description = "Muchos muchos besos.";
        $category->save();

        $category = new Category();
        $category->name = "Ciencia ficción";
        $category->description = "Aquí hay waifus. ";
        $category->save();
    }
}
