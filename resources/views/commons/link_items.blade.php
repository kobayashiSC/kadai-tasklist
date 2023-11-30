@if (Auth::check())
    {{--メッセージ作成ページへのリンク --}}
    <li><a class="link link-hover" href="#">新規タスクの登録</a></li>
    {{--ログアウトへのリンク--}}
    <li><a class="link link-hover" href="#" onclick="event.preventDefault();this.closest("form").submit();">Logout</a></li>
@else
    {{--ユーザ登録ページへのリンク--}}
    <li><a class="link link-hover" href="{{ route("register") }}">Signup</a></li>
    <li class="divider lg:hidden"></li> 
    {{--ログインページへのリンク--}}
    <li><a class="link link-hover" href="{{ route("login") }}">Login</a></li>
@endif