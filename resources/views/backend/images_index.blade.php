@extends('backend.index')

@section('section')

<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">{{$title}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">

                <div class="text-right form-group">
                    <a href="{{ route('images.create') }}" class="btn cur-p btn-primary">Создать</a>
                </div>
                
                
                @if($images)
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Изображение</th>
                            <th scope="col">Метка</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach($images as $image)
                        <tr>
                            <th scope="row">{{ $image->id }}</th>
                            <td><img src="{{ asset('upload/'.$image->url) }}"></td>
                            <td>{{ $image->tag }}</td>
                            <td>


                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @endif
            </div>
            {{ $images->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection