<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>+</b>Col</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <img src="{{ asset('img/truck-mark.png') }}" style="margin-right: 15px;" height="35" width="40">
            <b>+</b>Coleta
        </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" style="height:50px" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ asset('img/user-icon.png') }}" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{-- Auth::user()->nome --}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset('img/user-icon.png') }}" class="img-circle" alt="User Image">
                            <p>
                                {{ Auth::user()->nome }} | {{ Auth::user()->role()->first()->nome }}
                                <small>{{ Auth::user()->email }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ url('usuario/perfil') }}" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ url('auth/logout') }}" class="btn btn-default btn-flat">Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-cogs"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>