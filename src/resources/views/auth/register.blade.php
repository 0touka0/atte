@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="register-form">
	<h2 class="register-form__heading">会員登録</h2>
	<div class="register-form__inner">
		<form class="register-form__form" action="/register" method="post">
			@csrf
			<div class="register-form__group">
				<input type="text" class="register-form__input" name="name" placeholder="名前">
				<p class="error-message">
					@error('name')
						{{ $message }}
					@enderror
				</p>
			</div>
			<div class="register-form__group">
				<input type="email" class="register-form__input" name="email" placeholder="メールアドレス">
				<p class="error-message">
					@error('email')
						{{ $message }}
					@enderror
				</p>
			</div>
			<div class="register-form__group">
				<input type="password" class="register-form__input" name="password" placeholder="パスワード">
				<p class="error-message">
					@error('password')
						{{ $message }}
					@enderror
				</p>
			</div>
			<div class="register-form__group">
				<input type="password" class="register-form__input" name="password_confirmation" placeholder="確認用パスワード">
			</div>
			<input class="register-form__btn btn" type="submit" value="会員登録">
		</form>
	</div>
</div>
<div  class="form__link">
<p>アカウントをお持ちの方はこちらから</p>
<a href="/login">ログイン</a>
</div>
@endsection