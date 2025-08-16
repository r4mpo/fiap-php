jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "date-br-pre": function (a) {
        if (a == null || a == "") {
            return 0;
        }
        var brDatea = a.split('/');
        return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
    },

    "date-br-asc": function (a, b) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "date-br-desc": function (a, b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});

$(document).ready(function () {
    const th = $('table thead tr th[data-is-date="true"]');

    let tableOptions = {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        }
    };

    // Se houver coluna de data, adiciona columnDefs
    if (th.length > 0) {
        const index = th.index();
        tableOptions.columnDefs = [
            { type: 'date-br', targets: index } // usa nosso tipo customizado
        ];
    }

    // Inicializa o DataTable
    let table = new DataTable('.table', tableOptions);
});
