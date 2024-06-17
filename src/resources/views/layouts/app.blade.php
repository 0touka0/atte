<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Atte</title>
	<link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
	<link rel="stylesheet" href="{{ asset('css/common.css') }}">
	@yield('css')
</head>
<body>
	<div class="app">
		<header class="header">
			<h1 class="header__heading">Atte</h1>
			@yield('nav')
		</header>

		<div class="content">
			@yield('content')
		</div>

		<footer class="footer">
			<p>Atte, inc.</p>
		</footer>
	</div>
</body>

</html>