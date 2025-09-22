// Guardamos las acciones originales
let _excelAction = $.fn.dataTable.ext.buttons.excelHtml5.action;
let _pdfAction = $.fn.dataTable.ext.buttons.pdfHtml5.action;

// Función wrapper genérica (para Excel u otros rápidos)
function withSpinner(action) {
    return function (e, dt, button, config) {
        let $btn = $(button);
        let originalHtml = $btn.html();

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        action.call(this, e, dt, button, config);

        setTimeout(() => {
            $btn.prop('disabled', false).html(originalHtml);
        }, 1000);
    };
}

// Función especial para PDF (bloquea más el hilo)
function withSpinnerPdf(action) {
    return function (e, dt, button, config) {
        let $btn = $(button);
        let originalHtml = $btn.html();

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        // Forzar repaint antes de ejecutar pdfmake
        setTimeout(() => {
            action.call(this, e, dt, button, config);

            setTimeout(() => {
                $btn.prop('disabled', false).html(originalHtml);
            }, 1000);
        }, 0);
    };
}

// Sobrescribimos las acciones globalmente
$.fn.dataTable.ext.buttons.excelHtml5.action = withSpinner(_excelAction);
$.fn.dataTable.ext.buttons.pdfHtml5.action = withSpinnerPdf(_pdfAction);
