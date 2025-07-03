<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Register PMB </title>
    <meta charset="utf-8" />
    <meta name="description" content="The most updates for free." />
    <meta name="keywords" content="tailwind, atepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="PMB" />
    <link rel="canonical" href="" />
    <link rel="shortcut icon" href="{{ url('img/logo.jpeg') }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ url('themes/dist/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('themes/dist/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center">
    <!--begin::Theme mode setup on page load-->
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
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url({{ url('/themes/dist/assets/media/auth/bg10.jpeg') }});
            }

            [data-bs-theme="dark"] body {
                background-image: url({{ url('/themes/dist/assets/media/auth/bg10-dark.jpeg') }});
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->

        <div class="d-flex flex-column flex-lg-row justify-content-center mt-20">
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-450px p-10">
                    <!--begin::Content-->
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-50 w-md-300px">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-center flex-column flex-column-fluid">
                            <!--begin::Form-->
                            <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
                                action="{{ url('/register') }}" method="POST">
                                @csrf
                                <!--begin::Heading-->
                                <div class="text-center mb-11">
                                    <img alt="Logo" src="{{ url('img/logo.jpeg') }}"
                                        style="height: 75px; margin-bottom:10px" />
                                    <h1 class="text-gray-900 fw-bolder mb-3">PMB - STMIK KREATINDO</h1>
                                    <div class="text-gray-500 fw-semibold fs-7">akun berhasil dibuat.</div>
                                </div>
                                <!--begin::Heading-->

                                <!--begin::Submit button-->
                                <div class="d-grid mb-10">
                                    <a href="{{ route('admin.login') }}" class="btn btn-info">
                                        <span class="indicator-label">Login to Account</span>
                                        </button>
                                    </a>
                                </div>
                                <!--end::Submit button-->
                                <!--begin::Sign up-->
                                <div class="text-gray-500 text-center fw-semibold fs-6">
                                    <!-- Not a Member yet? <a href="#" class="link-primary">Sign up</a> -->
                                    Back to <a href="{{ url('/') }}" class="link-primary">Home</a>
                                </div>
                                <!--end::Sign up-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ url('themes/dist/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ url('themes/dist/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <!-- <script src="{{ url('themes/dist/assets/js/custom/authentication/sign-in/general.js') }}"></script> -->
    <!--end::Custom Javascript-->

    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
