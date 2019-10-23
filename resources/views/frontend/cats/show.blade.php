@extends('layouts.site')

@section('header')

    @include('frontend.cats.header_show')

@endsection

@section('content')

    @include('frontend.cats.content_show')
    @include('frontend.cats.similar')

@endsection

@section('footer')

    @include('frontend.footer')
    
@endsection

@section('scripts')

    @include('frontend.cats.scripts')
    
@endsection