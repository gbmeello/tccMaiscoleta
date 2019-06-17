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
            <div id="box-uhs-livres" class="small-box bg-green">
                <div class="inner">
                    <h3 class="small-box-number"></h3>
                    <span class="small-box-title"></span>
                </div>
                <div class="icon">
                    <i class="fa fa-home"></i>
                </div>
                <a href="javascript:0;" id="btn-teste" class="small-box-footer small-box-info-button">
                    Mais informações <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div id="box-hosp-por-nacionalidade" data-prop-name="checkin_hoje" class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Hóspedes por Nacionalidade</h4>
                    <div class="box-tools pull-right">
                        <button id="btn-abrir-detalhe-checkin-hoje" class="btn bg-blue btn-flat btn-sm"><i class="fa fa-external-link"></i> Detalhes...</button>
                    </div>
                </div>
                <div class="box-body">
                    <!--data-chart-name="checkin_hoje"-->
                    <canvas id="chart-hosp-por-nacionalidade" data-chart-name="hosp_por_nacionalidade" class="canvas"/>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')

    <script>
    
    $(document).ready(function() {

        let hoje = new Date().toISOString().slice(0, 10);

        initUhsLivres(hoje);
        initUhsOcupadas(hoje);
        initUhsAllotment(hoje);
        initUhsCheckinsPrevistos(hoje);
        initUhsCheckoutsPrevistos(hoje);
        initUhsManutencao(hoje);

        initHospedesPorNacionalidade(hoje);
        initHospedesPorFaixaEtaria(hoje);
        initHospedesPorPensao(hoje);

    });


        function initUhsLivres(data) {

            let $box = $('#box-uhs-livres');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: controlPage.prefixSystem + 'dashboard/recepcao/uhs-livres',
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


        function initHospedesPorNacionalidade(data) {

            let $box = $('#box-hosp-por-nacionalidade');
            let $canvas = $('#chart-hosp-por-nacionalidade');
            let name = $canvas.data('chart-name');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: 'api/v1/dashboard/',
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
                            title: "Dados dos Hóspedes por Nacionalidade",
                            type: 'pie'
                        },
                        tableLabelColumnText: 'País',
                        tableValueColumnText: 'Quant.'
                    });
                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }

    
    </script>

@endsection