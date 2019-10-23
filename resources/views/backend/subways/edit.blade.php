@extends('backend.index') 
@section('section')

{!! Form::open(['url' => route('subways.update',array('subway'=>$data['id'])), 'class'=>'row', 'method'=>'POST']) !!} 
{!! Form::hidden('_method', 'patch') !!} 
{!! Form::hidden('id', $data['id']) !!}
 
<div class="col-sm-12 form-row mT-10 mB-10">
    <h4 class="col-sm-6 c-grey-900">{{$title}}</h4>
    <div class="text-right col-sm-6">
       
        {!! Html::link(route('subways.index'),'Вернуться к списку',['class'=>'btn cur-p btn-secondary']) !!}
        {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        
    </div>
</div>

<div class="col-sm-12 mT-20">
    <div class="bgc-white p-20 bd">
        <div class="mT-30">
            <div class="form-row">
                <div class="form-group col-md-4">
                    {{ Form::label('city_subway', 'Метро') }}
                    <div class="form-control">{{ $subway->city_subway }}</div>
                </div>
                <div class="form-group col-md-4">
                    {{ Form::label('city_subway', 'Район') }}
                    <div class="form-control">{{ $subway->city_district }}</div>
                </div>
                <div class="form-group col-md-4">
                    {{ Form::label('city_subway', 'Округ') }}
                    <div class="form-control">{{ $subway->city_area }}</div>
                </div>
            </div>          
        </div>
    </div>
</div>

<div class="col-sm-12 mT-20">
    <div class="bgc-white p-20 bd">
        <div class="mT-30">
            <div class="form-row">
                <div class="form-group col-md-6">
                    {{ Form::label('education', 'Образование') }}
                    {{ Form::textarea('education', $data['education'], array('class'=>'form-control')) }}
                </div>
                <div class="form-group col-md-6">
                    {{ Form::label('infr', 'Инфраструктура') }}
                    {{ Form::textarea('infr', $data['infr'], array('class'=>'form-control')) }}
                </div>
            </div>          
        </div>
        <div class="mT-30">
            <div class="form-row">
                <div class="form-group col-md-6">
                    {{ Form::label('culture', 'Культура') }}
                    {{ Form::textarea('culture', $data['culture'], array('class'=>'form-control')) }}
                </div>
                <div class="form-group col-md-6">
                    {{ Form::label('sport', 'Спорт') }}
                    {{ Form::textarea('sport', $data['sport'], array('class'=>'form-control')) }}
                </div>
            </div>          
        </div>
        <div class="mT-30">
            <div class="form-row">
                <div class="form-group col-md-6">
                    {{ Form::label('medical', 'Медицина') }}
                    {{ Form::textarea('medical', $data['medical'], array('class'=>'form-control')) }}
                </div>
                <div class="form-group col-md-6">
                    {{ Form::label('advantages', 'Преимущества') }}
                    {{ Form::textarea('advantages', $data['advantages'], array('class'=>'form-control')) }}
                </div>
            </div>          
        </div>
    </div>
</div>

{!! Form::close() !!}


@endsection
