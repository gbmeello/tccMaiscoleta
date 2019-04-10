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
    addShowDetails: function (table, format) {
        table.find('tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr'),
                row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                var sTable = format(row.data());
                row.child(sTable).show();
                tr.addClass('shown');
            }
        });
    },
};

var divMessage = function(alertClass, titulo, mensagem, icone) {

    return `<div class="alert alert-${alertClass} alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-${icone}"></i>${titulo}</h4>
                ${mensagem}
              </div>`;
}