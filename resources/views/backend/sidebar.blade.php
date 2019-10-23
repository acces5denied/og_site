<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
                <div class="peer peer-greed">
                    <a class="sidebar-link td-n" href="index.html">
                        <div class="peers ai-c fxw-nw">
                            <div class="peer">
                                <div class="logo"><img src="assets/static/images/logo.png" alt=""></div>
                            </div>
                            <div class="peer peer-greed">
                                <h5 class="lh-1 mB-0 logo-text">Перейти на сайт</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="peer">
                    <div class="mobile-toggle sidebar-toggle"><a href="" class="td-n"><i class="ti-arrow-circle-left"></i></a></div>
                </div>
            </div>
        </div>
        <ul class="sidebar-menu scrollable pos-r">

            <li class="nav-item mT-30">
                <a href="{{ route('offers.index') }}" class="sidebar-link">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-files"></i> 
                    </span>
                    <span class="title">Объекты</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('xml_offers.index') }}" class="sidebar-link">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-files"></i> 
                    </span>
                    <span class="title">Выгрузка</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cats.index') }}" class="sidebar-link">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-folder"></i> 
                    </span>
                    <span class="title">Надобъекты</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('subways.index') }}" class="sidebar-link">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-direction-alt"></i> 
                    </span>
                    <span class="title">Инфраструктура</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('banners.index') }}" class="sidebar-link">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-layout-slider"></i> 
                    </span>
                    <span class="title">Баннеры</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('posts.index') }}" class="sidebar-link">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-pencil-alt"></i> 
                    </span>
                    <span class="title">Статьи</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('emails.index', ['status' => 'callme']) }}" class="sidebar-link">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-email"></i> 
                    </span>
                    <span class="title">Заявки</span>
                </a>
            </li>
            @role('admin')
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="sidebar-link">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-user"></i> 
                    </span>
                    <span class="title">Пользователи</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="sidebar-link">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-panel"></i> 
                    </span>
                    <span class="title">Роли</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('importExportView') }}" class="sidebar-link">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-import"></i> 
                    </span>
                    <span class="title">Import/Export</span>
                </a>
            </li>
            @endrole
          
        </ul>
    </div>
</div>
