<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?date={{ date('Ymd') }}"></script>
    <script src="{{ asset('js/vendor.js') }}?date={{ date('Ymd') }}"></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <style>
        @font-face {
            font-family: "Poppins";
            src: url("{{ asset('fonts/Poppins/Poppins-Regular.ttf') }}");
        }
        .tableform {
            counter-reset: rowNumber;
        }

        .tableform tr {
            counter-increment: rowNumber;
        }

        .tableform tr td:first-child::before {
            content: counter(rowNumber);
            min-width: 1em;
            margin-right: 0.5em;
        }
    </style>
    <link href="{{ asset('css/app.css') }}?date={{ date('Ymd') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor.css') }}?date={{ date('Ymd') }}" rel="stylesheet">
    @yield('css')
</head>

<body class="hold-transition sidebar-mini avian">
    <div id="app" class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-avian">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Example Menu</a>
                </li> -->
            </ul>

            @if (config('app.search_nav', false))
            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            @endif

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-cog"></i>
                    </a>
                </li> -->
                @if (auth()->user()->pegawai)
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-danger navbar-badge notification-unread-total">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <object
                            data="{{ request()->getSchemeAndHttpHost().'/avian-notification/public/list/'.auth()->user()->pegawai->Kode }}"
                            style="width: 100%;height: 75vh;overflow: hidden;"></object>
                    </div>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <span>{{ auth()->user()->pegawai ? auth()->user()->pegawai->Nama : (auth()->user()->Username ?? auth()->user()->name) }}</span>
                        <img src="{{ asset('images/default-avatar.png') }}" class="img-circle elevation-1 ml-2" style="width: 26px; height: 26px;">
                        <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('userguide') }}">
                            <i class="fas fa-question-circle pr-3"></i>{{ __('Bantuan') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('security') }}">
                            <i class="fas fa-key pr-3"></i>{{ __('Ubah Password') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt pr-3"></i>{{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-dark-avian">
            <!-- Brand Logo -->
            <a href="/" class="brand-link navbar-avian">

                <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
            </a>

            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
            <!-- /.content -->
            <object
                data="{{ request()->getSchemeAndHttpHost().'/avian-notification/public/list/'.auth()->user()->pegawai->Kode }}"
                style="height: 0; width: 0;"></object>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="https://www.avianbrands.com">Avian Brands</a>.</strong> All rights reserved.
        </footer>
    </div>
    <script>
        $(function () {
            bsCustomFileInput.init()

            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy',
            });

            $('.select2').select2({
                placeholder: 'Pilih...',
                theme: 'bootstrap4',
            });

            if ($('.numeric').length > 0) {
                let numeric = new AutoNumeric('.numeric', {
                    allowDecimalPadding: false,
                    decimalCharacter: ',',
                    digitGroupSeparator: '.',
                    decimalPlaces: 3,
                    decimalPlacesRawValue: 3,
                });
            }

            if (window.localStorage.getItem('sidebar')) {
                $('body').addClass('sidebar-collapse');

                $('.nav-item .nav-link p').removeClass('text-wrap');
            }

            $('a[data-widget=pushmenu]').on('click', function (e) {
                if (!$('body').hasClass('sidebar-collapse')) {
                    window.localStorage.setItem('sidebar', 'collapse');
                    $('.nav-item .nav-link p').removeClass('text-wrap');
                } else {
                    window.localStorage.removeItem('sidebar');
                    $('.nav-item .nav-link p').addClass('text-wrap');
                }
            });

            const updateNotificationCounter = function () {
                let unreadNotifications = parseInt(window.localStorage.getItem('unreadNotifications') || 0);
                $('.notification-unread-total').text(unreadNotifications > 9 ? '9+' : unreadNotifications);
            }

            updateNotificationCounter();

            $(window).on('storage', function () {
                updateNotificationCounter();
            });
        });
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @yield('js')
</body>

</html>
