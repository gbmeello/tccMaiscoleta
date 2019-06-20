@extends('layouts.app')

@section('contentHeader')
    <h1>
        Meu Perfil
        <small>Dados</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="active">Perfil</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Usuário - {{Auth::user()->nome}}</h3>
                </div>
                <form id="form-usuario" class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="nome">Nome</label>
                            <input readonly type="text" class="form-control" value="{{ Auth::user()->nome }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="slt_perfil">Perfil</label>
                            <input readonly type="text" class="form-control" value="{{ Auth::user()->role()->first()->nome }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input readonly type="text" class="form-control" value="{{ Auth::user()->email }}">
                        </div>
                    </div>
                </form>
                <div class="box-footer">
                    <a class="btn btn-primary btn-flat" href="{{url('usuario/editar/')}}/{{Auth::user()->pk_usuario}}">
                        <i class="fa fa-user-edit"></i> Editar Meus Dados
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection