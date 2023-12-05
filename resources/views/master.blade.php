<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
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
                            <path d="M17.35,2.219h-5.934c-0.115,0-0.225,0.045-0.307,0.128l-8.762,8.762c-0.171,0.168-0.171,0.443,0,0.611l5.933,5.934c0.167,0.171,0.443,0.169,0.612,0l8.762-8.763c0.083-0.083,0.128-0.192,0.128-0.307V2.651C17.781,2.414,17.587,2.219,17.35,2.219M16.916,8.405l-8.332,8.332l-5.321-5.321l8.333-8.332h5.32V8.405z M13.891,4.367c-0.957,0-1.729,0.772-1.729,1.729c0,0.957,0.771,1.729,1.729,1.729s1.729-0.772,1.729-1.729C15.619,5.14,14.848,4.367,13.891,4.367 M14.502,6.708c-0.326,0.326-0.896,0.326-1.223,0c-0.338-0.342-0.338-0.882,0-1.224c0.342-0.337,0.881-0.337,1.223,0C14.84,5.826,14.84,6.366,14.502,6.708"></path>
                        </svg>
                        <div>
                            <span>Promo</span>
                        </div>
                        <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ExpandLessIcon" height="1.5rem">
                            <path d="M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z" id="arrowPathPromo"></path>
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
                            <a href="{{ route('promo.index') }}" id="promoList">Promo List</a>
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
                    <li style="margin-top: 10px">
                        <div style="display: flex; align-items: center;">
                            <svg style="margin-right: 8px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path fill="none" d="M2.25,12.584c-0.713,0-1.292,0.578-1.292,1.291s0.579,1.291,1.292,1.291c0.713,0,1.292-0.578,1.292-1.291S2.963,12.584,2.25,12.584z M2.25,14.307c-0.238,0-0.43-0.193-0.43-0.432s0.192-0.432,0.43-0.432c0.238,0,0.431,0.193,0.431,0.432S2.488,14.307,2.25,14.307z M5.694,6.555H18.61c0.237,0,0.431-0.191,0.431-0.43s-0.193-0.431-0.431-0.431H5.694c-0.238,0-0.43,0.192-0.43,0.431S5.457,6.555,5.694,6.555z M2.25,8.708c-0.713,0-1.292,0.578-1.292,1.291c0,0.715,0.579,1.292,1.292,1.292c0.713,0,1.292-0.577,1.292-1.292C3.542,9.287,2.963,8.708,2.25,8.708z M2.25,10.43c-0.238,0-0.43-0.192-0.43-0.431c0-0.237,0.192-0.43,0.43-0.43c0.238,0,0.431,0.192,0.431,0.43C2.681,10.238,2.488,10.43,2.25,10.43z M18.61,9.57H5.694c-0.238,0-0.43,0.192-0.43,0.43c0,0.238,0.192,0.431,0.43,0.431H18.61c0.237,0,0.431-0.192,0.431-0.431C19.041,9.762,18.848,9.57,18.61,9.57z M18.61,13.443H5.694c-0.238,0-0.43,0.193-0.43,0.432s0.192,0.432,0.43,0.432H18.61c0.237,0,0.431-0.193,0.431-0.432S18.848,13.443,18.61,13.443z M2.25,4.833c-0.713,0-1.292,0.578-1.292,1.292c0,0.713,0.579,1.291,1.292,1.291c0.713,0,1.292-0.578,1.292-1.291C3.542,5.412,2.963,4.833,2.25,4.833z M2.25,6.555c-0.238,0-0.43-0.191-0.43-0.43s0.192-0.431,0.43-0.431c0.238,0,0.431,0.192,0.431,0.431S2.488,6.555,2.25,6.555z"></path>
                            </svg>
                            <a href="{{ route('waitlist.index') }}" id="waitingList">Waiting List</a>
                        </div>
                    </li>
                @endif

                @if (Auth::user()->role == 'pemilik')
                    <li style="margin-top: 10px">
                        <div style="display: flex; align-items: center;">
                            <svg style="margin-right: 8px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path fill="none" d="M12.173,16.086c0.72,0,1.304-0.584,1.304-1.305V6.089c0-0.72-0.584-1.304-1.304-1.304c-0.721,0-1.305,0.584-1.305,1.304v8.692C10.868,15.502,11.452,16.086,12.173,16.086z M11.738,6.089c0-0.24,0.194-0.435,0.435-0.435s0.435,0.194,0.435,0.435v8.692c0,0.24-0.194,0.436-0.435,0.436s-0.435-0.195-0.435-0.436V6.089zM16.52,16.086c0.72,0,1.304-0.584,1.304-1.305v-11.3c0-0.72-0.584-1.304-1.304-1.304c-0.721,0-1.305,0.584-1.305,1.304v11.3C15.215,15.502,15.799,16.086,16.52,16.086z M16.085,3.481c0-0.24,0.194-0.435,0.435-0.435s0.435,0.195,0.435,0.435v11.3c0,0.24-0.194,0.436-0.435,0.436s-0.435-0.195-0.435-0.436V3.481z M3.48,16.086c0.72,0,1.304-0.584,1.304-1.305v-3.477c0-0.72-0.584-1.304-1.304-1.304c-0.72,0-1.304,0.584-1.304,1.304v3.477C2.176,15.502,2.76,16.086,3.48,16.086z M3.045,11.305c0-0.24,0.194-0.435,0.435-0.435c0.24,0,0.435,0.194,0.435,0.435v3.477c0,0.24-0.195,0.436-0.435,0.436c-0.24,0-0.435-0.195-0.435-0.436V11.305z M18.258,16.955H1.741c-0.24,0-0.435,0.194-0.435,0.435s0.194,0.435,0.435,0.435h16.517c0.24,0,0.435-0.194,0.435-0.435S18.498,16.955,18.258,16.955z M7.826,16.086c0.72,0,1.304-0.584,1.304-1.305V8.696c0-0.72-0.584-1.304-1.304-1.304S6.522,7.977,6.522,8.696v6.085C6.522,15.502,7.106,16.086,7.826,16.086z M7.392,8.696c0-0.239,0.194-0.435,0.435-0.435s0.435,0.195,0.435,0.435v6.085c0,0.24-0.194,0.436-0.435,0.436s-0.435-0.195-0.435-0.436V8.696z"></path>                            </svg>
                            <a href="{{ route('report.index') }}" id="report">Report</a>
                        </div>
                    </li>
                    <li style="margin-top: 10px">
                        <div style="display: flex; align-items: center;">
                            <svg style="margin-right: 8px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M49 21.748a8.374 8.374 0 1 0-8.374-8.374A8.384 8.384 0 0 0 49 21.748zm0-13.96a5.586 5.586 0 1 1-5.587 5.586A5.592 5.592 0 0 1 49 7.788zM49.68 59.319a1.394 1.394 0 0 0-1.394 1.394V93.606a1.394 1.394 0 1 0 2.787 0V60.713A1.394 1.394 0 0 0 49.68 59.319zM44.985 22.127l-2.438.633a9.7 9.7 0 0 0-7.153 7.9L30.843 56.31c-.006.033-.011.066-.014.1a4.457 4.457 0 0 0 8.109 2.985l3.136 34.221a1.393 1.393 0 0 0 1.386 1.267q.065 0 .129-.006a1.393 1.393 0 0 0 1.261-1.515L41.23 53.854l.333-3.628a1.35 1.35 0 0 0 .027-.3L43.034 34.2a1.394 1.394 0 1 0-2.776-.255L38.8 49.8l-1.887 7.365c0 .019-.009.037-.013.056a1.673 1.673 0 0 1-3.3-.477l4.543-25.612.005-.03a6.92 6.92 0 0 1 5.1-5.64l2.437-.633a1.394 1.394 0 1 0-.7-2.7zM47.543 25.219v2.23a1.394 1.394 0 0 0 2.787 0v-2.23a1.394 1.394 0 1 0-2.787 0zM50.33 45.289V31.537a1.394 1.394 0 1 0-2.787 0V45.289a1.394 1.394 0 1 0 2.787 0zM67.8 63.834h-1.49V60.261a4.45 4.45 0 0 0 1.54-3.852c0-.033-.009-.066-.014-.1L63.286 30.656a9.7 9.7 0 0 0-7.153-7.9L53.7 22.127a1.394 1.394 0 1 0-.7 2.7l2.437.633a6.918 6.918 0 0 1 5.1 5.64l.005.03L65.083 56.74a1.673 1.673 0 0 1-3.3.477l-.008-.032-1.75-7.37a1.414 1.414 0 0 0-.093-.268l-.88-15.555a1.394 1.394 0 1 0-2.783.157l1.109 19.608-3.1 39.633a1.394 1.394 0 0 0 1.281 1.5c.037 0 .074 0 .11 0a1.394 1.394 0 0 0 1.388-1.285L59.73 59.378a4.472 4.472 0 0 0 3.683 1.953c.037 0 .074 0 .111 0v2.507H61.937a1.394 1.394 0 0 0-1.394 1.393V83.681a1.394 1.394 0 0 0 1.394 1.394H67.8a1.394 1.394 0 0 0 1.393-1.394V65.227A1.393 1.393 0 0 0 67.8 63.834zM66.408 82.287H63.331V66.621h3.077z"></path>
                            </svg>
                            <a href="{{ route('employee.index') }}" id="employee">Employees</a>
                        </div>
                    </li>
                    <li style="margin-top: 10px">
                        <div style="display: flex; align-items: center;">
                            <svg style="margin-right: 8px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path fill="none" d="M10,10.9c2.373,0,4.303-1.932,4.303-4.306c0-2.372-1.93-4.302-4.303-4.302S5.696,4.223,5.696,6.594C5.696,8.969,7.627,10.9,10,10.9z M10,3.331c1.801,0,3.266,1.463,3.266,3.263c0,1.802-1.465,3.267-3.266,3.267c-1.8,0-3.265-1.465-3.265-3.267C6.735,4.794,8.2,3.331,10,3.331z"></path>
							    <path fill="none" d="M10,12.503c-4.418,0-7.878,2.058-7.878,4.685c0,0.288,0.231,0.52,0.52,0.52c0.287,0,0.519-0.231,0.519-0.52c0-1.976,3.132-3.646,6.84-3.646c3.707,0,6.838,1.671,6.838,3.646c0,0.288,0.234,0.52,0.521,0.52s0.52-0.231,0.52-0.52C17.879,14.561,14.418,12.503,10,12.503z"></path>
                            </svg>
                            <a href="{{ route('member.index') }}" id="member">Members</a>
                        </div>
                    </li>
                @endif
            @endif
            @if ((Auth::check()) && (Auth::user()->role != 'pelanggan'))
                <div id="Transaction" style="margin-top: 10px">
                    <div tabindex="0" role="button" id="toggleButtonTransaction" style="display: flex; align-items: center; cursor: pointer;">
                        <svg style="margin-right: 8px;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="DescriptionIcon" height="1.5rem">
                            <path d="M10.862,6.47H3.968v6.032h6.894V6.47z M10,11.641H4.83V7.332H10V11.641z M12.585,11.641h-0.861v0.861h0.861V11.641z M7.415,14.226h0.862v-0.862H7.415V14.226z M8.707,17.673h2.586c0.237,0,0.431-0.193,0.431-0.432c0-0.237-0.193-0.431-0.431-0.431H8.707c-0.237,0-0.431,0.193-0.431,0.431C8.276,17.479,8.47,17.673,8.707,17.673 M5.691,14.226h0.861v-0.862H5.691V14.226z M4.83,13.363H3.968v0.862H4.83V13.363z M16.895,4.746h-3.017V3.023h1.292c0.476,0,0.862-0.386,0.862-0.862V1.299c0-0.476-0.387-0.862-0.862-0.862H10c-0.476,0-0.862,0.386-0.862,0.862v0.862c0,0.476,0.386,0.862,0.862,0.862h1.293v1.723H3.106c-0.476,0-0.862,0.386-0.862,0.862v12.926c0,0.476,0.386,0.862,0.862,0.862h13.789c0.475,0,0.861-0.387,0.861-0.862V5.608C17.756,5.132,17.369,4.746,16.895,4.746 M10.862,2.161H10V1.299h0.862V2.161zM11.724,1.299h3.446v0.862h-3.446V1.299z M13.016,4.746h-0.861V3.023h0.861V4.746z M16.895,18.534H3.106v-2.585h13.789V18.534zM16.895,15.088H3.106v-9.48h13.789V15.088z M15.17,12.502h0.862v-0.861H15.17V12.502z M13.447,12.502h0.861v-0.861h-0.861V12.502zM15.17,10.778h0.862V9.917H15.17V10.778z M15.17,9.055h0.862V8.193H15.17V9.055z M16.032,6.47h-4.309v0.862h4.309V6.47zM14.309,8.193h-0.861v0.862h0.861V8.193z M12.585,8.193h-0.861v0.862h0.861V8.193z M13.447,14.226h2.585v-0.862h-2.585V14.226zM13.447,10.778h0.861V9.917h-0.861V10.778z M12.585,9.917h-0.861v0.861h0.861V9.917z"></path>
                        </svg>
                        <div>
                            <span>Transaction</span>
                        </div>
                        <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ExpandLessIcon" height="1.5rem">
                            <path d="M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z" id="arrowPathTransaction"></path>
                        </svg>
                        <span></span>
                    </div>
                    <div id="dataSectionTransaction" style="display:none">
                    <li id="transactionList">
                            <div tabindex="-1" role="button">
                                <svg style="margin-right: 8px; vertical-align: middle;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ArrowRightIcon" height="1.5rem">
                                    <path d="m10 17 5-5-5-5v10z"></path>
                                </svg>
                                <a href="{{ route('transaction.index') }}">Transaction List</a>
                                <span></span>
                            </div>
                        </li>
                        <li id="createTransaction">
                            <div tabindex="-1" role="button">
                                <svg style="margin-right: 8px; vertical-align: middle;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ArrowRightIcon" height="1.5rem">
                                    <path d="m10 17 5-5-5-5v10z"></path>
                                </svg>
                                <a href="{{ route('transaction.create') }}">Create New Transaction</a>
                                <span></span>
                            </div>
                        </li>
                    </div>
                </div>
            @endif
            @if ((Auth::check()) && (Auth::user()->role == 'pemilik'))
                <div id="Location" style="margin-top: 10px">
                    <div tabindex="0" role="button" id="toggleButtonLocation" style="display: flex; align-items: center; cursor: pointer;">
                        <svg style="margin-right: 8px;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="DescriptionIcon" height="1.5rem">
                            <path d="M18.092,5.137l-3.977-1.466h-0.006c0.084,0.042-0.123-0.08-0.283,0H13.82L10,5.079L6.178,3.671H6.172c0.076,0.038-0.114-0.076-0.285,0H5.884L1.908,5.137c-0.151,0.062-0.25,0.207-0.25,0.369v10.451c0,0.691,0.879,0.244,0.545,0.369l3.829-1.406l3.821,1.406c0.186,0.062,0.385-0.029,0.294,0l3.822-1.406l3.83,1.406c0.26,0.1,0.543-0.08,0.543-0.369V5.506C18.342,5.344,18.242,5.199,18.092,5.137 M5.633,14.221l-3.181,1.15V5.776l3.181-1.15V14.221z M9.602,15.371l-3.173-1.15V4.626l3.173,1.15V15.371z M13.57,14.221l-3.173,1.15V5.776l3.173-1.15V14.221z M17.547,15.371l-3.182-1.15V4.626l3.182,1.15V15.371z"></path>
                        </svg>
                        <div>
                            <span>Locations</span>
                        </div>
                        <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ExpandLessIcon" height="1.5rem">
                            <path d="M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z" id="arrowPathLocation"></path>
                        </svg>
                        <span></span>
                    </div>
                    <div id="dataSectionLocation" style="display:none">
                        <li id="locationList">
                            <div tabindex="-1" role="button">
                                <svg style="margin-right: 8px; vertical-align: middle;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ArrowRightIcon" height="1.5rem">
                                    <path d="m10 17 5-5-5-5v10z"></path>
                                </svg>
                                <a href="{{ route('location.index') }}">Location List</a>
                                <span></span>
                            </div>
                        </li>
                        <li id="createLocation">
                            <div tabindex="-1" role="button">
                                <svg style="margin-right: 8px; vertical-align: middle;" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ArrowRightIcon" height="1.5rem">
                                    <path d="m10 17 5-5-5-5v10z"></path>
                                </svg>
                                <a href="{{ route('location.create') }}">Add New Location</a>
                                <span></span>
                            </div>
                        </li>
                    </div>
                </div>
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
        var dataSectionTransaction = document.getElementById('dataSectionTransaction');
        var arrowPathTransaction = document.getElementById('arrowPathTransaction');
        var dataSectionLocation = document.getElementById('dataSectionLocation');
        var arrowPathLocation = document.getElementById('arrowPathLocation');
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

        document.getElementById('toggleButtonTransaction').addEventListener('click', function () {
            dataSectionTransaction.style.display = (dataSectionTransaction.style.display === 'none' || dataSectionReservation.style.display === '') ? 'block' : 'none';

            if (dataSectionTransaction.style.display === 'none') {
                arrowPathTransaction.setAttribute('d', 'M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z');
            } else {
                arrowPathTransaction.setAttribute('d', 'm12 8-6 6 1.41 1.41L12 10.83l4.59 4.58L18 14z');
            }
        });

        document.getElementById('toggleButtonLocation').addEventListener('click', function () {
            dataSectionLocation.style.display = (dataSectionLocation.style.display === 'none' || dataSectionLocation.style.display === '') ? 'block' : 'none';

            if (dataSectionLocation.style.display === 'none') {
                arrowPathLocation.setAttribute('d', 'M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z');
            } else {
                arrowPathLocation.setAttribute('d', 'm12 8-6 6 1.41 1.41L12 10.83l4.59 4.58L18 14z');
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
        } else if (currentPath === '/waitlist') {
            document.getElementById('waitingList').style.display = 'block';
            document.getElementById('waitingList').style.width = '70%';
            document.getElementById('waitingList').style.padding = '8px';
            document.getElementById('waitingList').style.backgroundColor = 'yellowgreen';
        } else if (currentPath.startsWith('/report')) {
            document.getElementById('report').style.display = 'block';
            document.getElementById('report').style.width = '70%';
            document.getElementById('report').style.padding = '8px';
            document.getElementById('report').style.backgroundColor = 'yellowgreen';
        } else if (currentPath.startsWith('/employee')) {
            document.getElementById('employee').style.display = 'block';
            document.getElementById('employee').style.width = '70%';
            document.getElementById('employee').style.padding = '8px';
            document.getElementById('employee').style.backgroundColor = 'yellowgreen';
        } else if (currentPath === '/member') {
            document.getElementById('member').style.display = 'block';
            document.getElementById('member').style.width = '70%';
            document.getElementById('member').style.padding = '8px';
            document.getElementById('member').style.backgroundColor = 'yellowgreen';
        } else if (currentPath === '/transaction') {
            document.getElementById('toggleButtonTransaction').click();
            document.getElementById('transactionList').style.display = 'block';
            document.getElementById('transactionList').style.backgroundColor = 'yellowgreen';
        } else if (currentPath === '/transaction/create') {
            document.getElementById('toggleButtonTransaction').click();
            document.getElementById('createTransaction').style.display = 'block';
            document.getElementById('createTransaction').style.backgroundColor = 'yellowgreen';
        } else if (currentPath === '/location') {
            document.getElementById('toggleButtonLocation').click();
            document.getElementById('locationList').style.display = 'block';
            document.getElementById('locationList').style.backgroundColor = 'yellowgreen';
        } else if (currentPath === '/location/create') {
            document.getElementById('toggleButtonLocation').click();
            document.getElementById('createLocation').style.display = 'block';
            document.getElementById('createLocation').style.backgroundColor = 'yellowgreen';
        } else if (currentPath.startsWith('/menu')) {
            document.getElementById('toggleButtonMenu').click();
        } else if (currentPath.startsWith('/promo')) {
            document.getElementById('toggleButtonPromo').click();
        } else if (currentPath.startsWith('/reservation')) {
            document.getElementById('toggleButtonReservation').click();
        } else if (currentPath.startsWith('/transaction')) {
            document.getElementById('toggleButtonTransaction').click();
        } else if (currentPath.startsWith('/location')) {
            document.getElementById('toggleButtonLocation').click();
        }
    });
    </script>
</body>
</html>
