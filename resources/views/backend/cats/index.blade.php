@extends('backend.index')

@section('section')

<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">{{$title}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                @can('product-create')
                <div class="text-right form-group">
                    <a href="{{ route('cats.create') }}" class="btn cur-p btn-primary">Создать</a>
                </div>
                @endcan
                
                @if($cats)
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название</th>
                            <th scope="col">Кол-во лотов</th>
                            <th scope="col">Метро</th>
                            <th scope="col">Район</th>
                            <th scope="col">Округ</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach($cats as $cat)
                        <tr>
                            <th scope="row">{{ $cat->id }}</th>
                            <td>{{ $cat->name }}</td>
                            <td>{{ $cat->offers->count() }}</td>
                            <td>
                                @if (isset($cat->subway->city_subway))
                                    {{ $cat->subway->city_subway }}
                                @endif
                            </td>
                            <td>
                                @if (isset($cat->subway->city_district))
                                    {{ $cat->subway->city_district }}
                                @endif
                            </td>
                            <td>
                                @if (isset($cat->subway->city_area))
                                    {{ $cat->subway->city_area }}
                                @endif
                            </td>
                            <td>
                                
                                {!! Form::open(['url' => route('cats.destroy',['cat'=>$cat->id]),'class'=>'text-right  gap-10','method'=>'POST']) !!}
                                
                                {{ method_field('DELETE') }}
                                
                                {!! Form::button('Удалить', ['class' => 'btn cur-p btn-outline-danger','type'=>'submit']) !!}
                                
                                {!! Html::link(route('cats.edit',['cat'=>$cat->id]),'Редактировать',['class'=>'btn cur-p btn-outline-primary']) !!}
                                
                                {!! Form::close() !!}

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @endif
            </div>
            {{ $cats->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection