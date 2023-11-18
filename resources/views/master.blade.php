<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".menu-toggle").click(function() {
                $(".menu-bar").toggleClass("collapsed");
                $(".collapsed-menu-bar").toggleClass("collapsed");
                $(".menu-bar ul li").toggleClass("collapsed");
            });
        });
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    <script src="./assets/js/charts-lines.js" defer></script>
    <script src="./assets/js/charts-pie.js" defer></script>

</head>
<body>
    <div class="top-bar">
        @if(Auth::check())
            <a href='notification.php'>
                <img src="{{asset('assets/img/notification-bell.png')}}" alt='Notification Icon'>
            </a>
            <p>Hi, {{ Auth::user()->nama }} | </p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
        @endif
        @if(!Auth::check())
            <a href="{{ route('login') }}">Login</a>
            <p> | </p>
            <a href="{{ route('register') }}">Create Account</a>
        @endif
    </div>

    <div class="menu-bar">
        <div class="menu-toggle">
            <div class="bar"></div>
            <div class="bar middle"></div>
            <div class="bar"></div>
        </div>
        <ul>
            <li>
                @if (Request::is('/'))
                    <a href="{{ route('dashboard') }}"><p style="font-size: 150%; margin-left:10px;">Dashboard</p></a>
                @endif
                @if (!Request::is('/'))
                    <a href="{{ route('dashboard') }}"><p>Dashboard</p></a>
                @endif
            </li>
            <li>
                @if (Request::is('menu*'))
                    <a href="{{ route('menu.index') }}"><p style="font-size: 150%; margin-left:10px;">Menu List</p></a>
                @endif
                @if (!Request::is('menu*'))
                    <a href="{{ route('menu.index') }}"><p>Menu List</p></a>
                @endif
            </li>
            <li>
                @if (Request::is('promo*'))
                    <a href="{{ route('promo.index') }}"><p style="font-size: 150%; margin-left:10px;">Promo List</p></a>
                @endif
                @if (!Request::is('promo*'))
                    <a href="{{ route('promo.index') }}"><p>Promo List</p></a>
                @endif
            </li>
            @if (Auth::check())
                <li>Reservations
                    <ul>
                        <li><a href='reservation-list.php'>Reservation List</a></li>
                        @if (Auth::user()->role == 'Pelanggan')
                            <li><a href='create-reservation.php'>Make a Reservation</a></li>
                        @endif
                    </ul>
                </li>

                @if (Auth::user()->role != 'pelanggan')
                    <li><a href='waitlist.php'>Wait List</a></li>
                @endif

                @if (Auth::user()->role == 'pemilik')
                    <li><a href='report.php'>Report</a></li>
                    <li><a href='employee-list.php'>Employee List</a></li>
                    <li><a href='member-list.php'>Member List</a></li>
                @endif
            @endif
            <li><a href='review-list.php'>Reviews</a></li>
        </ul>
    </div>

    <div class="collapsed-menu-bar"></div>
    
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
