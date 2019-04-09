<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        {{--<div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle-o text-success"></i> Online</a>
            </div>
        </div>--}}

        {{--<!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <!--<li class="active">-->
            <li>
                <a href="{{ action('ColetaController@index')  }}">
                    <i class="fa fa-circle-o"></i>
                    <span>Coleta</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-circle-o"></i>
                    <span>Rotas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ action('RotaController@index')  }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Rota</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('PontoColetaController@index')  }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Pontos de Coleta</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ action('TipoResiduoController@index')  }}">
                    <i class="fa fa-circle-o"></i>
                    <span>Tipo de Res&iacute;do</span>
                </a>
            </li>
            <li>
                <a href="{{ action('TriagemController@index')  }}">
                    <i class="fa fa-circle-o"></i>
                    <span>Triagem</span>
                </a>
            </li>
            <li>
                <a href="{{ action('UsuarioController@index')  }}">
                    <i class="fa fa-circle-o"></i>
                    <span>Usu&aacute;rio</span>
                </a>
            </li>
            <li>
                <a href="{{ action('VeiculoController@index')  }}">
                    <i class="fa fa-circle-o"></i>
                    <span>Veiculo</span>
                </a>
            </li>
            <!--<li class="treeview">
                <a href="#">
                    <i class="fa fa-link"></i>
                    <span>Multilevel</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="#">Link in level 2</a>
                    </li>
                    <li>
                        <a href="#">Link in level 2</a>
                    </li>
                </ul>
            </li>-->
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>