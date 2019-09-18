<?php
use Illuminate\Support\Facades\Session;
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #customers td, #customers th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #customers tr:nth-child(even){background-color: #f2f2f2;}

            #customers tr:hover {background-color: #ddd;}

            #customers th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
            }
        </style>

        <script type="text/javascript">
            function sorting(sort){
                $.ajax({
                    type: "GET",
                    url: "/ajaxRequest",
                    data: {
                        sort: sort
                    },
                    success: function (result) {
                        $('.table-lock').html(result).show();
                    },
                    error: function (result) {
                        alert('error');
                    }
                });
            };

            $(document).ready(function () {


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/ajaxRequest",
                    success: function (result) {
                        $('.table-lock').html(result).show();
                    },
                    error: function (result) {
                        alert('error');
                    }
                });

                $("button").click(function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: "GET",
                        url: "/ajaxRequest",
                        data: {
                            page: "<?php if(Session::get('page')!=Session::get('total_pages')) echo Session::get('page')+1; ?>"
                        },
                        success: function (result) {
                            $('.table-lock').html(result).show();
                        },
                        error: function (result) {
                            alert('error');
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
<?php

                ?>

            <div class="content">
                <div class="table-lock">

                </div>
                <?php

                //var_dump($array);
                ?>

                @if(Session::get('page') != Session::get('total_pages'))
                    <button id="button">Read More</button>
                @endif
            </div>

        </div>
    </body>
</html>
