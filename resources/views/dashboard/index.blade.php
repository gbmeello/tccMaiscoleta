@extends('layouts.app')

@section('contentHeader')
    <h1>
        Dashboard
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li class="active">Dashboard</li>
    </ol>
@endsection

@section('content')
    <div class="row">

        <div class="col-lg-3 col-md-6 col-xs-6">
            <div id="box-fardo-qtd" class="small-box bg-blue">
                <div class="inner">
                    <h3 class="small-box-number">0</h3>
                    <span class="small-box-title">Total</span>
                </div>
                <div class="icon">
                    <i class="fa fa-cubes"></i>
                </div>
                <a href="javascript:0;" id="btn-teste" class="small-box-footer small-box-info-button">
                    Mais informações <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-xs-6">
            <div id="box-fardo-estoque" class="small-box bg-yellow">
                <div class="inner">
                    <h3 class="small-box-number">0</h3>
                    <span class="small-box-title">Estoque</span>
                </div>
                <div class="icon">
                    <i class="fa fa-cubes"></i>
                </div>
                <a href="javascript:0;" id="btn-teste" class="small-box-footer small-box-info-button">
                    Mais informações <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-xs-6">
            <div id="box-fardo-vendido" class="small-box bg-green">
                <div class="inner">
                    <h3 class="small-box-number">0</h3>
                    <span class="small-box-title">Vendido</span>
                </div>
                <div class="icon">
                    <i class="fa fa-cubes"></i>
                </div>
                <a href="javascript:0;" id="btn-teste" class="small-box-footer small-box-info-button">
                    Mais informações <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div id="box-rota-mais-coletada" class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Rotas mais coletadas (em kg's)</h4>
                    <div class="box-tools pull-right">
                        <button id="btn-abrir-rota-mais-coletada" class="btn bg-blue btn-flat btn-sm"><i class="fa fa-external-link"></i> Detalhes...</button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="chart-rota-mais-coletada" data-chart-name="rota_mais_coletada" class="canvas" />
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div id="box-cliente-maiores-compradores" class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Maiores compradores (em kg's)</h4>
                    <div class="box-tools pull-right">
                        <button id="btn-abrir-cliente-maiores-compradores" class="btn bg-blue btn-flat btn-sm"><i class="fa fa-external-link"></i> Detalhes...</button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="chart-cliente-maiores-compradores" data-chart-name="cliente_maiores_compradores" class="canvas" />
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')

    <script src="{{asset('js/dashboard.js')}}"></script>
    <script>
    
        $(document).ready(function() {

            // let hoje = new Date().toISOString().slice(0, 10);

            initBoxFardoQuantidade();
            initBoxFardoEmEstoque();
            initBoxFardoVendido();

            initPieRotasMaisColetadas();

            initBarMaioresCompradores();

        });


        function initBoxFardoQuantidade() {

            let $box = $('#box-fardo-qtd');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/api/v1/fardo/quantidade',
                beforeSend: function() {
                    $box.addClass('whirl traditional');
                },
                complete: function() {
                    $box.removeClass('whirl traditional');
                },
                success: function(response) {

                    $box.populateSmallbox(response.data);

                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }       

        function initBoxFardoEmEstoque() {

            let $box = $('#box-fardo-estoque');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/api/v1/fardo/estoque',
                beforeSend: function() {
                    $box.addClass('whirl traditional');
                },
                complete: function() {
                    $box.removeClass('whirl traditional');
                },
                success: function(response) {

                    $box.populateSmallbox(response.data);

                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }       


        function initBoxFardoVendido() {

            let $box = $('#box-fardo-vendido');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/api/v1/fardo/vendido',
                beforeSend: function() {
                    $box.addClass('whirl traditional');
                },
                complete: function() {
                    $box.removeClass('whirl traditional');
                },
                success: function(response) {

                    $box.populateSmallbox(response.data);

                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }       

        function initPieRotasMaisColetadas() {

            let $box = $('#box-rota-mais-coletada');
            let $canvas = $('#chart-rota-mais-coletada');
            let name = $canvas.data('chart-name');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/api/v1/rota/rotas-mais-coletadas',
                beforeSend: function() {
                    $box.addClass('whirl traditional');
                },
                complete: function() {
                    $box.removeClass('whirl traditional');
                },
                success: function(response) {

                    $canvas.chartbox({
                        content: response.data,
                        chart: {
                            title: 'Rotas Mais Coletadas',
                            type: 'pie'
                        },
                        tableLabelColumnText: 'Rota',
                        tableValueColumnText: "Kg's"
                    });
                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }


        function initBarMaioresCompradores() {

            let $box = $('#box-cliente-maiores-compradores');
            let $canvas = $('#chart-cliente-maiores-compradores');
            let name = $canvas.data('chart-name');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/api/v1/cliente-final/maiores-compradores',
                beforeSend: function() {
                    $box.addClass('whirl traditional');
                },
                complete: function() {
                    $box.removeClass('whirl traditional');
                },
                success: function(response) {

                    $canvas.chartbox({
                        content: response.data,
                        chart: {
                            title: 'Maiores compradores',
                            type: 'bar'
                        },
                        tableLabelColumnText: 'Cliente',
                        tableValueColumnText: "Kg's"
                    });
                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }

    
    </script>

@endsection