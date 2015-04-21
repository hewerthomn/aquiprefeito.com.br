@extends('layouts.mayor')

@section('content')

<h1>{{ $city->name }}</h1>
<hr>

<div class="row">
	<div class="col-md-6">
		<fieldset>
			<legend>Abertos</legend>

			<div class="row">
				@foreach($issues_open as $issue)
					<div class="col-sm-4 col-md-4 col-lg-4">
						<div class="thumbnail">
							<a href="{{ route('prefeitura.issue.show', $issue->id) }}">
								<img src="/img/issues/lg/{{ $issue->image_path }}" class="img-thumbnail">
							</a>
							<div class="caption">
								<h3 class="text-primary">{{ $issue->category->name }}</h3>
								<p>
									{{ $issue->created_at->format('d/m/Y') }}
									<span class="pull-right">
										{{ $issue->created_at->diffForHumans() }}
									</span>
								</p>

								<a href="{{ route('prefeitura.issue.show', $issue->id) }}" class="btn btn-block btn-default">Mais informações</a>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</fieldset>
	</div>
	<div class="col-md-6"></div>
</div>

@stop
