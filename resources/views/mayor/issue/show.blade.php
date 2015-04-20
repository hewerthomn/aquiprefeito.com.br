@extends('layouts.mayor')

@section('content')
<h1>
	<i class="fa fa-info-circle text-muted"></i>
	{{ $title }}
	<small class="pull-right">#{{ $issue->id }}</small>
</h1>
<hr>

<div class="row">
	<div class="col-sm-3">

		<div class="panel panel-default">
			<h3 class="panel-heading text-primary">
				{{ $issue->category->name }}
				<img src="/{{ $issue->category->icon }}" class="pull-right">
			</h3>
			<div class="panel-body">
				<div class="media">
				  <div class="media-left">
				    <a href="#">
							<img class="media-object" src="https://graph.facebook.com/{{ $issue->facebook_id }}/picture" alt="" class="img-circle">
				    </a>
				  </div>
				  <div class="media-body">
				    <h4 class="media-heading text-primary">
				    	{{ $issue->username }}
							<small class="pull-right" title="{{ $issue->created_at->format('d/M/Y') }}">{{ $issue->created_at->diffForHumans() }}</small>
				    </h4>
				    <p>
							{{ $issue->comment }}
				    </p>
				  </div>
				</div>

				<hr>
				<p class="text-muted">
					<b>{{ $issue->likes()->count() }}</b> curtidas
					<b>{{ $issue->comments()->count() }}</b> comentários
					<span class="pull-right">
						{{ $issue->status->name }}
					</span>
				</p>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-body">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDoneIssue">
				  Marcar como Resolvido
				</button>
				<a href="" class="btn btn-link pull-right">Conteúdo impróprio</a>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				Comentários
			</div>

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
		</div>

	</div>
	<div class="col-sm-5 text-center">
		<img src="/img/issues/{{ $issue->image_path }}" class="">
	</div>

	<div class="col-sm-4">
		<a href="{{ $issue->link('maps') }}" target="_blank">
			<img src="{{ $issue->map_view() }}" alt="" class="img-thumbnail">
		</a>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDoneIssue" tabindex="-1" role="dialog" aria-labelledby="modalDoneIssueLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalDoneIssueLabel">Marcar problema como resolvido</h4>
      </div>
      <div class="modal-body">

      	<div class="form-group">
    			<label>Selecione a foto do problema</label>
        	<input name="photo" type="file" class="form-control">
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left">Enviar foto</button>
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

@stop
