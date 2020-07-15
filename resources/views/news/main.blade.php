<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

        .content {
            text-align: center;
        }
        .block {
            margin: 0 auto;
            width: 40%;
        }
        .block .title {
            font-size: 24px;
        }

        .block .body {
            text-align: justify;
        }

        .title {
            font-size: 56px;
        }

        .links {
           margin: 25px 0;
        }

        .links > a {
            color: #636b6f;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="content">
    <div class="title m-b-md">
        News
    </div>
    @foreach($news as $post)
        <div class="block m-b-md">
            <div class="title">{{$post->title}}</div>
            <div class="body">{{$post->subtitle}}</div>
            <div class="links">
                <a href="{{route('post.show', ['id' => $post->id])}}">Подробнее</a>
            </div>
            <hr />
        </div>
    @endforeach
</div>
</body>
</html>
