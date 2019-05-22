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

var divMessage = function(alertClass, titulo, mensagem, icone) {

    return `<div class="alert alert-${alertClass} alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-${icone}"></i>${titulo}</h4>
                ${mensagem}
              </div>`;
};


var showMessage = function(tipo, mensagem, titulo = '') {

    let icone = '',
        alertClass = '';

    switch (tipo) {
        case 'success':
            icone = 'check';
            titulo = (titulo == '' ? 'Sucesso!' : '');
            alertClass = 'success';
            break;
        case 'danger':
            icone = 'exclamation';
            titulo = (titulo == '' ? 'Falha!' : '');
            alertClass = 'danger';
            break;
        case 'warning':
            icone = 'exclamation-triangle';
            titulo = (titulo == '' ? 'Cuidado!' : '');
            alertClass = 'warning';
            break;
        case 'info':
            icone = 'exclamation-circle';
            titulo = (titulo == '' ? 'Info!' : '');
            alertClass = 'info';
            break;
    }

    return `<div class="alert alert-${alertClass} alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 <h4><i class="icon fa fa-${icone}"></i>${titulo}</h4>
                 ${mensagem}
             </div>`;
};


var errorMessage = null;
var showValidationErrors = function(arrayError) {
    errorMessage = '';
    errorMessage += '<ul>';
    getMessageRecursive(arrayError);
    errorMessage += '</ul>';
    return divMessage('danger', 'Erro na validação', errorMessage, 'exclamation-triangle');
};

var getMessageRecursive = function(arrayError) {
    console.log(arrayError);
    $.each(arrayError, function(i, value) {
        if(Array.isArray(value)) {
            getMessageRecursive(value);
        } else {
            errorMessage += `<li>${value}</li>`;
        }
    });
};