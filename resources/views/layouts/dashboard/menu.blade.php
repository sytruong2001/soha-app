<div class="sidebar" data-color="orange" data-image="{{ asset('img/1.png') }}">
    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    <div class="logo">
        <a href="#" class="simple-text logo-mini">
            QL
        </a>

        <a href="#" class="simple-text logo-normal">
            Quản lý
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="info">
                <div class="photo">
                    <img src="{{ asset('img/1.png') }}" />
                </div>

                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                        {{ Auth::user()->name }}
                        <b class="caret"></b>
                    </span>
                </a>

                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Đăng xuất') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                        <li>
                            <a href="admin/info-admin/{{ Auth::user()->id }}">
                                {{ __('Thông tin cá nhân') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            @role('admin')
                <li>
                    <a data-toggle="collapse" href="#chart">
                        <i class="pe-7s-note2"></i>
                        <p>Thống kê
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="chart">
                        <ul class="nav">
                            <li>
                                <a href="admin/new-register-user">
                                    <span class="sidebar-mini">NRU</span>
                                    <span class="sidebar-normal">New register user</span>
                                </a>
                            </li>
                            <li>
                                <a href="admin/daily-active-user">
                                    <span class="sidebar-mini">DAU</span>
                                    <span class="sidebar-normal">Daily active user</span>
                                </a>
                            </li>
                            <li>
                                <a href="admin/revenue">
                                    <span class="sidebar-mini">REV</span>
                                    <span class="sidebar-normal">Revenue</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="admin/account">
                        <i class="pe-7s-graph"></i>
                        <p>Quản lý tài khoản</p>
                    </a>
                </li>
                <li>
                    <a href="admin/account-locked">
                        <i class="pe-7s-graph"></i>
                        <p>Quản lý tài khoản bị khóa</p>
                    </a>
                </li>
                
            @endrole
        </ul>
    </div>
</div>
