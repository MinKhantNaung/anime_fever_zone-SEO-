<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>

<body>
    <div style="text-align: center">
        <img src="{{ $message->embed(asset('favicon.ico')) }}" alt="anime_fever_zone_logo" style="width: 200px; height: 200px;">
    </div>
    <p>{!! $body !!}</p>
</body>

</html>
