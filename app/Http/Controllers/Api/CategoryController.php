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

	public function index()
	{
		$categories = $this->category->all();

		return response()->json($categories);
	}

	public function show($id)
	{
		$category = $this->category->find($id);

		return response()->json($category);
	}
}
