@extends('backend.index')

@section('section')

<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">{{$title}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="text-right form-group">
                    <a href="{{ route('users.create') }}" class="btn cur-p btn-primary">Создать</a>
                </div>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Пользователь</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Роль</th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach($users as $key => $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                       <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'class'=>'text-right  gap-10']) !!}
                                    
                                    {!! Form::submit('Удалить', ['class' => 'btn cur-p btn-outline-danger']) !!}
                                    {!! Html::link(route('users.edit', $user->id),'Редактировать',['class'=>'btn cur-p btn-outline-primary']) !!}

                                    
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection