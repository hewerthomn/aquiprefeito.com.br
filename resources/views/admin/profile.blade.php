@extends('layouts.admin')

@section('content')
<div class="container">


	<div class="col-md-9">
		<h2>{{ $title }}</h2>
		<hr>

		{!! Form::open(['url' => '/admin/profile']) !!}
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<label for="name">Nome</label>
					{!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					{!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
				</div>

				<button type="submit" class="btn btn-block btn-primary">Salvar</button>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label for="created_at">Criado em</label>
					{!! Form::text('created_at', $user->created_at, ['class' => 'form-control', 'disabled']) !!}
				</div>
				<div class="form-group">
					<label for="updated_at">Última atulização</label>
					{!! Form::text('updated_at', $user->updated_at, ['class' => 'form-control', 'disabled']) !!}
				</div>
			</div>
			</div>
		{!! Form::close() !!}
	</div>

	<div class="col-md-3">
		<fieldset class="well well-sm">
			<legend>Trocar senha</legend>

			{!! Form::open(['url' => '/admin/changePassword']) !!}

				<div class="form-group">
					<label for="password">Senha atual</label>
					{!! Form::password('password', ['class' => 'form-control']) !!}
				</div>

				<div class="form-group">
					<label for="newPassword">Nova senha</label>
					{!! Form::password('newPassword', ['class' => 'form-control']) !!}
				</div>

				<div class="form-group">
					<label for="confirmPassword">Confirmação da senha</label>
					{!! Form::password('confirmPassword', ['class' => 'form-control']) !!}
				</div>

				<button type="submit" class="btn btn-block btn-warning">Trocar senha</button>

			{!! Form::close() !!}
		</fieldset>
	</div>
</div>
@endsection

