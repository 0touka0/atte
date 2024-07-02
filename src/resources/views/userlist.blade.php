@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/userlist.css') }}">
@endsection

@section('nav')
<nav>
	<ul class="header__nav">
		<li class="nav__list">
			<a href="/" class="header__link">ホーム</a>
		</li>
		<li class="nav__list">
			<a href="{{ route('user.list') }}" class="header__link">ユーザー一覧</a>
		</li>
		<li class="nav__list">
			<a href="{{ route('date.show') }}" class="header__link">日付一覧</a>
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
<table class="user-list__table">
	<tr class="user-list__row">
		<th class="user-list__header wide">id</th>
		<th class="user-list__header">名前</th>
		<th class="user-list__header">メールアドレス</th>
		<th class="user-list__header">ステータス</th>
		<th class="user-list__header"></th>
	</tr>
	@foreach ($users as $user)
	<tr class="user-list__row">
		<td class="user-list__data user-list__data--id">{{ $user->id }}</td>
		<td class="user-list__data">{{ $user->name }}</td>
		<td class="user-list__data">{{ $user->email }}</td>
		<td class="user-list__data">{{ $statuses[$user->id] }}</td>
		<td class="user-list__data user-list__data--btn">
			<form action="{{ route('user.data') }}" method="get">
				<input type="hidden" name="id" value="{{ $user->id }}">
				<button type="submit" class="user-btn">勤怠表を見る</button>
			</form>
		</td>
	</tr>
	@endforeach
</table>

{{ $users->links() }}

@endsection