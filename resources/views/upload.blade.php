@extends('layouts.test')

@section('content')

<div class="container-fluid">
	<form method="POST" action="/api/upload" enctype="multipart/form-data">

		<fieldset>
			<legend>Test de Upload de Imagem</legend>

			<div class="form-group">
				<label for="file">Imagem</label>
				<input name="file" type="file" class="form-control">
				<?php echo $errors->first('file', '<span class="text-danger">:message</span>'); ?>
			</div>

			<div class="form-group">
				<label for="city">City</label>
				<input type="text" name="city" class="form-control" value="Porto Velho">
				<?php echo $errors->first('city', '<span class="text-danger">:message</span>'); ?>
			</div>

			<div class="form-group">
				<label for="comment">Comment</label>
				<input type="text" name="comment" class="form-control" value="Problema aqui!">
				<?php echo $errors->first('comment', '<span class="text-danger">:message</span>'); ?>
			</div>

			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" class="form-control" value="Everton Inocencio">
				<?php echo $errors->first('username', '<span class="text-danger">:message</span>'); ?>
			</div>

			<div class="form-group">
				<label for="category_id">Category</label>
				<input type="text" name="category_id" class="form-control" value="1">
				<?php echo $errors->first('category_id', '<span class="text-danger">:message</span>'); ?>
			</div>

			<div class="form-group">
				<label for="lonlat">LonLat</label>
				<input type="text" name="lonlat" class="form-control" value="-63.87041160407719 -8.747961070590879">
				<?php echo $errors->first('lonlat', '<span class="text-danger">:message</span>'); ?>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">ENVIAR</button>
			</div>

		</fieldset>
	</form>
</div>


@stop
