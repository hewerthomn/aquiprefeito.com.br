<?php namespace App\Http\Controllers;

use App\Issue;

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
			$issue = $this->issue->find($id);
			if($issue)
			{
				$title = "Problema de {$issue->category->name} em {$issue->city->name} - #{$id}";

				$v['title'] = "AquiPrefeito! - {$title}";
				$v['facebookMeta'] = [
					'title' => $title,
					'image' => "www.aquiprefeito.com.br/img/issues/big/{$issue->image_path}"
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
