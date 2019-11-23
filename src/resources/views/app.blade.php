<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{!! trans('ModelEventLogger::model-event-logger.dashboard.title') !!} - {{config('app.name')}}</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
<div class="container">
    <hr>
        <h3>Filters</h3>
        <form class="row" action="" role="form" method="get">
        <div class="col-md-4">
        <div class='col-md'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='datetime-local' name="created_before" placeholder="Created Before" class="form-control" />
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
        </div>
        <div class='col-md'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker2'>
                    <input type='datetime-local' name="created_after" placeholder="Created After" class="form-control" />
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class='col-md'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker3'>
                    <input type='datetime-local' name="reverted_before" placeholder="Reverted Before" class="form-control" />
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
        </div>
        <div class='col-md'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker4'>
                    <input type='datetime-local' name="reverted_after" placeholder="Reverted After" class="form-control" />
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class='col-md'>
            <div class="form-group">
                <select name="action" class="form-control select">
                    <option value="">-- Select Action --</option>
                    @foreach($modelActions as $action)
                        <option value="{{$action}}">{{ucwords($action)}}</option>
                    @endforeach
                </select>

                </div>
            </div>
        <div class='col-md'>
            <div class="form-group">
                Total: {{$modelLogs->total()}}

                </div>
            </div>

        </div>
        <div class="col-md-12 row">
        <div class='col-md-6'>
            <div class="form-group">
                <button class="btn btn-success btn-block" type="submit">Apply Filters</button>

            </div>
            </div>
        <div class='col-md-6'>
            <div class="form-group">
               <a href="{{url('model-events')}}" class="btn btn-warning btn-block">Reset Filters</a>

            </div>
        </div>
        </div>
        </form>

    <div class="row">
    @yield('content')
    </div>
</div>
    </main>

<script>
    $(function () {
        $('#datetimepicker1').datetimepicker();
        $('#datetimepicker2').datetimepicker();
        $('#datetimepicker3').datetimepicker();
        $('#datetimepicker4').datetimepicker();
    });
</script>
    @yield('scripts')
</div>
</body>
</html>

