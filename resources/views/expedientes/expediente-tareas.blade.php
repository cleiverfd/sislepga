<section>
    <div class="card card-primary card-outline">
        <div class="card-header py-2">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 mr-3">LISTA DE AUDIENCIAS</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tbl_audicencias">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th>
                                    <th class="text-nowrap">DIRECCION / ENLACE</th>
                                    <th class="text-nowrap">FECHA</th>
                                    <th class="text-nowrap">DESCRIPCION</th>
                                    <th class="text-nowrap">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-header py-2">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 mr-3">LISTA DE ALERTAS</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tbl_alertas">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th>
                                    <th class="text-nowrap">VENCIMIENTO</th>
                                    <th class="text-nowrap">DESCRIPCION</th>
                                    <th class="text-nowrap">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdl-audiencia">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="d-none" for="lbl_idAudiencia"></label>
                    <h4 class="modal-title" id="modalAudienciaLabel">Registrar Audiencia</h4>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1" for="txt_fechaAudiencia">FECHA</label>
                                <input type="datetime-local" class="form-control" id="txt_fechaAudiencia">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1" for="txt_lugarAudiencia">DIRECCION</label>
                                <input type="text" class="form-control" id="txt_lugarAudiencia">
                                <span class="small text-muted">Complete este campo si la audiencia es presencial</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1" for="txt_enlaceAudiencia">ENLACE</label>
                                <input type="text" class="form-control" id="txt_enlaceAudiencia">
                                <span class="small text-muted">Complete este campo si la audiencia es virtual</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1" for="txt_descripcionAudiencia">DESCRIPCION</label>
                                <input type="text" class="form-control" id="txt_descripcionAudiencia">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button class="btn btn-success" id="btn_GuardarAudiencia">Registrar Audiencia</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdl-alerta">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="d-none" for="lbl_idAlerta"></label>
                    <h4 class="modal-title" id="modalAlertaLabel">Registrar Alerta</h4>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1" for="txt_fechaAlerta">FECHA VENCIMIENTO</label>
                                <input type="datetime-local" class="form-control" id="txt_fechaAlerta">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1" for="txt_descripcionAlerta">DESCRIPCION</label>
                                <input type="text" class="form-control" id="txt_descripcionAlerta">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button class="btn btn-success" id="btn_GuardarAlerta">Registrar Alerta</button>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        var tbl_audicencias;
        var tbl_alertas;
        var id_audiencia;
        var id_alerta;

        $(document).ready(function() {
            fct_listarAudiencias();
            fct_listarAlertas();

            $('#btn_GuardarAudiencia').click(function() {
                if ($("#btn_GuardarAudiencia").hasClass("edit")) {
                    fct_ActualizarAudiencia();
                } else {
                    fct_RegistrarAudiencia();
                }
            });

            $('#btn_GuardarAlerta').click(function() {
                if ($("#btn_GuardarAlerta").hasClass("edit")) {
                    fct_ActualizarAlerta();
                } else {
                    fct_RegistrarAlerta();
                }
            });
        });

        function fct_listarAudiencias() {
            tbl_audicencias = $('#tbl_audicencias').DataTable({
                destroy: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: false,
                processing: true,
                serverSide: false,
                orderable: true,
                dom: `<"row mb-2"<"col-6"B><"col-6 btn-new-audiencia text-right">> <"row mb-2"<"col-6"l><"col-6"f>> <"row mb-2"<"col-12"tr>> <"row"<"col-5"i><"col-7"p>>`,
                buttons: [{
                        extend: 'copy',
                        className: 'btn btn-secondary rounded-lg mr-2',
                        text: '<i class="fas fa-copy"></i>',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success mr-2 rounded-lg',
                        text: '<i class="fas fa-file-excel"></i>',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger mr-2 rounded-lg',
                        text: '<i class="fas fa-file-pdf"></i>',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        text: '<i class="fas fa-plus"></i> Nuevo',
                        className: 'btn btn-success rounded-lg d-none btn-nuevo-audiencia',
                        action: function() {
                            fct_NuevoAudiencia();
                        }
                    }
                ],
                ajax: {
                    url: '/expedientes/listar-audiencias',
                    type: 'POST',
                    data: function(d) {
                        d.IdExpediente = IdExpediente;
                    },
                    dataSrc: function(json) {
                        if (json.status === 'success') {
                            return json.data;
                        }
                        return [];
                    },
                    error: function(xhr, status, error) {
                        toast.error("ERROR", error);
                        console.error('Error:', error);
                    }
                },
                columns: [{
                        data: 'id',
                        className: 'py-1 text-center'
                    },
                    {
                        data: 'lugar',
                        className: 'py-1 pl-3 text-nowrap'
                    },
                    {
                        data: 'fecha',
                        className: 'py-1 pl-3 text-nowrap'
                    },
                    {
                        data: 'descripcion',
                        className: 'py-1 pl-3 text-nowrap'
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'py-1 text-center text-nowrap',
                        render: function(data, type, row) {
                            const btnVer = `<button class="btn btn-sm btn-warning" title="Editar" onclick="fct_EditarAudiencia(${data.id})"><i class="fas fa-edit"></i></button>`;
                            const btnEliminar = `<button class="btn btn-sm btn-danger ml-1" title="Eliminar" onclick="fct_EliminarAudiencia(${data.id})"><i class="fas fa-trash-alt"></i></button>`;
                            return btnVer + btnEliminar;
                        }
                    }
                ],
                initComplete: function() {
                    // Mostrar botón nuevo
                    $('.btn-nuevo-audiencia').removeClass('d-none');
                    const $nuevoBtn = $('.btn-nuevo-audiencia').detach();
                    $('.btn-new-audiencia').html($nuevoBtn);

                    // Normalizar clases de botones exportar
                    $('.buttons-copy').removeClass().addClass('btn btn-secondary mr-2 rounded-lg');
                    $('.buttons-excel').removeClass().addClass('btn btn-success mr-2 rounded-lg');
                    $('.buttons-pdf').removeClass().addClass('btn btn-danger mr-2 rounded-lg');
                }
            });
        }

        function fct_listarAlertas() {
            tbl_alertas = $('#tbl_alertas').DataTable({
                destroy: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: false,
                processing: true,
                serverSide: false,
                orderable: true,
                dom: `<"row mb-2"<"col-6"B><"col-6 btn-new-alerta text-right">> <"row mb-2"<"col-6"l><"col-6"f>> <"row mb-2"<"col-12"tr>> <"row"<"col-5"i><"col-7"p>>`,
                buttons: [{
                        extend: 'copy',
                        className: 'btn btn-secondary rounded-lg mr-2',
                        text: '<i class="fas fa-copy"></i>',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success mr-2 rounded-lg',
                        text: '<i class="fas fa-file-excel"></i>',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger mr-2 rounded-lg',
                        text: '<i class="fas fa-file-pdf"></i>',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        text: '<i class="fas fa-plus"></i> Nuevo',
                        className: 'btn btn-success rounded-lg d-none btn-nuevo-alerta',
                        action: function() {
                            fct_NuevoAlerta();
                        }
                    }
                ],
                ajax: {
                    url: '/expedientes/listar-alertas',
                    type: 'POST',
                    data: function(d) {
                        d.IdExpediente = IdExpediente;
                    },
                    dataSrc: function(json) {
                        if (json.status === 'success') {
                            return json.data;
                        }
                        return [];
                    },
                    error: function(xhr, status, error) {
                        toast.error("ERROR", error);
                        console.error('Error:', error);
                    }
                },
                columns: [{
                        data: 'id',
                        className: 'py-1 text-center'
                    },
                    {
                        data: 'fecha',
                        className: 'py-1 pl-3 text-nowrap'
                    },
                    {
                        data: 'descripcion',
                        className: 'py-1 pl-3 text-nowrap'
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'py-1 text-center text-nowrap',
                        render: function(data, type, row) {
                            const btnVer = `<button class="btn btn-sm btn-warning" title="Editar" onclick="fct_EditarAlerta(${data.id})"><i class="fas fa-edit"></i></button>`;
                            const btnEliminar = `<button class="btn btn-sm btn-danger ml-1" title="Eliminar" onclick="fct_EliminarAlerta(${data.id})"><i class="fas fa-trash-alt"></i></button>`;
                            return btnVer + btnEliminar;
                        }
                    }
                ],
                initComplete: function() {
                    // Mostrar botón nuevo
                    $('.btn-nuevo-alerta').removeClass('d-none');
                    const $nuevoBtn = $('.btn-nuevo-alerta').detach();
                    $('.btn-new-alerta').html($nuevoBtn);

                    // Normalizar clases de botones exportar
                    $('.buttons-copy').removeClass().addClass('btn btn-secondary mr-2 rounded-lg');
                    $('.buttons-excel').removeClass().addClass('btn btn-success mr-2 rounded-lg');
                    $('.buttons-pdf').removeClass().addClass('btn btn-danger mr-2 rounded-lg');
                }
            });
        }

        function fct_NuevoAudiencia() {
            $('#mdl-audiencia').modal('show');
            $('#modalAudienciaLabel').text('Registrar Audiencia');
            $('#btn_GuardarAudiencia').removeClass('edit').text('Registrar Audiencia');
        }

        function fct_RegistrarAudiencia() {

            var esValido = fct_validarCamposAudiencia();

            if (!esValido) {
                return;
            }

            let formData = new FormData();

            formData.append('idExpediente', IdExpediente);
            formData.append('fecha', $('#txt_fechaAudiencia').val());
            formData.append('lugar', $('#txt_lugarAudiencia').val());
            formData.append('enlace', $('#txt_enlaceAudiencia').val());
            formData.append('descripcion', $('#txt_descripcionAudiencia').val());

            $.ajax({
                url: '/expedientes/registrar-audiencia',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        toast.success("SISGE", response.Msj);
                        $('#mdl-audiencia').modal('hide');
                        fct_limpiarCamposAudiencia();
                        tbl_audicencias.ajax.reload();
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISGE", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        }

        function fct_EditarAudiencia(id) {

            $('#mdl-audiencia').modal('show');
            $('#modalAudienciaLabel').text('Editar Audiencia');
            $('#btn_GuardarAudiencia').addClass('edit').text('Guardar Cambios');

            $.getJSON('/Get_EditarAudiencia', {
                Id: id
            }, function(json) {
                var data = json.data;

                id_audiencia = data.id;
                $('#txt_fechaAudiencia').val(data.fecha);
                $('#txt_lugarAudiencia').val(data.lugar);
                $('#txt_enlaceAudiencia').val(data.enlace);
                $('#txt_descripcionAudiencia').val(data.descripcion);

            });
        }

        function fct_ActualizarAudiencia() {

            var esValido = fct_validarCamposAudiencia();

            if (!esValido) {
                return;
            }

            let formData = new FormData();

            formData.append('Id', id_audiencia);
            formData.append('fecha', $('#txt_fechaAudiencia').val());
            formData.append('lugar', $('#txt_lugarAudiencia').val());
            formData.append('enlace', $('#txt_enlaceAudiencia').val());
            formData.append('descripcion', $('#txt_descripcionAudiencia').val());

            $.ajax({
                url: '/expedientes/editar-audiencia',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        toast.success("SISGE", response.Msj);
                        $('#mdl-audiencia').modal('hide');
                        fct_limpiarCamposAudiencia();
                        tbl_audicencias.ajax.reload();
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISGE", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        }

        function fct_EliminarAudiencia(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta audiencia se eliminará de forma permanente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/expedientes/eliminar-audiencia',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(json) {
                            if (json.status === 'success') {
                                tbl_audicencias.ajax.reload();
                                toast.success("SISGE", json.Msj);
                            }
                        },
                        error: function(xhr) {
                            toast.error("SISGE", xhr.responseText);
                            console.error('Error:', xhr.responseText);
                        }
                    });
                }
            });
        }

        function fct_NuevoAlerta() {
            $('#mdl-alerta').modal('show');
            $('#modalAlertaLabel').text('Registrar Alerta');
            $('#btn_GuardarAlerta').removeClass('edit').text('Registrar Alerta');
        }

        function fct_RegistrarAlerta() {

            var esValido = fct_validarCamposAlerta();

            if (!esValido) {
                return;
            }

            let formData = new FormData();

            formData.append('idExpediente', IdExpediente);
            formData.append('fecha', $('#txt_fechaAlerta').val());
            formData.append('descripcion', $('#txt_descripcionAlerta').val());

            $.ajax({
                url: '/expedientes/registrar-alerta',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        toast.success("SISGE", response.Msj);
                        $('#mdl-alerta').modal('hide');
                        fct_limpiarCamposAlerta();
                        tbl_alertas.ajax.reload();
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISGE", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    toast.error("SISGE", xhr.responseText);
                }
            });
        }

        function fct_EditarAlerta(id) {

            $('#mdl-alerta').modal('show');
            $('#modalAlertaLabel').text('Editar Alerta');
            $('#btn_GuardarAlerta').addClass('edit').text('Guardar Cambios');

            $.getJSON('/Get_EditarAlerta', {
                Id: id
            }, function(json) {
                var data = json.data;

                id_alerta = data.id;
                $('#txt_fechaAlerta').val(data.fecha);
                $('#txt_descripcionAlerta').val(data.descripcion);

            });
        }

        function fct_ActualizarAlerta() {

            var esValido = fct_validarCamposAlerta();

            if (!esValido) {
                return;
            }

            let formData = new FormData();

            formData.append('Id', id_alerta);
            formData.append('fecha', $('#txt_fechaAlerta').val());
            formData.append('descripcion', $('#txt_descripcionAlerta').val());

            $.ajax({
                url: '/expedientes/editar-alerta',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        toast.success("SISGE", response.Msj);
                        $('#mdl-alerta').modal('hide');
                        fct_limpiarCamposAlerta();
                        tbl_alertas.ajax.reload();
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISGE", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        }

        function fct_EliminarAlerta(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta alerta se eliminará de forma permanente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/expedientes/eliminar-alerta',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(json) {
                            if (json.status === 'success') {
                                tbl_alertas.ajax.reload();
                                toast.success("SISGE", json.Msj);
                            }
                        },
                        error: function(xhr) {
                            toast.error("SISGE", xhr.responseText);
                            console.error('Error:', xhr.responseText);
                        }
                    });
                }
            });
        }

        function mostrarErroresValidacion(errores) {
            if (errores.length > 0) {
                const listaHTML =
                    `<ul style="margin: 0; padding-left: 1.2rem;">${errores.map(e => `<li>${e}</li>`).join('')}</ul>`;
                toast.warning("CAMPOS OBLIGATORIOS", listaHTML, {
                    dangerouslyUseHTMLString: true
                });
                return false;
            }
            return true;
        }

        function fct_validarCamposAudiencia() {
            let errores = [];

            if (!$('#txt_fechaAudiencia').val().trim()) errores.push('Fecha');
            //if (!$('#txt_lugarAudiencia').val().trim()) errores.push('Lugar');
            //if (!$('#txt_enlaceAudiencia').val().trim()) errores.push('Enlace');
            if (!$('#txt_descripcionAudiencia').val().trim()) errores.push('Descripcion');

            return mostrarErroresValidacion(errores);
        }

        function fct_limpiarCamposAudiencia() {
            $('#txt_fechaAudiencia').val('');
            $('#txt_lugarAudiencia').val('');
            $('#txt_enlaceAudiencia').val('');
            $('#txt_descripcionAudiencia').val('');
        }

        function fct_validarCamposAlerta() {
            let errores = [];

            if (!$('#txt_fechaAlerta').val().trim()) errores.push('Fecha');
            if (!$('#txt_descripcionAlerta').val().trim()) errores.push('Descripcion');

            return mostrarErroresValidacion(errores);
        }

        function fct_limpiarCamposAlerta() {
            $('#txt_fechaAlerta').val('');
            $('#txt_descripcionAlerta').val('');
        }
    </script>
@endpush
