@extends('layouts.login')

@section('content')
	<div class="container container-login animated fadeIn" style="padding: 30px 25px !important;">
		<img src="{{ asset('assets/img/login_logo1.png') }}" class="m-b-30" width="350">
		<div class="login-form">
			<form method="POST" action="{{ route('login') }}">
        	@csrf
				<div class="form-group form-floating-label">
					<input id="email" name="email" type="email" type="text" class="form-control input-border-bottom @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="off" autofocus>
					<label for="username" class="placeholder">Username</label>
					@if ($errors->has('email'))
                        <small id="email" class="form-text text-muted">
                            <strong>{{ $errors->first('email') }}</strong>
                        </small>
                    @endif
				</div>
					

				<div class="form-group form-floating-label">
					<input id="password" name="password" type="password" class="form-control input-border-bottom @error('password') is-invalid @enderror" required autocomplete="current-password">
					<label for="password" class="placeholder">Password</label>
					<div class="show-password">
						<i class="icon-eye"></i>
					</div>
					@if ($errors->has('password'))
                        <small id="password" class="form-text text-muted">
                            <strong>{{ $errors->first('password') }}</strong>
                        </small>
                    @endif
				</div>
					

				<div class="form-action mb-3">
					<button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
				</div>

				<div class="login-account">
					<a href="{{ route('password.request') }}" id="show-signup" class="link"><span class="msg">Anda Lupa Password ?</span></a>
				</div>
			</form>
		</div>
	</div>
@endsection