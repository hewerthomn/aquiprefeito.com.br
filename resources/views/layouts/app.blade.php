<!DOCTYPE html>
<html lang="pt-BR" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AquiPrefeito!</title>

	<link href="{{ asset('/build/css/app.min.css') }}" rel="stylesheet">
</head>
<body>

	@yield('content')

	<!-- Scripts -->
	<script src="{{ asset('/build/js/app.min.js') }}"></script>
</body>
</html>