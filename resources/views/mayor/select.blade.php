@extends('layouts.mayor')

@section('content')

<h1>{{ $title }}</h1>
<hr>

<div class="list-group">
@foreach($cities as $city)
	<a href="/prefeitura/select/{{ $city->id }}" class="list-group-item col-md-3">
		<h1>
			{{ $city->name }}
			<small>#{{ $city->id }}</small>
		</h1>
	</a>
@endforeach
</div>

@stop
