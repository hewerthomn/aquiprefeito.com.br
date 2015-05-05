@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-9">
		<h2>{{ $title }}</h2>
		<hr>

		{!! Form::open(['url' => '/admin/profile']) !!}
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<label for="name">Nome</label>
					{!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
					{!! $errors->first('name', '<span class="text-danger">:message</span>') !!}
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					{!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
					{!! $errors->first('email', '<span class="text-danger">:message</span>') !!}
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
			<legend>Alterar senha</legend>

			{!! Form::open(['url' => '/admin/changePassword']) !!}

				<div class="form-group">
					<label for="password">Senha atual</label>
					{!! Form::password('password', ['class' => 'form-control']) !!}
					{!! $errors->first('password', '<span class="text-danger">:message</span>') !!}
				</div>

				<div class="form-group">
					<label for="new_password">Nova senha</label>
					{!! Form::password('new_password', ['class' => 'form-control']) !!}
					{!! $errors->first('new_password', '<span class="text-danger">:message</span>') !!}
				</div>

				<div class="form-group">
					<label for="new_password_confirmation">Confirmação da senha</label>
					{!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
					{!! $errors->first('new_password_confirmation', '<span class="text-danger">:message</span>') !!}
				</div>

				<button type="submit" class="btn btn-block btn-warning">Trocar senha</button>

			{!! Form::close() !!}
		</fieldset>
	</div>
</div>
@endsection

