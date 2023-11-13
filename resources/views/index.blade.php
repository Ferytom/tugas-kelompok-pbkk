<!DOCTYPE html>
<html>
<head>
    <title>Papercup Website</title>
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
</head>
<body>
    <div class="top-bar">
        @if(Auth::check())
            <a href='notification.php'>
                <img src="{{asset('assets/img/notification-bell.png')}}" alt='Notification Icon'>
            </a>
            <p>Hi, {{Auth::user()->name}}</p>
            <a href='logout.php'>Logout</a>
        @endif
        @if(!Auth::check())
            <a href='login.php'>Login</a>
            <p> | </p>
            <a href='create-user.php'>Create Account</a>
        @endif
    </div>

    <div class="menu-bar">
        <div class="menu-toggle">
            <div class="bar"></div>
            <div class="bar middle"></div>
            <div class="bar"></div>
        </div>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="menu-list.php">Menu List</a></li>
            <li><a href="promo-list.php">Promo</a></li>
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

    </div>
</body>
</html>
