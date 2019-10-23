@extends('backend.index')

@section('section')

<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">{{$title}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
               
                {!! Form::open(['url' => route('subways.index'), 'class'=>'form-row', 'method'=>'GET']) !!}
                <div class="form-group col-md-3">
                    {{ Form::label('city_district', 'Район') }}     
                    {!! Form::select('city_district',  $city_district, null, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group col-md-3" style="display: flex; align-items: flex-end;">
                    {{ Form::submit('Применить', array('class' => 'btn btn-light')) }}
                </div>
            
                {{ Form::close() }}
               
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Метро</th>
                            <th scope="col">Район</th>
                            <th scope="col">Округ</th>
                            <th scope="col">Незаполненные поля</th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach ($subways as $key => $subway)
                        <tr>
                            <td>{{ $subway->city_subway }}</td>
                            <td>{{ $subway->city_district }}</td>
                            <td>{{ $subway->city_area }}</td>
                            <td>
                            @if (is_null($subway->education))
                                <label class="badge badge-warning">образование</label>
                            @endif
                            @if (is_null($subway->infr))
                                <label class="badge badge-warning">инфраструктура</label>
                            @endif
                            @if (is_null($subway->culture))
                                <label class="badge badge-warning">культура</label>
                            @endif
                            @if (is_null($subway->sport))
                                <label class="badge badge-warning">спорт</label>
                            @endif
                            @if (is_null($subway->medical))
                                <label class="badge badge-warning">медицина</label>
                            @endif
                            @if (is_null($subway->advantages))
                                <label class="badge badge-warning">преимущества</label>
                            @endif
                            </td>
                            <td class="text-right">
                               {!! Html::link(route('subways.edit', $subway->id),'Редактировать',['class'=>'btn cur-p btn-outline-primary']) !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            {{ $subways->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection