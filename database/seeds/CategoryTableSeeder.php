<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder {

    public function run()
    {
        DB::table('categories')->delete();

        $categories = [
					['id' => 1, 'name' => 'Pavimentação', 'icon' => 'img/categories/1.png'],
					['id' => 2, 'name' => 'Iluminação Pública', 'icon' => 'img/categories/2.png'],
					['id' => 3, 'name' => 'Queimada Urbana', 'icon' => 'img/categories/3.png'],
					['id' => 4, 'name' => 'Limpeza Urbana', 'icon' => 'img/categories/4.png'],
					['id' => 5, 'name' => 'Transporte Público', 'icon' => 'img/categories/5.png'],
					['id' => 6, 'name' => 'Sinalização de Trânsito', 'icon' => 'img/categories/6.png'],
        ];

        Category::insert($categories);
    }

}
