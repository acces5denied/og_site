@extends('backend.index')

@section('section')

<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">{{$title}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="text-right form-group">
                    <a href="{{ route('roles.create') }}" class="btn cur-p btn-primary">Создать</a>
                </div>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название</th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach ($roles as $key => $role)
                        <tr>
                            <th scope="row">{{ $role->id }}</th>
                            <td>{{ $role->name }}</td>
                            <td>
                                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'class'=>'text-right  gap-10']) !!}
       
                                    {!! Form::submit('Удалить', ['class' => 'btn cur-p btn-outline-danger']) !!}
                                    {!! Html::link(route('roles.edit', $role->id),'Редактировать',['class'=>'btn cur-p btn-outline-primary']) !!}
                                 
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            {{ $roles->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection