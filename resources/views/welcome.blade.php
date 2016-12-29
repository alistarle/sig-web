<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tableau de bord SIG</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            table {
                border-collapse: collapse;
            }

            table td, table th{
                border-left: 1px solid #000;
                border-right: 1px solid #000;
                padding: 0 5px;
            }

            table td:first-child, table th:first-child{
                border-left: none;
            }

            table td:last-child, table th:last-child{
                border-right: none;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Liste des devices
                </div>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            @foreach($hunts as $hunt)
                                <th>{{ $hunt->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($devices as $device)
                            <tr><td>{{$device->model}}<small> ( {{ \Carbon\Carbon::parse($device->created_at)->diffForHumans() }} ) </small></td>
                                @foreach($hunts as $hunt)
                                    @if($device->hunts->contains($hunt))
                                        <td>V</td>
                                    @elseif($device->hunt == $hunt)
                                        <td>{{ $device->step }}</td>
                                    @else
                                        <td>X</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </body>
</html>
