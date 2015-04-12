<?php 

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder {

    public function run()
    {
        DB::table('categories')->delete();

        $categories = [
					['id' => 1, 'name' => 'Pavimentação', 'icon' => 'img/categories/1.png', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
					['id' => 2, 'name' => 'Iluminação Pública', 'icon' => 'img/categories/2.png', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
					['id' => 3, 'name' => 'Queimada Urbana', 'icon' => 'img/categories/3.png', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
					['id' => 4, 'name' => 'Limpeza Urbana', 'icon' => 'img/categories/4.png', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
					['id' => 5, 'name' => 'Transporte Público', 'icon' => 'img/categories/5.png', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
					['id' => 6, 'name' => 'Sinalização de Trânsito', 'icon' => 'img/categories/6.png', 'created_at' => new DateTime(), 'updated_at' => new DateTime],
        ];

        Category::insert($categories);
    }

}