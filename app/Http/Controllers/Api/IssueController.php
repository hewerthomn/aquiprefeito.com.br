<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIssuePostRequest;
use App\Http\Requests\StoreCommentPostRequest;
use App\City;
use App\Issue;
use App\Like;
use App\Comment;
use App\Status;
use DB, Input;

/**
* Issue Controller
*/
class IssueController extends Controller
{
	public function __construct(City $city, Issue $issue, Like $like, Comment $comment)
	{
		$this->city = $city;
		$this->issue = $issue;
		$this->like = $like;
		$this->comment = $comment;
	}

	public function index()
	{
		$city_name = Input::get('city_name');

		$issues = DB::select(
			"SELECT
				i.id,
				i.category_id,
				i.status_id,
				i.image_path AS photo,
				i.username,
				i.facebook_id,
				i.comment,
				EXTRACT(EPOCH FROM i.created_at) AS created_at,
				c.name AS category_name,
				c.icon AS category_icon,
				s.icon AS status_icon,
				ST_X(i.geom) AS lon,
				ST_Y(i.geom) AS lat,
				(SELECT COUNT(id) FROM likes WHERE likes.issue_id = i.id) AS likes,
				(SELECT COUNT(id) FROM comments WHERE comments.issue_id = i.id) AS comments
			FROM
				issues i, categories c, cities, status s
			where
				i.category_id = c.id
				AND i.city_id = cities.id
				AND i.status_id = s.id
				AND cities.name = '{$city_name}'
			");

		return response()->json($issues);
	}

	public function show($id)
	{
		$issue = DB::select(
			"SELECT
				i.id,
				i.category_id,
				i.status_id,
				i.image_path AS photo,
				i.username,
				i.facebook_id,
				i.comment,
				EXTRACT(EPOCH FROM i.created_at) AS created_at,
				c.name AS category_name,
				c.icon AS category_icon,
				s.name AS status_name,
				s.icon AS status_icon,
				ST_X(i.geom) AS lon,
				ST_Y(i.geom) AS lat,
				(SELECT COUNT(id) FROM likes WHERE likes.issue_id = i.id) AS likes,
				(SELECT COUNT(id) FROM comments WHERE comments.issue_id = i.id) AS comments
			FROM
				issues i, categories c, status s
			WHERE
				i.category_id = c.id
				AND i.status_id = s.id
				AND i.id = {$id}
			");

		return response()->json(isset($issue[0]) ? $issue[0] : null);
	}

	public function map()
	{
		$city_name = Input::get('city_name');

		$points = $this->issue->join('categories', 'issues.category_id', '=', 'categories.id')
													->join('cities', 'issues.city_id', '=', 'cities.id')
													->where('cities.name', '=', $city_name)
													->select(
														'issues.id',
														'categories.icon AS icon',
														DB::raw('ST_X(issues.geom) AS lon'),
														DB::raw('ST_Y(issues.geom) AS lat')
													)
													->get();

		return response()->json($points);
	}

	public function upload(StoreIssuePostRequest $request)
	{
		try {
			$city = $this->city->firstOrCreate(['name' => Input::get('city')]);

			$issue = new Issue;
			$issue->city_id 		= $city->id;
			$issue->email 			= Input::get('email');
			$issue->comment 		= Input::get('comment');
			$issue->username 		= Input::get('username');
			$issue->status_id 	= Status::$OPEN;
			$issue->facebook_id = Input::get('facebook_id');
			$issue->category_id = Input::get('category_id');

			$lonlat = Input::get('lonlat');
			$issue->geom = DB::raw("ST_GeomFromText('POINT({$lonlat})', 4326)");

			$issue->image_path = $issue->upload(Input::file('file'));

			return $issue->save() ?  'Parabéns! Problema reportado.' : 'Ops, saiu algo errado... x_x';
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function checkLike($id)
	{
		$count = $this->like->where('facebook_id', '=', Input::get('facebook_id'))
												->where('issue_id', '=', $id)
												->count();

		return ($count > 0) ? 1 : 0;
	}

	public function saveLike($id)
	{
		$like = $this->like->firstOrNew([
			'issue_id' => $id,
			'facebook_id' => Input::get('facebook_id')
		]);

		if($like->id > 0)
		{
			return $like->delete() ? 0 : 1;
		}

		return $like->save() ? 1 : 0;
	}

	public function getComments($id)
	{
		$comments = DB::select("
			SELECT
				id,
				comment,
				facebook_id,
				username,
				EXTRACT(EPOCH FROM created_at) AS created_at
			FROM comments
			WHERE issue_id = {$id};
		");

		return $comments;
	}

	public function saveComment(StoreCommentPostRequest $request)
	{
		try {
			$comment = new Comment;
			$comment->comment = Input::get('comment');
			$comment->username = Input::get('username');
			$comment->issue_id = Input::get('issue_id');
			$comment->facebook_id = Input::get('facebook_id');

			return $comment->save() ? 'Comentário enviado com sucesso' : 'Ops, saiu algo errado... x_x';
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
}
