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
     * */
    /*addShowDetails: function (table) {
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
    },*/
};