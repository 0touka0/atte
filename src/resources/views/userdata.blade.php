@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/userdata.css') }}">
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
<div class="user-table__header">
	<h2 class="user-name">{{ $user->name }}</h2>
	<div class="return-btn">
		<a href="{{ route('user.list', ['page' => session('userlist_page', 1)]) }}" class="return-btn__link">戻るボタン</a>
	</div>
</div>
<table class="user-list__table">
	<tr class="user-list__row">
		<th class="user-list__header wide">年月日</th>
		<th class="user-list__header">勤務開始</th>
		<th class="user-list__header">勤務終了</th>
		<th class="user-list__header">休憩時間</th>
		<th class="user-list__header">勤務時間</th>
	</tr>
	@foreach($works as $work)
	<tr class="user-list__row">
		<td class="user-list__data">{{ $work->startDateFormatted }}</td>
		<td class="user-list__data">{{ $work->startFormatted }}</td>
		<td class="user-list__data">{{ $work->endFormatted }}</td>
		<td class="user-list__data">{{ $work->totalBreakTimeFormatted }}</td>
		<td class="user-list__data">{{ $work->actualWorkTimeFormatted }}</td>
	</tr>
@endforeach
</table>

{{ $works->appends(['id' => $user->id])->links() }}

@endsection