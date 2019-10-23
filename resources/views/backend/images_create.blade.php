@extends('backend.index') 

@section('section')

<div class="row gap-20 masonry pos-r">
    
{!! Form::open(['url' => route('images.store'), 'method'=>'POST','enctype'=>'multipart/form-data']) !!}
    
     <div class="masonry-item col-sm-12 form-row mT-10 mB-10">
        <h4 class="col-sm-6 c-grey-900">{{$title}}</h4>
        <div class="text-right col-sm-6">
        
            {!! Html::link(route('images.index'),'Вернуться к списку',['class'=>'btn cur-p btn-secondary']) !!}

            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}

        </div>
    </div>   
    
    <div class="masonry-sizer col-md-6"></div>
    <div class="masonry-item col-md-6">
        <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Информация об объекте</h6>
            <div class="mT-30">

                    
                    <div class="form-group">

                        
                        <input id="img" type="file" multiple name="url[]">

                    </div>
                    <div class="form-group">
                        {{ Form::label('tag', 'Метка') }}
                        {!! Form::select('tag',  $tag, null, array('class' => 'form-control')) !!}
                    </div>


            </div>
        </div>
    </div>

{!! Form::close() !!}



</div>

@endsection