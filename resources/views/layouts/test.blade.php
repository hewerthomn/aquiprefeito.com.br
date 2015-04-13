<!DOCTYPE html>
<html lang="pt-BR" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Testes - AquiPrefeito!</title>

	<link href="{{ asset('/packages/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>

	@yield('content')

	<!-- Scripts -->
	<script src="{{ asset('/packages/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ asset('/packages/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>
