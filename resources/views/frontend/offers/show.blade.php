@extends('layouts.site')

@section('header')

    @include('frontend.offers.header_show')

@endsection

@section('content')

    @include('frontend.offers.content_show')
    @include('frontend.offers.similar')

@endsection

@section('footer')

    @include('frontend.footer')
    
@endsection

@section('scripts')

    @include('frontend.offers.scripts')
    
@endsection
