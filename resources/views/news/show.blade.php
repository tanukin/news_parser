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

        .m-b-md {
            margin-bottom: 30px;
        }

        .data span {
            padding-left: 5%;
        }

        img {
            display: inline-block;
            width: 100%;
        }

    </style>
</head>
<body>
<div class="content">
    <div class="title m-b-md">
        <a href="{{route('news')}}">News</a>
    </div>

    <div class="block m-b-md">
        <div class="title">{{$post->title}}</div>
        <div class="data m-b-md">
            <span>Категория: {{$post->category}}</span>
            <span>Дата публикации: {{\Carbon\Carbon::createFromTimestamp($post->publish_date_at)->format('d.m.Y H:i')}}</span>
            <span>Источник: <a href="{{$post->source_link}}" target="_blank">rbc</a></span>
        </div>
        @if($post->subtitle)
            <div class="body">{{$post->subtitle}}</div>
        @endif
        @if($post->picture)
            <div class="m-b-md"><img src="{{\Illuminate\Support\Facades\Storage::disk(\App\Core\News\Models\News::STORAGE)->url($post->picture)}}"></div>
        @endif
        <div class="body">{{$post->text}}</div>
    </div>

</div>
</body>
</html>
