@extends('layouts.admin')

@section('content')

<h1>{{ $title }}</h1>
<hr>
<br>

<div class="row">
	{{-- Issues  --}}
	<div class="col-md-4">
		<div class="panel panel-default text-center">
			<a class="panel-body" href="/admin/issue">
				<h1 class="text-warning"><i class="icon-aquiprefeito fa-4x"></i></h1>
				<h2>Problemas recebidos</h2>
			</a>
		</div>
	</div>
	{{-- /Issues  --}}

</div>

@stop
