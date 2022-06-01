<!DOCTYPE html>
<html lang="en" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8" />
    <style>
        @media screen,
        print {
            * {
                -webkit-print-color-adjust: exact;
                font-family: "cairo", Times, serif;
            }

            table {
                font-family: 'cairo', sans-serif;
                width: 100%;
            }

            h3 {
                font-weight: bold
            }

            table th {
                text-align: right !important;
                padding: 15px
            }

            .active {
                color: #04A777
            }

            .unactive {
                color: #e23e3d
            }

            table {
                border-collapse: collapse;
            }

            table th {
                border: 1px solid #f3f3f3 !important;
            }

            table td {
                padding: 15px
            }

            .header {
                width: 100%;
                position: relative;
            }

            .logo {
                width: 10px;
            }

            img {
                border-radius: 10px !important
            }

            .title {
                width: 50%;
                display: block;
                float: left;
            }
        }

    </style>
</head>

<body class="app sidebar-mini {{ LaravelLocalization::getCurrentLocaleDirection() }}">

    @yield('content')

</body>

</html>
