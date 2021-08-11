@extends('layout_auth')
@section('content')
    <!-- Login card -->
    <form class="login-form" action="/login" method="post">
        {{ csrf_field() }}
        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0">Войдите в свой аккаунт</h5>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="text" class="form-control" placeholder="Email" name="email">
                    <div class="form-control-feedback">
                        <i class="icon-user text-muted"></i>
                    </div>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="password" class="form-control" placeholder="Пароль" name="password">
                    <div class="form-control-feedback">
                        <i class="icon-lock2 text-muted"></i>
                    </div>
                </div>

                <div class="form-group d-flex align-items-center">
                    <div class="form-check mb-0">
                        <label class="form-check-label">
                            <input type="checkbox" name="remember" class="form-input-styled" checked data-fouc>
                            Запомнить
                        </label>
                    </div>

                    <a href="login_password_recover.html" class="ml-auto">Forgot password?</a>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Вход <i class="icon-circle-right2 ml-2"></i></button>
                </div>
            </div>
        </div>
    </form>
    <!-- /login card -->
@endsection