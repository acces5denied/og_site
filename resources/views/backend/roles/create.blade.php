@extends('backend.index') 
@section('section')
    
{!! Form::open(['url' => route('roles.store'), 'class'=>'row', 'method'=>'POST']) !!}
 
<div class="col-sm-12 form-row mT-10 mB-10">
    <h4 class="col-sm-6 c-grey-900">{{$title}}</h4>
    <div class="text-right col-sm-6">
       
        {!! Html::link(route('roles.index'),'Вернуться к списку',['class'=>'btn cur-p btn-secondary']) !!}
        {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        
    </div>
</div>

<div class="col-sm-12 mT-20">

        <div class="form-row">
            <div class="col-md-6" >
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-group">
                            {{ Form::label('name', 'Название') }}
                            {{ Form::text('name', null, array('class'=>'form-control')) }}  
                        </div>
                        
                        <div class="form-group">
                            <strong>Разрешения:</strong>

                            @foreach($permission as $k=>$value)
                               <div class="checkbox checkbox-circle checkbox-info peers mT-10">
                                   {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'peer', 'id' => $value->id)) }}
                                   {{ Form::label($value->id, $value->name) }}    
                               </div>
                            @endforeach
                        </div>           
                    </div>
                </div>
            </div>


</div>

{!! Form::close() !!}


@endsection
