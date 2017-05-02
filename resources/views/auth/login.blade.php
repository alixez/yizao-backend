@extends('layouts.auth')

@section('content')
    @parent
    <section class="app-main">
        <div class="container">
            <div class="columns">
                <div class="column is-4 is-offset-4">
                    <div class="tile is-ancestor">

                        <div class="tile is-parent">
                            <article class="tile is-child box">
                                <h1 class="title text-to-center">登录</h1>
                                <div class="block">
                                    <form role="form" method="POST" action="{{ route('login') }}">
                                        {{ csrf_field() }}
                                        <p class="control has-icon">
                                            <input class="input{{ $errors->has('email') ? ' is-danger' : '' }}" type="email" name="email" value="{{ old('email') }}" placeholder="账户">
                                            <span class="icon is-small">
                                                <i class="fa fa-user"></i>
                                            </span>

                                            @if ($errors->has('email'))
                                            <span class="help is-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </p>
                                        <p class="control has-icon">
                                            <input class="input{{ $errors->has('password') ? ' is-danger' : '' }}" type="password" name="password" value="{{ old('password') }}" placeholder="密码">
                                            <span class="icon is-small">
                                                <i class="fa fa-lock"></i>
                                            </span>

                                            @if ($errors->has('password'))
                                            <span class="help is-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </p>
                                        <p class="control">
                                            <button type="submit" class="button is-success btn-is-full">
                                                登录
                                            </button>
                                            <!-- 按钮被点击时的效果
                                            <button class="button is-success btn-is-full is-loading">
                                                登录
                                            </button>
                                            ./End -->
                                        </p>
                                        <p class="control">
                                            <a class="button is-link pull-left hide-decoration" href="/register">用户注册</a>
                                            <a class="button is-link pull-right hide-decoration" href="#">忘记密码?</a>
                                        </p>
                                    </form>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
