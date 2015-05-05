@extends('layouts.mayor')

@section('content')

<div class="row">
	<div class="col-md-6">
		<h1>{{ Session::has('city') ? Session::get('city')->name : 'Selecione a cidade' }}</h1>
	</div>
	<div class="col-md-6">
		<div class="pull-right">{!! $issues_open->render() !!}</div>
	</div>
</div>

<hr>

<div class="row">
	@foreach($issues_open as $issue)
		<div class="col-sm-6 col-md-4 col-lg-4">
			<div class="thumbnail">
				<a href="{{ url('/prefeitura/issue/show', $issue->id) }}">
					<img src="/img/issues/lg/{{ $issue->image_path }}">
				</a>
				<div class="caption">
					<h3 class="text-primary">
						{{ $issue->category->name }}
						<small>#{{ $issue->id }}</small>
					</h3>
					<p>
						<span>
							<span title="$issue->created_at->format('d/m/Y')">
								{{ $issue->created_at->diffForHumans() }}
							</span>
						</span>
					</p>
				</div>
			</div>
		</div>
	@endforeach
</div>

<div class="text-center">{!! $issues_open->render() !!}</div>

@stop
