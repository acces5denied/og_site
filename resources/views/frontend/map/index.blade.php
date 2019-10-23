@extends('layouts.site')

@section('header')

    @include('frontend.map.header_index')

@endsection

@section('content')

    @include('frontend.map.content_index')

@endsection

@section('footer')

    @include('frontend.footer')
    
@endsection

@section('scripts')

    @include('frontend.map.scripts')
    
@endsection