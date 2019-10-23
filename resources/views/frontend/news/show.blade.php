@extends('layouts.site')

@section('header')

    @include('frontend.news.header_show')

@endsection

@section('content')

    @include('frontend.news.content_show')
    @include('frontend.news.similar')

@endsection

@section('footer')

    @include('frontend.footer')
    
@endsection