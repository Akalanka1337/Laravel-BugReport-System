<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Install</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        *:focus, *:active, *:focus-within {
            outline: unset !important;
            box-shadow: unset !important;
        }

        body {
            background-color: #edf2f7;
            font-size: 14px;
            font-family: Nunito, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            color: #1a202c;
        }

        label {
            color: #4a5568;
        }

        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06) !important;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .form-control {
            padding: .5rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            height: auto;
            border-color: #e2e8f0;
        }

        .form-control:focus {

            font-size: 16px;
            color: #4a5568;
            background-color: #fff;
            border-color: #cbd5e0;
        }

        .btn {
            padding: .5rem 1rem;
            border-width: 1px;
            border-color: transparent;
            font-size: .875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            border-radius: .25rem;
        }

        .btn-black {
            background-color: #2d3748;
            color: #fff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .btn-black:hover {
            color: #fff;
            background-color: #4a5568;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06);
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .logo {
            font-family: 'Poppins', sans-serif;
            color: #4a5568;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 30px;
            text-align: center;
            line-height: 20px;
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="d-flex align-items-center justify-content-center">
    <div style="width: 100%;max-width: 380px">
        <div class="text-center pb-5 mt-5 logo">
            ADMIKO
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden px-4 py-3">
            @if(session()->has('error'))
                <div class="alert alert-danger invalid-feedback d-block">
                    {{ session()->get('error') }}
                </div>
            @endif
            <form method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="form-group row">
                    <label for="host" class="col-12 col-form-label py-0">{{ trans('install.admin_login') }}</label>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-12 col-form-label py-0">{{ trans('install.name') }}</label>
                    <div class="col-12 mt-1">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name')??'' }}" autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-12 col-form-label py-0">{{ trans('install.username') }}</label>
                    <div class="col-12 mt-1">
                        <input type="email" class="form-control" required="true" id="email" name="email" value="{{ old('email')??'' }}">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback d-block">{{ trans('install.username_required') }}</div>@endif
                        <div class="invalid-feedback">
                            {{ trans('install.required_email') }}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-12 col-form-label py-0">{{ trans('install.password') }}</label>
                    <div class="col-12 mt-1">
                        <input type="password" class="form-control" id="password" required="true" name="password" value="{{ old('password')??'' }}">
                        @if ($errors->has('password'))
                            <div class="invalid-feedback d-block">{{ trans('install.password_required') }}</div>@endif
                        <div class="invalid-feedback">
                            {{ trans('install.required_password') }}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="host" class="col-12 col-form-label py-0">{{ trans('install.db_label') }}</label>
                </div>
                <div class="form-group row">
                    <label for="db_host" class="col-12 col-form-label py-0">{{ trans('install.db_host') }}</label>
                    <div class="col-12 mt-1">
                        <input type="text" class="form-control" required="true" id="db_host" name="db_host" value="{{ old('db_host')??'' }}">
                        @if ($errors->has('db_host'))
                            <div class="invalid-feedback d-block">{{ trans('install.db_host_required') }}</div>@endif
                        <div class="invalid-feedback">
                            {{ trans('install.db_host_required') }}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="db_table" class="col-12 col-form-label py-0">{{ trans('install.db_table') }}</label>
                    <div class="col-12 mt-1">
                        <input type="text" class="form-control" required="true" id="db_table" name="db_table" value="{{ old('db_table')??'' }}">
                        @if ($errors->has('db_table'))
                            <div class="invalid-feedback d-block">{{ trans('install.db_table_required') }}</div>@endif
                        <div class="invalid-feedback">
                            {{ trans('install.db_table_required') }}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="db_user" class="col-12 col-form-label py-0">{{ trans('install.db_user') }}</label>
                    <div class="col-12 mt-1">
                        <input type="text" class="form-control" required="true" id="db_user" name="db_user" value="{{ old('db_user')??'' }}">
                        @if ($errors->has('db_user'))
                            <div class="invalid-feedback d-block">{{ trans('install.db_user_required') }}</div>@endif
                        <div class="invalid-feedback">
                            {{ trans('install.db_user_required') }}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="db_password" class="col-12 col-form-label py-0">{{ trans('install.db_password') }}</label>
                    <div class="col-12 mt-1">
                        <input type="text" class="form-control" required="true" id="db_password" name="db_password" value="{{ old('db_password') }}">
                    </div>
                </div>
                <div class="form-group row mb-0 antialiased">
                    <div class="col-12">
                        <button type="submit" class="btn btn-black transition-all w-100">{{ trans('install.install') }}</button>
                    </div>
                </div>
            </form>
        </div><!--content-->
    </div><!--container-fluid-->
</div>
</body>
</html>
