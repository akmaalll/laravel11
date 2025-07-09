<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Sistem Pengajuan Judul - UNDIPA</title>
    <meta charset="utf-8" />
    <meta name="description" content="umi-fikir" />
    <meta name="keywords" content="umi-fikir" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:title" content="Umi - LP2s" />
    <meta property="og:url" content="https://fikir.umi-ac.id" />
    <meta property="og:site_name" content="FIKIR-UMI" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- <link rel="shortcut icon" href="{{ asset('public/logo-fikir.png') }}" /> --}}

    @include('app.layouts._css')
    @stack('css-scripts')

    <!-- Theme mode setup -->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
</head>
<!--end::Head-->

<body id="kt_body" class="header-extended header-fixed header-tablet-and-mobile-fixed">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('app.layouts.header')
                <!--end::Header-->

                <!--begin::Content-->
                {{-- <div class="content container-xxl" id="kt_content"> --}}
                    @yield('content')
                {{-- </div> --}}
                <!--end::Content-->

                <!--begin::Footer-->
                @include('app.layouts.footer')
                <!--end::Footer-->

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->

    <!--begin::Javascript-->
    @include('app.layouts._js')

    <!-- Dynamic JS Scripts -->
    @stack('jsScript')
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
