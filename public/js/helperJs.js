var configDatatable = {

    language: {
        "lengthMenu": "Exibir _MENU_ linhas por página",
        "zeroRecords": "Nenhum dado relacionado foi encontrado",
        "info": "Página _PAGE_ de _PAGES_",
        "infoEmpty": "Nenhum dado relacionado foi encontrado",
        "infoFiltered": "(filtrado de _MAX_)",
        "paginate": {
            "next": "Próxima",
            "previous": "Anterior",
            "first": "Primeiro",
            "last": "Último"
        },
        "search": "Pesquisar"
    },

    /**
     * Adiciona o controle de detalhes da linha
     **/
    addShowDetails: function ($table, dataTable, format) {
        var detailRows = [];

        $table.on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dataTable.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                row.child( format( row.data() ) ).show();

                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );

        // On each draw, loop over the `detailRows` array and show any child rows
        dataTable.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                $('#'+id+' td.details-control').trigger( 'click' );
            } );
        } );
    },
};

function divMessage(alertClass, titulo, mensagem, icone) {

    return `<div class="alert alert-${alertClass} alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-${icone}"></i>${titulo}</h4>
                ${mensagem}
                </div>`;
};

function showMessage(tipo, mensagem, titulo = '') {

    let icone = '',
        alertClass = '';

    switch (tipo) {
        case 'success':
            icone = 'check';
            titulo = (titulo == '' ? 'Sucesso' : '');
            alertClass = 'success';
            break;
        case 'danger':
            icone = 'exclamation';
            titulo = (titulo == '' ? 'Atenção' : '');
            alertClass = 'danger';
            break;
        case 'warning':
            icone = 'exclamation-triangle';
            titulo = (titulo == '' ? 'Cuidado' : '');
            alertClass = 'warning';
            break;
        case 'info':
            icone = 'exclamation-circle';
            titulo = (titulo == '' ? 'Informação' : '');
            alertClass = 'info';
            break;
    }

    return `<div class="alert alert-${alertClass} alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-${icone}"></i>${titulo}</h4>
                    ${mensagem}
                </div>`;
};

function showValidationErrors(arrayError) {
    let errorMessage = '<ul>';
    $.each(arrayError, function(i, value) {
        if(value !== null)
            errorMessage += `<li>${value}</li>`;
    });
    errorMessage += '</ul>';
    return showMessage('danger', errorMessage);
}

function loadSelectMunicipios(target, idEstado) {

    let $target = $(target);

    $.ajax({
        type: 'GET',
        url: '/api/v1/municipio/listar-por-estado/'+idEstado,
        dataType: 'json',
        beforeSend: function() {
            console.log('antes de enviar');
        },
        complete: function() {
            console.log('completo');
        },
        success: function(response) {

            if(response.success) {
                $target.empty().trigger('change');
                $.each(response.data, function(index, municipio) {
                    $target.append(`<option value="${municipio.pk_municipio}">${municipio.nome}</option>`);
                });
                $target.trigger('change');

            } else {
                console.error(response.message);
            }

        },
        error: function(xhr) { // if error occured
            console.error(xhr.responseJSON.message);
        }
    });
}

function initializeDeleteDialog(url, id) {
    bootbox.confirm({
        title: '<strong>Você realmente deseja deletar o registro?</strong>',
        message: "Após confirmação, o registro será deletado",
        buttons: {
            confirm: {
                className: 'btn-success'
            },
            cancel: {
                className: 'btn-danger'
            }
        },
        locale: 'br',
        callback: function (confirm) {
            if(confirm) {
                $.ajax({
                    type: 'DELETE',
                    url: `/api/v1/${url}/${id}`,
                    dataType: 'json',
                    beforeSend: function() {
                        console.log('antes de enviar');
                    },
                    complete: function() {
                        console.log('completo');
                    },
                    success: function(response) {
                        if(response.success) {
                            bootbox.alert({
                                title: '<span><strong>Sucesso!</strong></span>',
                                message: "Registro deletado com sucesso!",
                                confirm: {
                                    className: 'btn-success'
                                }
                            });
                        } else {
                            bootbox.alert({
                                title: '<span><strong>Falha!</strong></span>',
                                message: "Falha ao deletar o registro. Por favor, tente novamente",
                                confirm: {
                                    className: 'btn-danger'
                                }
                            });
                        }
                    },
                    error: function(xhr) { // if error occured
                        console.error(xhr.responseJSON.message);
                    }
                });
            }
        }
    });
}

function initializeMapModal(lat, lng) {

    bootbox.alert({
        title: '<span><strong>Localização do ponto de coleta</strong></span>',
        message: `
            <div class="col-sm-12 col-md-12">
                <div id='map' style="position: relative; width: 100%; height: 100vh;"></div>
            </div>
        `,
        size: 'large',
    });

    debugger;

    // example origin and destination
    var start = {lat: 22.3077423, lng: 114.2287582};
    var finish = {lat: 22.3131334, lng: 114.2205973};

    var map = mapboxgl.Map('map', 'mapbox.streets', {
        zoomControl: false }).setView([start.lat, start.lng], 14);

    map.attributionControl.setPosition('bottomleft');
    var directions = L.mapbox.directions({
        profile: 'mapbox.walking'
    });

    // Set the origin and destination for the direction and call the routing service
    directions.setOrigin(L.latLng(start.lat, start.lng));
    directions.setDestination(L.latLng(finish.lat, finish.lng));
    directions.query();

    var directionsLayer = L.mapbox.directions.layer(directions).addTo(map);
    var directionsRoutesControl = L.mapbox.directions.routesControl('routes', directions)
        .addTo(map);

    // mapboxgl.accessToken = 'pk.eyJ1IjoibWFyY2lvbWVuZGVzIiwiYSI6ImNqc2VtNGtmeTBzNGQzeXRscWxkMThvcXIifQ.83J82VEpsdmfE-xu9W4uUg';
    // let map = new mapboxgl.Map({
    //     container: 'map', // container id
    //     style: 'mapbox://styles/mapbox/streets-v11',
    //     center: [lng, lat], // starting position
    //     zoom: 16 // starting zoom
    // });

    // map.loadImage('/img/truck-mark.png', function(error, image) {

    //     if(error) {
    //         throw error;
    //     }

    //     let name = "recyclage-image" + Math.round(Math.random() * 10000000);

    //     map.addImage(name, image);
    //     map.addLayer({
    //         "id": name,
    //         "type": "symbol",
    //         "source": {
    //             "type": "geojson",
    //             "data": {
    //                 "type": "FeatureCollection",
    //                 "features": [{
    //                     "type": "Feature",
    //                     "geometry": {
    //                         "type": "Point",
    //                         "coordinates": [lng, lat]
    //                     }
    //                 }]
    //             }
    //         },
    //         "layout": {
    //             "icon-image": name,
    //             "icon-size": 0.15
    //         }
    //     });


    // });

}