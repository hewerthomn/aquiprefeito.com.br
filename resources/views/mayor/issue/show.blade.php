@extends('layouts.mayor')

@section('content')
<h1>
	<img src="/{{ $issue->category->icon }}">
	{{ $issue->category->name }}
	<small>#{{ $issue->id }}</small>
</h1>
<hr>

<div class="row">
	<div class="col-md-4">

		<div class="panel panel-default">
			<div class="panel-body">
				<div class="media">
				  <div class="media-left">
				    <a href="#">
							<img class="img-circle media-object" src="https://graph.facebook.com/{{ $issue->facebook_id }}/picture" alt="" class="img-circle">
				    </a>
				  </div>
				  <div class="media-body">
				    <h4 class="media-heading text-primary">
				    	{{ $issue->username }}
				    	<br>
							<small title="{{ $issue->created_at->format('d/M/Y') }}">{{ $issue->created_at->diffForHumans() }}</small>
				    </h4>
				  </div>
				</div>
		    <p>
					{{ $issue->comment }}
		    </p>
				<hr>
				<p>
					<span class="text-muted">
						{{ $issue->status->name }}
					</span>
					<button type="button" class="btn btn-xs btn-success pull-right" data-toggle="modal" data-target="#modalMap">
					  <i class="icon-globe"></i> Mapa
					</button>
				</p>
			</div>
		</div>

		{{-- Comments --}}
		<ul class="list-group">
			@foreach($issue->comments as $comment)
				<li class="list-group-item">
					<div class="media">
					  <div class="media-left">
					    <a href="#">
								<img class="media-object" src="https://graph.facebook.com/{{ $comment->facebook_id }}/picture" alt="" class="img-circle">
					    </a>
					  </div>

					  <div class="media-body">
					    <h4 class="media-heading text-primary">
					    	{{ $comment->username }}
								<small class="pull-right" title="{{ $comment->created_at->format('d/M/Y') }}">{{ $comment->created_at->diffForHumans() }}</small>
					    </h4>
					    <p>
								{{ $comment->comment }}
					    </p>
					  </div>
					</div>
				</li>
			@endforeach
		</ul>
		{{--/Comments --}}
	</div>

	<div class="col-md-8">
		{{-- Photo --}}
		<small>Foto do problema</small>
		<img src="/img/issues/{{ $issue->image_path }}" class="img-thumbnail">
		{{--/Photo --}}
	</div>
</div>

<!-- Modal Map -->
<div class="modal fade" id="modalMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
        	{{ $issue->category->name }}
        	<small>#{{ $issue->id }}</small>
        </h4>
      </div>
      <div class="modal-body">
        <a href="{{ $issue->link('maps') }}" target="_blank">
					<img src="{{ $issue->map_view() }}" alt="" class="img-thumbnail">
				</a>
      </div>
    </div>
  </div>
</div>
<!--/Modal Map -->

@stop
