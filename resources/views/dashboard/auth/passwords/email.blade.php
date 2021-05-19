@extends('dashboard.auth.auth')
@section('content')
    <form method="POST" action="{{ route("dashboard.password.email") }}" class="needs-validation" novalidate>
        @csrf
        @if(session()->has('error'))
            <div class="alert alert-danger invalid-feedback d-block">{{ session()->get('error') }}</div>
        @endif
        @if(session()->has('message_sent'))
            <div class="alert alert-success invalid-feedback d-block">{{ session()->get('message_sent') }}</div>
        @else
        <label for="email" class="mb-1">{{ trans('global.email') }}:</label>
        <input type="text" class="form-control mb-1" required="true" id="email" name="email" placeholder="{{ trans('global.username') }}" value="{{ old('email') }}" autofocus>
        @if ($errors->has('email'))
            <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
        @endif
        <div class="invalid-feedback">{{ trans('global.required_username') }}</div>
        <div class="row">
            <div class="mt-2">
                <button type="submit" class="btn btn-primary w-100">{{trans('global.reset_password_button')}}</button>
            </div>
        </div>
        @endif
    </form>
@endsection