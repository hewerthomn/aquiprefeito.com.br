@extends('layouts.admin')

@section('content')


<div class="row">
	<div class="col-md-8">
		<h2>
			{{ $title }}
			<small>({{ $count }})</small>
		</h2>
	</div>
	<div class="col-md-4">
		{!! Form::open(['method' => 'get']) !!}
		<!--div class="form-group">
			<div class="input-group">
				{!! Form::text('q', Input::get('q'), ['autofocus', 'class' => 'form-control', 'placeholder' => 'Digite para procurar']) !!}
				<div class="input-group-btn">
					<button type="submit" class="btn btn-default"><i class="icon-search"></i></button>
				</div>
			</div>
		</div-->
		{!! Form::close() !!}
	</div>
</div>
<hr>

<div class="row">
	@foreach($issues as $issue)
		<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
			<div class="thumbnail">
				<a href="/admin/issue/{{ $issue->id }}">
					<img src="/img/issues/lg/{{ $issue->image_path }}">
				</a>
				<div class="caption">
					<h3 class="text-primary">
						{{ $issue->category->name }}
						<small>#{{ $issue->id }}</small>
					</h3>
					<p>
						<span>{{ $issue->city->name }}</span>
						<span class="pull-right">
							<span title="{{ $issue->created_at->format('d/m/Y') }}">
								{{ $issue->created_at->diffForHumans() }}
							</span>
						</span>
					</p>
				</div>
			</div>
		</div>
	@endforeach
</div>

<div class="text-center">{!! $issues->render() !!}</div>
@stop
