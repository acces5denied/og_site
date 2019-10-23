@extends('backend.index')

@section('section')

<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">{{$title}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                @can('product-create')
                <div class="text-right form-group">
                    <a href="{{ route('banners.create') }}" class="btn cur-p btn-primary">Создать</a>
                </div>
                @endcan
                
                @if($banners)
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Название</th>
                            <th scope="col">Блок</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach($banners as $banner)
                        <tr>
                            <td>{{ $banner->name }}</td>
                            <td><img src="/images/svg/{{ $banner->block }}.svg" alt=""></td>
                            <td>
                                
                                {!! Form::open(['url' => route('banners.destroy',['banner'=>$banner->id]),'class'=>'text-right  gap-10','method'=>'POST']) !!}
                                
                                {{ method_field('DELETE') }}
                                
                                {!! Form::button('Удалить', ['class' => 'btn cur-p btn-outline-danger','type'=>'submit']) !!}
                                
                                {!! Html::link(route('banners.edit',['banner'=>$banner->id]),'Редактировать',['class'=>'btn cur-p btn-outline-primary']) !!}
                                
                                {!! Form::close() !!}

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @endif
            </div>
            {{ $banners->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection