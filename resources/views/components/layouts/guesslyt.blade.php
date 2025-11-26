<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <link rel="shortcut icon" href="{{ asset('dist/assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" crossorigin href="{{ asset('dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('dist/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('dist/assets/compiled/css/iconly.css') }}">
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const root = document.documentElement;

            function applySystemTheme() {
                const systemDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
                root.setAttribute("data-bs-theme", systemDark ? "dark" : "light");
            }
            applySystemTheme();
            window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", applySystemTheme);
        });
    </script>

    <style>
        #navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            background-color: rgba(31, 41, 55, 0.95) !important;
            backdrop-filter: blur(8px);
            box-shadow: none;
            transition: all 0.3s ease;
        }

        #navbar a,
        #navbar p,
        #navbar h6 {
            color: #ffffff;
        }

        .logo {
            width: 5%;
        }
        @media (max-width: 768px) {
            .logo {
                width: 15%;
            }
        }


        .blog-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .blog-card:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.15) !important;
        }
    </style>
</head>

<body style="padding-top: 70px;">
    <script src="{{ asset('dist/assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div id="navbar" class="header-top">
                    <div class="container d-flex justify-content-between align-items-center py-2">
                        <a href="{{ route('landing-page') }}">
                            <h6 class="d-flex align-items-center mb-0">
                                <img src="{{ asset('img/logo_fp-removebg-preview.png') }}" alt="Logo Ruang IT" class="logo">
                                <p class="text-2xl ms-3 mb-0">Ruang IT</p>
                            </h6>
                        </a>
                        <div class="header-top-right">
                            <div class="dropdown">
                                <a href="#" id="topbarUserDropdown"
                                    class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar" style="width: 32px; height: 32px;">
                                        <img src="{{ asset('img/pemaaf.webp') }}" alt="Avatar"
                                            style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                    </div>
                                    <div class="text ms-2">
                                        <h6 class="user-dropdown-name mb-0">Tamu</h6>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                                    aria-labelledby="topbarUserDropdown">
                                    <li><a class="dropdown-item" wire:navigate href="{{ route('login') }}">Login</a>
                                    </li>
                                    <li><a class="dropdown-item" wire:navigate
                                            href="{{ route('register') }}">Daftar</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-wrapper container">
                {{ $slot }}
            </div>

        </div>
    </div>
    <script src="{{ asset('dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('dist/assets/static/js/pages/horizontal-layout.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dist/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dist/assets/static/js/pages/dashboard.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const navbar = document.getElementById("navbar");
            let theme = localStorage.getItem("theme");

            if (!theme) {
                theme = window.matchMedia("(prefers-color-scheme: dark)").matches ?
                    "dark" :
                    "light";
            }

            const isDark = theme === "dark";


            applyTheme(isDark);
            window.addEventListener("theme-changed", (e) => {
                applyTheme(e.detail === "dark");
            });

            function applyTheme(dark) {
                navbar.style.backgroundColor = "var(--bs-navbar-bg)";
            }

            window.addEventListener("scroll", () => {
                if (window.scrollY > 10) {
                    navbar.style.backgroundColor =
                        "color-mix(in srgb, var(--bs-navbar-bg) 50%, transparent)";
                    navbar.classList.add("backdrop-blur-md");
                } else {
                    navbar.style.backgroundColor = "var(--bs-navbar-bg)";
                    navbar.classList.remove("backdrop-blur-md");
                }
            });
        });
    </script>

</body>

</html>
