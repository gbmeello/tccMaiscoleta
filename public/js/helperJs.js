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
        "search": "Pesquisar",
        "processing": "<strong>Carregando...</strong><br><i class='fa fa-sync-alt fa-spin'></i>",
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

function showValidationErrors(erroBag) {
    let errorMessage = '<ul>';

    if(Array.isArray(erroBag)) {
        $.each(erroBag, function(i, value) {
            if(value !== null)
                errorMessage += `<li>${value}</li>`;
        });
    } 
    else {
        errorMessage += `<li>${erroBag}</li>`;
    }
    
    errorMessage += '</ul>';

    return showMessage('danger', errorMessage);
}


/**
 * Carrega o select2
 */
function loadSelect2(controller, target, value, text, id = null, selectValue = null) {

    let $target = $(target);
    let $btnSync = $target.siblings('.input-group-btn').find('button');

    $btnSync.button('loading');

    let url = id === null ? `/api/v1/${controller}` : `/api/v1/${controller}/${id}`;

    text = text.split('|');

    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        beforeSend: function() {
            $btnSync.button('loading');
        },
        complete: function() {
            $btnSync.button('reset');
        },
        success: function(response) {

            if(response.success) {

                $target.empty().trigger('change');

                if(response.data.length > 0) {
                    $target.append('<option value=""> Selecione uma opção... </option>');
                }
                else {
                    $target.append('<option value=""> Nenhum valor ainda foi cadastrado... </option>');
                }

                $.each(response.data, function(index, obj) {

                    let selected = '';

                    if(selectValue !== null && obj[value] === selectValue) {
                        selected = 'selected';
                    }

                    if(text.length > 1) {

                        let txt = '';
                        for(let i = 0; i < text.length; i++) {
                            if(i === 0) {
                                txt += obj[text[i]];
                            } else {
                                txt += ' / ' + obj[text[i]];
                            }
                        }

                        $target.append(`<option value="${obj[value]}" ${selected}> ${txt} </option>`);

                    } else {
                        $target.append(`<option value="${obj[value]}" ${selected}> ${obj[text]} </option>`);
                    }

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


function loadSelect2WithValue(controller, target, value, text, selectValue = null) {

    let $target = $(target);
    let $btnSync = $target.siblings('.input-group-btn').find('button');

    $btnSync.button('loading');

    text = text.split('|');

    $.ajax({
        type: 'GET',
        url: `/api/v1/${controller}`,
        dataType: 'json',
        beforeSend: function() {
            $btnSync.button('loading');
        },
        complete: function() {
            $btnSync.button('reset');
        },
        success: function(response) {

            if(response.success) {

                $target.empty().trigger('change');

                if(response.data.length > 0) {
                    $target.append('<option value=""> Selecione uma opção... </option>');
                }
                else {
                    $target.append('<option value=""> Nenhum valor ainda foi cadastrado... </option>');
                }

                $.each(response.data, function(index, obj) {

                    let selected = '';

                    if(selectValue !== null && obj[value] === selectValue) {
                        selected = 'selected';
                    }

                    if(text.length > 1) {

                        let txt = '';
                        for(let i = 0; i < text.length; i++) {
                            if(i === 0) {
                                txt += obj[text[i]];
                            } else {
                                txt += ' / ' + obj[text[i]];
                            }
                        }

                        $target.append(`<option value="${obj[value]}" ${selected}> ${txt} </option>`);

                    } else {

                        $target.append(`<option value="${obj[value]}" ${selected}> ${obj[text]} </option>`);
                    }

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

function loadSelectMunicipios(target, idEstado) {
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

            let $target = $(target);

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

function guid() {
    function _p8(s) {
        var p = (Math.random().toString(16)+"000000000").substr(2,8);
        return s ? "-" + p.substr(0,4) + "-" + p.substr(4,4) : p ;
    }
    return _p8() + _p8(true) + _p8(true) + _p8();
}