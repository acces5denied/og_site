@extends('backend.index')

@section('section')

<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">{{$title}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">

                <div class="text-right form-group">
                    <a href="{{ route('offers.create') }}" class="btn cur-p btn-primary">Создать</a>
                </div>

                {!! Form::open(['url' => route('offers.index'), 'class'=>'form-row', 'method'=>'GET']) !!}
                <div class="form-group col-md-2">
                    {{ Form::label('search', 'Поиск по ID') }}
                    {!! Form::text('search', null, array('class' => 'form-control')) !!}     
                </div>
                <div class="form-group col-md-2">
                    {{ Form::label('cat', 'Надобъект') }}     
                    {!! Form::select('cat',  $cats, null, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group col-md-2">
                    {{ Form::label('type', 'Тип недвижимости') }}
                    {!! Form::select('type', array('' => 'Не выбрано', 'eliteflat' => 'Квартира', 'apartment' => 'Апартаменты', 'penthouse' => 'Пентхаус', 'townhouse' => 'Таунхаус'), null,  array('class' => 'form-control')) !!}     
                </div>
                <div class="form-group col-md-2">
                    {{ Form::label('exportable', 'Экспортируемость') }}
                    {!! Form::select('exportable', array('' => 'Не выбрано', 'is_export' => 'Циан', 'is_export_ya' => 'Яндекс'), null,  array('class' => 'form-control')) !!}     
                </div>
                
                <div class="form-group col-md-3" style="display: flex; align-items: flex-end;">
                    {{ Form::submit('Применить', array('class' => 'btn btn-light')) }}
                </div>
            
                {{ Form::close() }}

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название</th>
                            <th scope="col">Отделка</th>
                            <th scope="col">Надобъект</th>
                            <th scope="col">Выгрузка</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach($offers as $offer)
                           @if(auth()->user()->hasrole(['admin', 'manager']) || auth()->user()->id === $offer->user_id)
                            <tr {!! $offer->status === 'deactived' ? 'style="background-color: rgba(0,0,0,.05);}"' : '' !!}>
                                <th scope="row">{{ $offer->id }}</th>
                                <td>{{ $offer->name }}</td>
                                <td>
                                    @if (isset($offer->finish))
                                        {{ $offer->finish }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($offer->cat->name))
                                        {{ $offer->cat->name }}
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($offer->is_export))
                                        Циан
                                    @endif
                                    @if (!empty($offer->is_export_ya))
                                        Яндекс
                                    @endif
                                </td>
                                <td>

                                    {!! Form::open(['url' => route('offers.destroy',['offer'=>$offer->id]),'class'=>'text-right  gap-10','method'=>'POST']) !!}

                                    {{ method_field('DELETE') }}

                                    {!! Form::button('Удалить', ['class' => 'btn cur-p btn-outline-danger','type'=>'submit']) !!}

                                    {!! Html::link(route('offers.edit',['offer'=>$offer->id]),'Редактировать',['class'=>'btn cur-p btn-outline-primary']) !!}

                                    {!! Form::close() !!}

                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $offers->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection
