<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
/**
* Category Controller
*/
class CategoryController extends Controller
{
	public function __construct(Category $category)
	{
		$this->category = $category;
	}

	public function getIndex()
	{
		$categories = $this->category->all();

		return response()->json($categories);
	}
}