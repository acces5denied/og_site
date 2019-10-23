<div class="header navbar">
    <div class="header-container">
        <ul class="nav-left">
            <li><a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);"><i class="ti-menu"></i></a></li>
            <li class="search-box"><a class="search-toggle no-pdd-right" href="javascript:void(0);"><i class="search-icon ti-search pdd-right-10"></i> <i class="search-icon-close ti-close pdd-right-10"></i></a></li>
            <li class="search-input"><input class="form-control" type="text" placeholder="Search..."></li>
        </ul>
        <ul class="nav-right">

            @if (auth()->user()->unreadnotifications->count())
            <li class="notifications dropdown">
                <span class="counter bgc-red">{{ auth()->user()->unreadnotifications->count() }}</span>
                <a href="" class="dropdown-toggle no-after" data-toggle="dropdown"><i class="ti-bell"></i></a>
                <ul class="dropdown-menu">
                    <li class="pX-20 pY-15 bdB">
                        <i class="ti-bell pR-10"></i> 
                        <span class="fsz-sm fw-600 c-grey-900">Новые заявки</span>
                    </li>
                    <li>
                        <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                            @foreach (auth()->user()->unReadNotifications as $notification)
                            <li>
                                <a href="{{route('emails.index',['email_id'=>$notification->data['email_id']])}}" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                                    <div class="peer peer-greed">
                                    <span>
                                      <span class="fw-500">{{ $notification->data['subject'] }}</span> 
                                    </span>
                                    <p class="m-0"><small class="fsz-xs">{{$notification->created_at}}</small></p>
                                    </div>
                                </a>
                            </li>
                            @endforeach 
                             <li class="pX-20 pY-15 ta-c bdT"><span><a href="{{ route('markRead') }}" class="c-grey-600 cH-blue fsz-sm td-n">Отметить все прочитанными</a></span></li>  
                        </ul>
                    </li>
                </ul>
            </li>
            @endif 

            
            <li class="dropdown">
                <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                    <div class="peer mR-10">
                        @if(!is_null(auth()->user()->photo))
                          <img class="w-2r bdrs-50p" src="/img/{{auth()->user()->photo}}" alt="">
                        @else  
                          <img class="w-2r bdrs-50p" src="/images/avatar.png" alt="">
                        @endif
                        
                        
                    </div>
                </a>
                <ul class="dropdown-menu fsz-sm">
                    <li><a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-settings mR-10"></i> <span>Setting</span></a></li>
                    <li><a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-user mR-10"></i> <span>Profile</span></a></li>
                    <li><a href="email.html" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-email mR-10"></i> <span>Messages</span></a></li>
                    <li role="separator" class="divider"></li>
                    
                    <li>
                        <a class="d-b td-n pY-5 bgcH-grey-100 c-grey-700" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti-power-off mR-10"></i> <span>Выйти</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>


