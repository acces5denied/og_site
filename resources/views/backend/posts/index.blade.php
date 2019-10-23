@extends('backend.index')

@section('section')

<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">{{$title}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                @can('product-create')
                <div class="text-right form-group">
                    <a href="{{ route('posts.create') }}" class="btn cur-p btn-primary">Создать</a>
                </div>
                @endcan
                
                @if($posts)
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Название</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Дата публикации</th>
                            <th scope="col">Дата обновления</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->name }}</td>
                            <td>
                                @if($post->status==='published')
                                    <label class="badge badge-success">опубликованно</label>
                                @endif
                                @if($post->status==='draft')
                                    <label class="badge badge-secondary">черновик</label>
                                @endif
                            </td>
                            <td>{{ $post->created_at }}</td>
                            <td>{{ $post->updated_at }}</td>
                            <td>
                                
                                {!! Form::open(['url' => route('posts.destroy',['post'=>$post->id]),'class'=>'text-right  gap-10','method'=>'POST']) !!}
                                
                                {{ method_field('DELETE') }}
                                
                                {!! Form::button('Удалить', ['class' => 'btn cur-p btn-outline-danger','type'=>'submit']) !!}
                                
                                {!! Html::link(route('posts.edit',['post'=>$post->id]),'Редактировать',['class'=>'btn cur-p btn-outline-primary']) !!}
                                
                                {!! Form::close() !!}

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @endif
            </div>
            {{ $posts->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection