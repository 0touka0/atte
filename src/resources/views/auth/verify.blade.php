@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<h1>メールアドレスの確認が必要です</h1>
<p>ご登録ありがとうございます！登録を完了するために、メールに記載されているリンクをクリックしてください。</p>
@if (session('status') == 'verification-link-sent')
	<p>新しい確認リンクがメールアドレスに送信されました。</p>
@endif

<form method="POST" action="{{ route('verification.send') }}">
	@csrf
	<button type="submit">確認メールを再送信</button>
</form>
@endsection