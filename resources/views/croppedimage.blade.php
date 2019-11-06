<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    @php
    $img = Image::make('https://cdn.pixabay.com/photo/2016/10/09/18/03/smile-1726471_960_720.jpg');
    @endphp
    <body>
       <div>
            <div class="row">
                <div class="col-sm-3"><img src="{{ $img->fit(500, 300)->response() }}"></div>
                <div class="col-sm-3"><img src="{{ $img->fit(100, 100)->response() }}"></div>
                <div class="col-sm-3"><img src="{{ $img->fit(200, 100)->response() }}"></div>
                <div class="col-sm-3"><img src="{{ $img->fit(20, 20)->response() }}"></div>
            </div> 
       </div>
    </body>
</html>
