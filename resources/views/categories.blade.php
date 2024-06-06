@extends('master')

@section('title', 'Все категории')

@section('content')
    <div class="starter-template">
        @foreach($categories as $category)
            <div class="panel">
                <a href="{{route('category', $category->code)}}">
                    <img src="/storage/categories/mobile.jpg">
                    <h2>{{$category->name}}</h2>
                </a>
                <p>
                    {{$category->descriptionj}}
                </p>
            </div>
        @endforeach
    </div>
@endsection
