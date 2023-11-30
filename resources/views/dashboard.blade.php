@extends("layouts.app")

@section("content")
    <div class="prose hero bg-base-200 mx-auto max-w-full rounded">
        <div class="hero-content text-center my-10">
            <dis class="max-w-md mb-10">
                <h2>Let's make a tasklist</h2>
                {{--ユーザ登録ページへのリンク--}}
                <a class="btn btn-primary btn-lg normal-case" href="{{ route("register") }}">Sign up now!</a>
            </dis>
        </div>
    </div>
@endsection