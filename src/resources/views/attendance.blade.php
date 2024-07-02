@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
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
<div class="daily">
	<a class="daily__icon daily__icon--left" href="{{ route('date.show', ['date' => $previousDate]) }}"><</a>
	<span>{{ $today }}</span>
	@if ($today == \Carbon\Carbon::today()->toDateString())
		<span class="daily__icon daily__icon--right-disabled">></span>
	@else
		<a class="daily__icon daily__icon--right" href="{{ route('date.show', ['date' => $nextDate]) }}">></a>
	@endif
</div>
<table class="work-time__table">
	<tr class="work-time__row">
		<th class="work-time__header wide">名前</th>
		<th class="work-time__header">勤務開始</th>
		<th class="work-time__header">勤務終了</th>
		<th class="work-time__header">休憩時間</th>
		<th class="work-time__header">勤務時間</th>
	</tr>
	<!-- データの繰り返し表示 -->
	@foreach ($works as $work)
	<tr class="work-time__row">
		<td class="work-time__data">{{ $work->user->name }}</td>
		<td class="work-time__data">{{ $work->startFormatted }}</td>
		<td class="work-time__data">{{ $work->endFormatted }}</td>
		<td class="work-time__data">{{ $work->totalBreakTimeFormatted }}</td>
		<td class="work-time__data">{{ $work->actualWorkTimeFormatted }}</td>
	</tr>
	@endforeach
</table>

{{ $works->links() }}

@endsection