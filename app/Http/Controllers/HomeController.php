<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}

	/**
	 * Show the home page.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home.app');
	}
}
