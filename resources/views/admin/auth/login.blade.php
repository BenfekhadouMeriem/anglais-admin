@extends('admin.layouts.plain')

@section('content')
<h1>E-learning System</h1>
<p class="account-subtitle">Login Panel</p>
@if (session('login_error'))
<x-alerts.danger :error="session('login_error')" />
@endif
<!-- Form -->
<form action="{{route('login')}}" method="post">
	@csrf
	<div class="form-group">
		<input class="form-control" name="email" type="text" placeholder="Email">
	</div>
	<div class="form-group">
		<input class="form-control" name="password" type="password" placeholder="Password">
	</div>
	<div class="form-group">
		<button class="btn btn-block" style="background-color: #FFA3B5; border-color: #FFA3B5; color: white;"
			onmouseover="this.style.backgroundColor='#FF8FA3'"
			onmouseout="this.style.backgroundColor='#FFA3B5'"
			type="submit">
			Login
		</button>
	</div>
</form>
<!-- /Form -->

<!-- Visit codeastro.com for more projects -->

<div class="text-center forgotpass"><a href="{{route('password.request')}}">Forgot Password?</a></div>
<div class="text-center dont-have">Don’t have an account? <a href="{{route('register')}}">Register</a></div>
@endsection