@extends('backend.index')

@section('section')

<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">{{$title}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">

                {!! Form::open(['url' => route('xml_offers.index'), 'class'=>'form-row', 'method'=>'GET']) !!}
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
                <div class="form-group col-md-2">
                    {{ Form::label('publish_terms', 'Размещения на ЦИАН') }}
                    {!! Form::select('publish_terms', array('' => 'Не выбрано', 'free' => 'Бесплатное', 'paid' => 'Платное', 'highlight' => 'Выделение цветом', 'premium' => 'Премиум', 'top3' => 'Топ 3'), null,  array('class' => 'form-control')) !!}     
                </div>
                <div class="form-group col-md-2" style="display: flex; align-items: flex-end;">
                    {{ Form::submit('Применить', array('class' => 'btn btn-light', 'style' => 'width: 100%;')) }}
                </div>
                {{ Form::close() }}

				{!! Form::open(['url' => route('xml_offers.update'), 'class'=>'col-sm-12 pT-10 mT-30 mB-10 bgc-blue-100', 'method'=>'POST']) !!} 
				{!! Form::hidden('_method', 'patch') !!} 
				{!! Form::hidden('offers_id') !!}
                <div class="form-row">
					<div class="form-group col-md-2 checkbox checkbox-circle checkbox-info peers">
                        {{Form::hidden('is_export',0)}}
                        {{ Form::checkbox('is_export', 1, false, array('class' => 'peer', 'id' => 'is_export')) }}
                        {{ Form::label('is_export', 'Выгружать в Cian') }}   
                    </div>
                    <div class="form-group col-md-2 checkbox checkbox-circle checkbox-info peers">
                        {{Form::hidden('is_export_ya',0)}}
                        {{ Form::checkbox('is_export_ya', 1, false, array('class' => 'peer', 'id' => 'is_export_ya')) }}
                        {{ Form::label('is_export_ya', 'Выгружать в Яндекс') }}   
                    </div>
					<div class="form-group col-md-2">
						{{ Form::label('publish_terms', 'Размещения на ЦИАН') }}
						{!! Form::select('publish_terms', array('' => 'Не выбрано', 'free' => 'Бесплатное', 'paid' => 'Платное', 'highlight' => 'Выделение цветом', 'premium' => 'Премиум', 'top3' => 'Топ 3'), null,  array('class' => 'form-control')) !!}     
					</div>
					<div class="form-group col-md-2">
                         {{ Form::label('bet', 'Ставка на ЦИАН') }} 
                         {{ Form::text('bet', null, array('class'=>'form-control')) }}
                    </div>
					<div class="form-group col-md-2" style="display: flex; align-items: flex-end;">
						{{ Form::submit('Сохранить', array('class' => 'btn btn-light', 'style' => 'width: 100%;')) }}
					</div>
                </div>
				{{ Form::close() }}
                

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">src ID</th>
                            <th scope="col">Название</th>
                            <th scope="col">Надобъект</th>
                            <th scope="col">Выгрузка</th>
                            <th scope="col">Размещения на ЦИАН</th>
                            <th scope="col">Ставка на ЦИАН</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach($offers as $offer)
                           @if(auth()->user()->hasrole(['admin', 'manager']) || auth()->user()->id === $offer->user_id)
                           	{!! Form::open(['url' => route('xml_offers.update'), 'method'=>'POST']) !!} 
							{!! Form::hidden('_method', 'patch') !!} 
							{!! Form::hidden('id', $offer->id) !!}
                           
                            <tr {!! $offer->status === 'deactived' ? 'style="background-color: rgba(0,0,0,.05);}"' : '' !!}>
                                <th scope="row" style="display: flex; align-items: center;">
									{{ Form::checkbox('is_select[]', $offer->id, false, array('class' => 'mR-5')) }}
									{{ $offer->id }}
                                </th>
                                <td>{{ $offer->src_lot }}</td>
                                <td>{{ $offer->name }}</td>
                                <td>
                                    @if (isset($offer->cat->name))
                                        {{ $offer->cat->name }}
                                    @endif
                                </td>
                                <td>
                                    <div class="checkbox checkbox-circle checkbox-info peers mL-5">
									   {{Form::hidden('is_export',0)}}
									   @if($offer->is_export)
									   		<input name="is_export" type="checkbox" checked class="peer" id="is_export_{{$offer->id}}" value="1">
									   @else
									   		<input name="is_export" type="checkbox" class="peer" id="is_export_{{$offer->id}}" value="1">
									   @endif
									   {{ Form::label('is_export_'.$offer->id, 'ЦИАН') }}    
								   </div>
								   <div class="checkbox checkbox-circle checkbox-info peers mL-5 mT-10">
									   {{Form::hidden('is_export_ya',0)}}
									   @if($offer->is_export_ya)
									   		<input name="is_export_ya" type="checkbox" checked class="peer" id="is_export_ya_{{$offer->id}}" value="1">
									   @else
									   		<input name="is_export_ya" type="checkbox" class="peer" id="is_export_ya_{{$offer->id}}" value="1">
									   @endif
									   {{ Form::label('is_export_ya_'.$offer->id, 'Яндекс') }}    
								   </div>
                                </td>
                                <td>
                                    {!! Form::select('publish_terms', array('free' => 'Бесплатное', 'paid' => 'Платное', 'highlight' => 'Выделение цветом', 'premium' => 'Премиум-объявление', 'top3' => 'Топ 3'), $offer->publish_terms,  array('class' => 'form-control')) !!}
                                </td>
                                <td>
                                    {{ Form::text('bet', $offer->bet, array('class'=>'form-control')) }}
                                </td>
                                <td>
									{{ Form::submit('Сохранить', array('class' => 'btn btn-light')) }}
                                </td>
                            </tr>
                            {{ Form::close() }}
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $offers->appends(request()->input())->links() }}
        </div>
    </div>
</div>

<script> 
$(document).ready(function(){
	function Populate(){
		vals = $('input[name="is_select[]"]:checked').map(function() {
			return this.value;
		}).get().join(',');
		console.log(vals);
		$('input[name="offers_id"]').val(vals);
	}

	$('input[name="is_select[]"]').on('change', function() {
		Populate()
	}).change();
});
</script>

@endsection
