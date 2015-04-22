<?php namespace App\Http\Controllers;

use App\Issue;
use Request;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Issue $issue)
	{
		$this->issue = $issue;
	}

	/**
	 * Show the home page.
	 *
	 * @return Response
	 */
	public function index($id = null)
	{
		$v['title'] = 'AquiPrefeito!';

		if($id != null)
		{
			$urlSite = Request::root();

			$issue = $this->issue->find($id);
			if($issue)
			{
				$v['title'] = "AquiPrefeito! - #{$id} {$issue->category->name}";
				$v['facebookMeta'] = [
					'title' => 'Problema de ' . $issue->category->name,
					'image' => "{$urlSite}/img/issues/big/{$issue->image_path}"
				];
			}
		}

		return view('home.app', $v);
	}

	public function issue($id)
	{
		return redirect()->to("/{$id}#/issue-{$id}");
	}
}
