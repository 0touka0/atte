@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login-form">
	<h2 class="login-form__heading">ログイン</h2>
	<div class="login-form__inner">
		<form class="login-form__form" action="/login" method="post">
			@csrf
			<div class="login-form__group">
				<input type="email" class="login-form__input" name="email" placeholder="メールアドレス">
				<p class="error-message">
					@error('email')
							{{ $message }}
					@enderror
				</p>
			</div>
			<div class="login-form__group">
				<input type="password" class="login-form__input" name="password" placeholder="パスワード">
				<p class="error-message">
					@error('password')
							{{ $message }}
					@enderror
				</p>
			</div>
			<input class="login-form__btn btn" type="submit" value="ログイン">
		</form>
	</div>
</div>
<div  class="form__link">
	<p>アカウントをお持ちでない方はこちらから</p>
	<a href="/register">会員登録</a>
</div>
@endsection