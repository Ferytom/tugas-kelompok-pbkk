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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>


</head>
<body>
    <div class="top-bar">
        @if(Auth::check())
            <a href="{{ route('notification.index') }}">
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
                <div style="display: flex; align-items: center;">
                    <svg style="margin-right: 8px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <a href="{{ route('dashboard') }}" id="dashboard">Dashboard</a>
                </div>
            </li>
            <div id="Menu" style="margin-top: 10px">
                @if((Auth::check()) && (Auth::user()->role != 'pelanggan'))
                    <div tabindex="0" role="button" id="toggleButtonMenu" style="display: flex; align-items: center; cursor: pointer;">
                        <svg style="margin-right: 8px;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="DescriptionIcon" height="1.5rem">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"></path>
                        </svg>
                        <div>
                            <span>Menu</span>
                        </div>
                        <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ExpandLessIcon" height="1.5rem">
                            <path d="M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z" id="arrowPathMenu"></path>
                        </svg>
                        <span></span>
                    </div>
                    <div id="dataSectionMenu" style="display:none">
                    <li id="menuList">
                            <div tabindex="-1" role="button">
                                <svg style="margin-right: 8px; vertical-align: middle;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ArrowRightIcon" height="1.5rem">
                                    <path d="m10 17 5-5-5-5v10z"></path>
                                </svg>
                                <a href="{{ route('menu.index') }}">Menu List</a>
                                <span></span>
                            </div>
                        </li>
                        <li id="createMenu">
                            <div tabindex="-1" role="button">
                                <svg style="margin-right: 8px; vertical-align: middle;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ArrowRightIcon" height="1.5rem">
                                    <path d="m10 17 5-5-5-5v10z"></path>
                                </svg>
                                <a href="{{ route('menu.create') }}">Create New Menu</a>
                                <span></span>
                            </div>
                        </li>
                    </div>
                @endif
                <li>
                    @if(!((Auth::check()) && (Auth::user()->role != 'pelanggan')))
                        <div style="display: flex; align-items: center;">
                            <svg style="margin-right: 8px;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="DescriptionIcon" height="1.5rem">
                                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"></path>
                            </svg>
                            <a href="{{ route('menu.index') }}" id="menuList">Menu List</a>
                        </div>
                    @endif
                </li>
            </div>
            <div id="Promo" style="margin-top: 10px">
                @if((Auth::check()) && (Auth::user()->role == 'pemilik'))
                    <div tabindex="0" role="button" id="toggleButtonPromo" style="display: flex; align-items: center; cursor: pointer;">
                        <svg style="margin-right: 8px;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="DescriptionIcon" height="1.5rem">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"></path>
                        </svg>
                        <div>
                            <span>Promo</span>
                        </div>
                        <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ExpandLessIcon" height="1.5rem">
                            <path d="M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z" id="arrowPathMenu"></path>
                        </svg>
                        <span></span>
                    </div>
                    <div id="dataSectionPromo" style="display:none">
                    <li id="promoList">
                            <div tabindex="-1" role="button">
                                <svg style="margin-right: 8px; vertical-align: middle;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ArrowRightIcon" height="1.5rem">
                                    <path d="m10 17 5-5-5-5v10z"></path>
                                </svg>
                                <a href="{{ route('promo.index') }}">Promo List</a>
                                <span></span>
                            </div>
                        </li>
                        <li id="createPromo">
                            <div tabindex="-1" role="button">
                                <svg style="margin-right: 8px; vertical-align: middle;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ArrowRightIcon" height="1.5rem">
                                    <path d="m10 17 5-5-5-5v10z"></path>
                                </svg>
                                <a href="{{ route('promo.create') }}">Create New Promo</a>
                                <span></span>
                            </div>
                        </li>
                    </div>
                @endif
                <li>
                    @if(!((Auth::check()) && (Auth::user()->role == 'pemilik')))
                        <div style="display: flex; align-items: center;">
                            <svg style="margin-right: 8px;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="DescriptionIcon" height="1.5rem">
                                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"></path>
                            </svg>
                            <a href="{{ route('menu.index') }}" id="menuList">Menu List</a>
                        </div>
                    @endif
                </li>
            </div>
            @if (Auth::check())
                <div id="Reservation" style="margin-top: 10px">
                    <div tabindex="0" role="button" id="toggleButtonReservation" style="display: flex; align-items: center; cursor: pointer;">
                        <svg style="margin-right: 8px;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="DescriptionIcon" height="1.5rem">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"></path>
                        </svg>
                        <div>
                            <span>Reservations</span>
                        </div>
                        <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ExpandLessIcon" height="1.5rem">
                            <path d="M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z" id="arrowPathReservation"></path>
                        </svg>
                        <span class=""></span>
                    </div>
                    <div id="dataSectionReservation" style="display:none">
                        <li id="reservationList">
                            <div tabindex="-1" role="button">
                                <svg style="margin-right: 8px; vertical-align: middle;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ArrowRightIcon" height="1.5rem">
                                    <path d="m10 17 5-5-5-5v10z"></path>
                                </svg>
                                <a href="{{ route('reservation.index') }}">Reservation List</a>
                                <span></span>
                            </div>
                        </li>
                        <li id="createReservation">
                            <div tabindex="-1" role="button">
                                <svg style="margin-right: 8px; vertical-align: middle;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ArrowRightIcon" height="1.5rem">
                                    <path d="m10 17 5-5-5-5v10z"></path>
                                </svg>
                                <a href="{{ route('reservation.create') }}">Create a New Reservation</a>
                                <span></span>
                            </div>
                        </li>
                    </div>
                </div>
                @if (Auth::user()->role != 'pelanggan')
                    <li>
                        @if (Request::is('waitlist*'))
                            <a href="{{ route('waitlist.index') }}"><p style="font-size: 150%; margin-left:10px;">Waiting List</p></a>
                        @endif
                        @if (!Request::is('waitlist*'))
                            <a href="{{ route('waitlist.index') }}"><p>Waiting List</p></a>
                        @endif
                    </li>
                @endif

                @if (Auth::user()->role == 'pemilik')
                    <li>
                        @if (Request::is('report*'))
                            <a href="{{ route('report.index') }}"><p style="font-size: 150%; margin-left:10px;">Report</p></a>
                        @endif
                        @if (!Request::is('report*'))
                            <a href="{{ route('report.index') }}"><p>Report</p></a>
                        @endif
                    </li>
                    <li>
                        @if (Request::is('employee*'))
                            <a href="{{ route('employee.index') }}"><p style="font-size: 150%; margin-left:10px;">Employee List</p></a>
                        @endif
                        @if (!Request::is('employee*'))
                            <a href="{{ route('employee.index') }}"><p>Employee List</p></a>
                        @endif
                    </li>
                    <li>
                        @if (Request::is('member*'))
                            <a href="{{ route('member.index') }}"><p style="font-size: 150%; margin-left:10px;">Member List</p></a>
                        @endif
                        @if (!Request::is('member*'))
                            <a href="{{ route('member.index') }}"><p>Member List</p></a>
                        @endif
                    </li>
                @endif
            @endif
            @if ((Auth::check()) && (Auth::user()->role != 'pelanggan'))
                @if (Request::is('transaction*'))
                    <a href="{{ route('transaction.index') }}"><p style="font-size: 150%; margin-left:10px;">Transaction List</p></a>
                @endif
                @if (!Request::is('transaction*'))
                    <a href="{{ route('transaction.index') }}"><p>Transaction List</p></a>
                @endif
            @endif
        </ul>
    </div>

    <div class="collapsed-menu-bar"></div>
    
    <div class="content">
        @yield('content')
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var dataSectionReservation = document.getElementById('dataSectionReservation');
        var arrowPathReservation = document.getElementById('arrowPathReservation');
        var dataSectionMenu = document.getElementById('dataSectionMenu');
        var arrowPathMenu = document.getElementById('arrowPathMenu');
        var dataSectionPromo = document.getElementById('dataSectionPromo');
        var arrowPathPromo = document.getElementById('arrowPathPromo');
        var currentPath = window.location.pathname;

        document.getElementById('toggleButtonMenu').addEventListener('click', function () {
            dataSectionMenu.style.display = (dataSectionMenu.style.display === 'none' || dataSectionMenu.style.display === '') ? 'block' : 'none';

            if (dataSectionMenu.style.display === 'none') {
                arrowPathMenu.setAttribute('d', 'M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z');
            } else {
                arrowPathMenu.setAttribute('d', 'm12 8-6 6 1.41 1.41L12 10.83l4.59 4.58L18 14z');
            }
        });

        document.getElementById('toggleButtonPromo').addEventListener('click', function () {
            dataSectionPromo.style.display = (dataSectionPromo.style.display === 'none' || dataSectionPromo.style.display === '') ? 'block' : 'none';

            if (dataSectionPromo.style.display === 'none') {
                arrowPathPromo.setAttribute('d', 'M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z');
            } else {
                arrowPathPromo.setAttribute('d', 'm12 8-6 6 1.41 1.41L12 10.83l4.59 4.58L18 14z');
            }
        });

        document.getElementById('toggleButtonReservation').addEventListener('click', function () {
            dataSectionReservation.style.display = (dataSectionReservation.style.display === 'none' || dataSectionReservation.style.display === '') ? 'block' : 'none';

            if (dataSectionReservation.style.display === 'none') {
                arrowPathReservation.setAttribute('d', 'M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z');
            } else {
                arrowPathReservation.setAttribute('d', 'm12 8-6 6 1.41 1.41L12 10.83l4.59 4.58L18 14z');
            }
        });

        if (currentPath === '/reservation') {
            document.getElementById('toggleButtonReservation').click();
            document.getElementById('reservationList').style.display = 'block';
            document.getElementById('reservationList').style.backgroundColor = 'yellowgreen';
        } else if (currentPath === '/reservation/create') {
            document.getElementById('toggleButtonReservation').click();
            document.getElementById('createReservation').style.display = 'block';
            document.getElementById('createReservation').style.backgroundColor = 'yellowgreen';
        } else if (currentPath === '/menu') {
            document.getElementById('toggleButtonMenu').click();
            document.getElementById('menuList').style.display = 'block';
            document.getElementById('menuList').style.backgroundColor = 'yellowgreen';
        } else if (currentPath === '/menu/create') {
            document.getElementById('toggleButtonMenu').click();
            document.getElementById('createMenu').style.display = 'block';
            document.getElementById('createMenu').style.backgroundColor = 'yellowgreen';
        } else if (currentPath === '/promo') {
            document.getElementById('toggleButtonPromo').click();
            document.getElementById('promoList').style.display = 'block';
            document.getElementById('promoList').style.backgroundColor = 'yellowgreen';
        } else if (currentPath === '/promo/create') {
            document.getElementById('toggleButtonPromo').click();
            document.getElementById('createPromo').style.display = 'block';
            document.getElementById('createPromo').style.backgroundColor = 'yellowgreen';
        }
        else {
            document.getElementById('dashboard').style.display = 'block';
            document.getElementById('dashboard').style.width = '70%';
            document.getElementById('dashboard').style.padding = '8px';
            document.getElementById('dashboard').style.backgroundColor = 'yellowgreen';
        } 
    });
    </script>

</body>
</html>
