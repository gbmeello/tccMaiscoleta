<section class="content-header">

    <h1>
        Dashboard
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li class="active">Cadastro</li>
    </ol>

    <div class="clearfix"></div>

    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

</section>