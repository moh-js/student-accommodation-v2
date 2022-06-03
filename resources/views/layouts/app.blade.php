<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $title = 'MAS';
            $segment1 = request()->segment(1);
            $segment2 = request()->segment(2);
            $segment3 = request()->segment(3);

            if ($segment3) {
                $segment1 = "$segment1 | $segment2";
            }

            if ($segment1) {
                $title = "$title | $segment1";
            }
        @endphp

        <title>{{ $title }}</title>
        {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
        {{-- <meta content="Themesdesign" name="author" /> --}}
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="//cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

        <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">

        <style>
            * {
                font-family: 'Quicksand', sans-serif !important;
            }
        </style>

        @stack('link')

    </head>

    @auth
        <body data-sidebar="dark">

            <!-- Begin page -->
            <div id="layout-wrapper">

                @include('layouts.partials.header')

                <!-- ========== Left Sidebar Start ========== -->
                @include('layouts.partials.sidebar')
                <!-- Left Sidebar End -->

                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->
                <div class="main-content">

                    <div class="page-content">
                        <div class="container-fluid">

                            <!-- start page title -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-flex align-items-center justify-content-between">
                                        <h4 class="mb-0">@stack('title')</h4>

                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ title_case($segment1) }}</a></li>
                                                @if ($segment3)
                                                <li class="breadcrumb-item">{{ title_case($segment3) }}</li>
                                                @else
                                                <li class="breadcrumb-item">{{ title_case($segment2) }}</li>
                                                @endif
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title -->

                            @yield('content')

                        </div> <!-- container-fluid -->
                    </div>
                    <!-- End Page-content -->


                    <footer class="footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <script>document.write(new Date().getFullYear())</script> © Nazox.
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-right d-none d-sm-block">
                                        Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
                <!-- end main content-->

            </div>
            <!-- END layout-wrapper -->

            <!-- Right Sidebar -->
            <div class="right-bar">
                <div data-simplebar class="h-100">
                    <div class="rightbar-title px-3 py-4">
                        <a href="javascript:void(0);" class="right-bar-toggle float-right">
                            <i class="mdi mdi-close noti-icon"></i>
                        </a>
                        <h5 class="m-0">Settings</h5>
                    </div>

                    <!-- Settings -->
                    <hr class="mt-0" />
                    <h6 class="text-center mb-0">Choose Layouts</h6>

                    <div class="p-4">
                        <div class="mb-2">
                            {{-- <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt=""> --}}
                        </div>
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input"   />
                            <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                        </div>

                        <div class="mb-2">
                            {{-- <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt=""> --}}
                        </div>
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" {{-- data-bsStyle="{{ asset('assets/css/bootstrap-dark.min.css') }}" data-appStyle="{{ asset('assets/css/app-dark.min.css') }}" --}} />
                            <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                        </div>

                        <div class="mb-2">
                            {{-- <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt=""> --}}
                        </div>
                        {{-- <div class="custom-control custom-switch mb-5">
                            <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css" />
                            <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
                        </div> --}}


                    </div>

                </div> <!-- end slimscroll-menu-->
            </div>
            <!-- /Right-bar -->

            <!-- Right bar overlay-->
            <div class="rightbar-overlay"></div>

            <!-- JAVASCRIPT -->
            <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
            <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
            <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
            <script src="{{ asset('assets/libs/node-waves/waves.min') }}.js"></script>
    -
            <script src="{{ asset('assets/js/app.js') }}"></script>

            <script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
            <script src="//cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
            {!! Toastr::message() !!}

            @stack('script')

        </body>

    @else


        <body class="auth-body-bg">
            @if (Route::is('login'))
            <div class="home-btn d-none d-sm-block">
                <a href="{{ route('dashboard') }}"><i class="mdi mdi-home-variant h2 text-white"></i></a>
            </div>
            @endif
            <div>
                @yield('content')
            </div>

            <!-- JAVASCRIPT -->
            <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
            <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
            <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
            <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

            <script src="{{ asset('assets/js/app.js') }}"></script>

            <script src="//cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
            {!! Toastr::message() !!}

            @stack('script')

        </body>
    @endauth
</html>

