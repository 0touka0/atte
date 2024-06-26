@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('nav')
<nav>
	<ul class="header__nav">
		<li class="nav__list">
			<a href="/" class="header__link">ホーム</a>
		</li>
		<li class="nav__list">
			<a href="/attendance" class="header__link">日付一覧</a>
		</li>
		<li class="nav__list">
			<form action="/logout" method="post">
				@csrf
				<input type="submit" value="ログアウト">
			</form>
		</li>
	</ul>
</nav>
@endsection

@section('content')
<div class="stamp-form">
	<h2 class="stamp-form__heading">{{ $user->name }}さんお疲れ様です！</h2>
	<div class="stamp-form__inner">
		<form class="stamp-form__form" action="{{ route('work.start') }}" method="POST">
			@csrf
			<button type="submit" class="stamp-form__btn" {{ $isWorking ? 'disabled' : '' }}>勤務開始</button>
		</form>
		<form class="stamp-form__form" action="{{ route('work.end') }}" method="POST">
			@csrf
			<button type="submit" class="stamp-form__btn" {{ !$isWorking || $isOnBreak ? 'disabled' : '' }}>勤務終了</button>
    </form>
    <form class="stamp-form__form" action="{{ route('break.start') }}" method="POST">
			@csrf
			<button type="submit" class="stamp-form__btn" {{ $isOnBreak || !$isWorking ? 'disabled' : '' }}>休憩開始</button>
    </form>
    <form class="stamp-form__form" action="{{ route('break.end') }}" method="POST">
			@csrf
			<button type="submit" class="stamp-form__btn" {{ !$isOnBreak ? 'disabled' : '' }}>休憩終了</button>
    </form>
	</div>
</div>
@endsection