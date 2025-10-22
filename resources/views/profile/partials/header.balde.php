<header style="background: #f5f5f5; padding: 10px;">
    <h1>Cửa hàng sách Laravel</h1>
    <section class="row">
        <nav class="col-9">
            <a href="{{ route('home') }}">Trang chủ</a> |
            <a href="{{ route('books.index') }}">Sách</a> |
            <a href="/about">Giới thiệu</a>
        </nav>
        <div class="col-3 row">
            @if (Route::has('login'))
                @auth
                    <a class="col-3" href="{{ route('profile.edit') }}">
                        {{ Auth::user()->name }}
                    </a>
                    <form class="col-9" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="col-6">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="col-6">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </section>
</header>