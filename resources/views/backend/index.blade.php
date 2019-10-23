@extends('layouts.admin')


@section('sidebar')

    @include('backend.sidebar')  

@endsection

@section('content')

    <div class="page-container">  
      
        @include('backend.header')

        <main class="main-content bgc-grey-100">
            <div id="mainContent">
              
               @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                
                @yield('section')
            </div>
        </main>

        @include('backend.footer')
    
    </div>

@endsection