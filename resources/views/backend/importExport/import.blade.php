@extends('backend.index') 
@section('section')

<div class="row">    

    
<div class="col-sm-12 form-row mT-10 mB-10">
    <h4 class="col-sm-6 c-grey-900">{{$title}}</h4>
</div>

{!! Form::open(['url' => route('import.offers'), 'class'=>'col-md-6 mT-20', 'method'=>'POST','enctype'=>'multipart/form-data']) !!}
    <div class="form-row bgc-white bd">
        <div class="col-sm-12 p-20">
            <h6 class="c-grey-900 mB-20">Объекты</h6>
            <div class="form-row"> 
                <div class="form-group col-md-6">
                    {{ Form::file('file', array('class'=>'')) }}  
                </div>
                <div class="form-group col-md-6">
                    {{ Form::submit('Импорт', array('class' => 'btn btn-primary')) }}
                </div>
                <div class="form-group col-md-12 mT-30">
                    <a class="btn btn-warning" href="{{ route('export.offers') }}">Экспорт объектов</a>
                </div>
            </div>         
        </div>
    </div>
{!! Form::close() !!}  

{!! Form::open(['url' => route('import.cats'), 'class'=>'col-md-6 mT-20', 'method'=>'POST','enctype'=>'multipart/form-data']) !!}
    <div class="form-row bgc-white bd">
        <div class="col-sm-12 p-20">
            <h6 class="c-grey-900 mB-20">Надобъекты</h6>
            <div class="form-row"> 
                <div class="form-group col-md-6">
                    {{ Form::file('file', array('class'=>'')) }}  
                </div>
                <div class="form-group col-md-6">
                    {{ Form::submit('Импорт', array('class' => 'btn btn-primary')) }}
                </div>
                <div class="form-group col-md-12 mT-30">
                    <a class="btn btn-warning" href="{{ route('export.cats') }}">Экспорт надобъектов</a>
                </div>
            </div>         
        </div>
    </div>
{!! Form::close() !!}   




</div>
@endsection