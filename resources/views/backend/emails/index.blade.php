@extends('backend.index') @section('section')

<div class="full-container">
    <div class="email-app">
        <div class="email-side-nav remain-height ov-h">
            <div class="h-100 layers">

                <div class="scrollable pos-r bdT layer w-100 fxg-1">
                    <ul class="p-20 nav flex-column">
                        <li class="nav-item">
                            <a href="{{route('emails.index',['status'=>'callme'])}}" class="nav-link c-grey-800 cH-blue-500 active">
                                <div class="peers ai-c jc-sb">
                                    <div class="peer peer-greed"><i class="mR-10 ti-email"></i> <span>Заказ звонка</span></div>
                                    <div class="peer">
                                        <span class="badge badge-pill bgc-blue-50 c-blue-700">{{$counter->where('status', 'callme')->count()}}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('emails.index',['status'=>'view'])}}" class="nav-link c-grey-800 cH-blue-500">
                                <div class="peers ai-c jc-sb">
                                    <div class="peer peer-greed"><i class="mR-10 ti-email"></i> <span>Просмотр</span></div>
                                    <div class="peer">
                                        <span class="badge badge-pill bgc-blue-50 c-blue-700">{{$counter->where('status', 'view')->count()}}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('emails.index',['status'=>'price'])}}" class="nav-link c-grey-800 cH-blue-500">
                                <div class="peers ai-c jc-sb">
                                    <div class="peer peer-greed"><i class="mR-10 ti-email"></i> <span>Запрос цены</span></div>
                                    <div class="peer">
                                        <span class="badge badge-pill bgc-blue-50 c-blue-700">{{$counter->where('status', 'price')->count()}}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('emails.index',['status'=>'plan'])}}" class="nav-link c-grey-800 cH-blue-500">
                                <div class="peers ai-c jc-sb">
                                    <div class="peer peer-greed"><i class="mR-10 ti-email"></i> <span>Планировка</span></div>
                                    <div class="peer">
                                        <span class="badge badge-pill bgc-blue-50 c-blue-700">{{$counter->where('status', 'plan')->count()}}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('emails.index',['status'=>'subscribe'])}}" class="nav-link c-grey-800 cH-blue-500">
                                <div class="peers ai-c jc-sb">
                                    <div class="peer peer-greed"><i class="mR-10 ti-email"></i> <span>Подписка</span></div>
                                    <div class="peer">
                                        <span class="badge badge-pill bgc-blue-50 c-blue-700">{{$counter->where('status', 'subscribe')->count()}}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="email-wrapper row remain-height bgc-white ov-h">
           {!! Form::open(['url' => route('emails.destroy'), 'class'=>'email-list h-100 layers', 'id'=>'email_status_form', 'method'=>'POST']) !!}
                <div class="layer w-100">
                    <div class="bgc-grey-100 peers ai-c jc-sb p-20 fxw-nw">
                        <div class="peer">
                            <div class="btn-group" role="group">
                                <button type="button" class="email-side-toggle d-n@md+ btn bgc-white bdrs-2 mR-3 cur-p"><i class="ti-menu"></i></button>
                                <div class="btn-group" role="group">
                                   <button id="btnGroupDrop1" type="button" class="btn cur-p bgc-white no-after dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <i class="ti-more-alt"></i>
                                   </button>
                                    <ul class="dropdown-menu fsz-sm" aria-labelledby="btnGroupDrop1">
                                        <li>
                                            <label for="status_inbox" class="cur-p d-b mB-0 td-n pY-5 pX-10 bgcH-grey-100 c-grey-700">
                                                <i class="ti-trash mR-10"></i>
                                                <span>Удалить</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="peer">
                            {{ $emails->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>

                <div class="layer w-100 fxg-1 scrollable pos-r">
                    <div class="">
                        @foreach($emails as $email)
                            
                            <div class="peers fxw-nw p-20 bdB bgcH-grey-100 cur-p class_alert
                            
                            
                            @foreach (auth()->user()->unReadNotifications as $notification)
                                @if ($notification->data['email_id'] === $email->id)
                                bgc-green-50
                                @endif
                            @endforeach
                            
                            
                            ">
                            <div class="peer mR-10">
                                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                                    <input type="checkbox" id="email_{{$email->id}}" name="email_id[]" class="peer" value="{{$email->id}}"> <label for="email_{{$email->id}}" class="peers peer-greed js-sb ai-c"></label>
                                </div>
                            </div>

                            <div class="email-list-item  peer peer-greed ov-h email-click"  data-id="{{ $email->id }}">
                                <div class="peers ai-c">
                                    <div class="peer peer-greed">
                                        <h6>{{ $email->name }}</h6>
                                    </div>
                                    <div class="peer"><small>{{ $email->created_at }}</small></div>
                                </div>
                                <h5 class="fsz-def tt-c c-grey-900">{{ $email->subject }}</h5>
                                @if (isset($email->text))
                                    <span class="whs-nw w-100 ov-h tov-e d-b">
                                        {{ $email->text }}
                                    </span> 
                                @endif
                            </div>

                        </div>
                        @endforeach
                    </div>
                    
                </div>
                
            {{ Form::close() }}
            <div class="email-content h-100">
                <div class="h-100 scrollable pos-r">
                    <div class="bgc-grey-100 peers ai-c jc-sb p-20 fxw-nw d-n@md+">
                        <div class="peer">
                            <div class="btn-group" role="group">
                                <button type="button" class="back-to-mailbox btn bgc-white bdrs-2 mR-3 cur-p"><i class="ti-angle-left"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="email-content-wrapper" id="email-content">
                        @if($emails->count() > 0)
                            @include('backend.emails.show')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document.body).on('click', 'label.bgcH-grey-100', function(e) {
        $('#email_status_form').submit();
    });
    
    $(function() {
        $(document.body).on('click', '.email-click', function(e) {
            $('.class_alert').removeClass('bgc-blue-50');
            $(this).closest('.class_alert').removeClass('bgc-green-50');
            $(this).closest('.class_alert').addClass('bgc-blue-50');
            var id = $(this).attr('data-id');
            var _token = $("input[name='_token']").val();
            $.ajax({
	            url: '/backend/emails/'+id,
	            type:'GET',
//	            data: {_token:_token, id:id},
	            success: function(email) {
	                $('#email-content').html(email);
	            }
	        });
        });
    })
</script>

@endsection
