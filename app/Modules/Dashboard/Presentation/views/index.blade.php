<!DOCTYPE html>
<html lang="en">
<head>
    <meta charSet="utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/dashboard.css')}}">
    <title>Papercup</title>
</head>
<body>
    <div class="banner">
        <h1 class="MuiTypography-root MuiTypography-h1 css-1l5y4l6">Papercup</em></h1>
    </div>
    <div class="content">
        <div class="intro">
            <div class="text">
                <h2 class="title">Explore our culinary world at your fingertips</h2>
                <p>Browse menus, discover promotions, and effortlessly secure your dining experience with reservations</p>
                <p>You can get started without even making an account. And the best part? It's totally free. No ads, no paywall.</p>
                <div class="login-register">
                    @if(Auth::check())
                        <p>Hello, {{Auth::user()->nama}}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    @endif
                    @if(!Auth::check())
                        <a href="{{ route('login') }}">Login</a>
                        <p>or</p>
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                </div>
            </div>
            <img src="{{ asset('assets/img/dashboard/table.jpeg')}}" alt="Table placeholder."/>
        </div>
        <div class="services">
            <h2>Online Menus? Promotions? We got that.</h2>
            <div class="pages">
                <a href="{{ route('menu.index') }}">
                    <img alt="Menu" src="{{ asset('assets/img/dashboard/placeholder-menu.png')}}">
                </a>
                <a href="{{ route('promo.index') }}">
                    <img alt="Promo" src="{{ asset('assets/img/dashboard/promotion.jpeg')}}"/>
                </a>
            </div>
        </div>
        <hr>
        <div class="about-us">
            <div class="social-media">
                <h2>Our Social Media</h2>
                <p>Check us on social media!</p>
                <div class="css-0">
                    <div class="card">
                        <a class="instagram" href="https://www.instagram.com/papercup.co" title="Visit Papercup Instagram" target="_blank">
                            <img src="{{ asset('assets/img/dashboard/instagram-logo.png')}}" alt="Instagram" rel="noreferrer noopener">
                            <div class="description">
                                <p>Papercup.co</p>
                                <span>Instagram</span>
                            </div>
                        </a>
                        <a class="twitter" href="https://twitter" title="Visit Papercup Twitter" target="_blank" rel="noreferrer noopener">
                            <img src="{{ asset('assets/img/dashboard/x-logo.png')}}" alt="X"/>
                            <div class="description">
                                <p>Papercup</p>
                                <span>X</span>
                            </div>
                        </a>
                        <a class="facebook" href="https://facebook.com" title="Visit Papercup Facebook" target="_blank" rel="noreferrer noopener">
                            <img src="{{ asset('assets/img/dashboard/facebook-logo.jpeg')}}" alt="Facebook"/>
                            <div class="description">
                                <p>Papercup</p>
                                <span>Facebook</span>
                            </div>
                        </a>
                        <a class="reddit" href="https://reddit.com" title="Visit Papercup Reddit" target="_blank" rel="noreferrer noopener">
                            <img src="{{ asset('assets/img/dashboard/reddit-logo.png')}}" alt="reddit"/>
                            <div class="description">
                                <p>Papercup</p>
                                <span>Reddit</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="locations">
                <h2>Our Location</h2>
                @foreach($locations as $location)
                    <a class="maps" href="{{$location->googleMap}}" title="{{$location->namaLokasi}}" target="_blank" rel="noreferrer noopener">
                        <img src="{{ asset('assets/img/dashboard/maps-logo.png')}}" alt="Google Map" loading="lazy"/>
                        <div class="description">
                            <p>{{$location->namaLokasi}}</p>
                            <span>{{$location->alamat}}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>