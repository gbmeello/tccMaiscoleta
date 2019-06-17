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

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div id="box-ponto-coleta-mais-vendidos" class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Pontos de Coleta mais vendidos</h4>
                    <div class="box-tools pull-right">
                        <button id="btn-abrir-ponto-coleta-coleta-mais-vendidos" class="btn bg-blue btn-flat btn-sm"><i class="fa fa-external-link"></i> Detalhes...</button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="chart-ponto-coleta-mais-vendidos" data-chart-name="ponto_coleta_mais_vendidos" class="canvas" />
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')

    <script>
    
        $(document).ready(function() {

            let hoje = new Date().toISOString().slice(0, 10);

            initBoxFardoQuantidade(hoje);
            initBoxFardoEmEstoque(hoje);
            initBoxFardoVendido(hoje);

            initPiePontoColetaMaisVendidos(hoje);

        });


        function initBoxFardoQuantidade(data) {

            let $box = $('#box-uhs-livres');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: 'api/v1/dashboard/fardo/quantidade',
                data: {
                    dataReferencia: data
                },
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

        function initBoxFardoEmEstoque(data) {

            let $box = $('#box-uhs-livres');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: 'api/v1/dashboard/fardo/quantidade',
                data: {
                    dataReferencia: data
                },
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


        function initBoxFardoVendido(data) {

            let $box = $('#box-uhs-livres');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: 'api/v1/dashboard/fardo/quantidade',
                data: {
                    dataReferencia: data
                },
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

        function initPiePontoColetaMaisVendidos(data) {

            let $box = $('#box-ponto-coleta-mais-vendidos');
            let $canvas = $('#chart-ponto-coleta-mais-vendidos');
            let name = $canvas.data('chart-name');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: 'api/v1/dashboard/ponto-coleta/mais-vendidos',
                data: {
                    chartName: name,
                    dataReferencia: data
                },
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
                            title: "Pontos de Coleta",
                            type: 'pie'
                        },
                        tableLabelColumnText: 'Ponto de Coleta',
                        tableValueColumnText: 'Fardos Vendidos'
                    });
                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }

    
    </script>

@endsection