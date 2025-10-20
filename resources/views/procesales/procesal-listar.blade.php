<section>
    <table class="table table-hover table-bordered" id="tbl_procesales">
        <thead>
            <tr>
                <th class="text-nowrap">ID</th>
                <th class="text-nowrap">PARTE</th>
                <th class="text-nowrap">TIPO DE PERSONA</th>
                <th class="text-nowrap">CONDICION</th>
                <th class="text-nowrap">DOCUMENTO</th>
                <th class="text-nowrap">NOMBRES COMPLETOS / RAZON SOCIAL</th>
                <th class="text-nowrap">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</section>
<div class="modal fade" id="mdlDetalleProcesal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalle Procesal</h4>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body mb-3">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="txt_tipoPersonaDet" class="mb-1">Tipo Persona</label>
                            <input type="text" class="form-control" id="txt_tipoPersonaDet" disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="txt_tipoProcesalDet" class="mb-1">Tipo Procesal</label>
                            <input type="text" class="form-control" id="txt_tipoProcesalDet" disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="txt_CondicionDet" class="mb-1">Condicion</label>
                            <input type="text" class="form-control" id="txt_CondicionDet" disabled>
                        </div>
                    </div>
                    <div class="col-4 natural">
                        <div class="form-group">
                            <label for="txt_dni" class="mb-1">DNI</label>
                            <input type="text" class="form-control" id="txt_dniDet" disabled>
                        </div>
                    </div>
                    <div class="col-8 natural">
                        <div class="form-group">
                            <label for="txt_datosDet" class="mb-1">Apellidos y Nombres</label>
                            <input type="text" class="form-control" id="txt_datosDet" disabled>
                        </div>
                    </div>
                    <div class="col-4 juridica">
                        <div class="form-group">
                            <label for="txt_ruc" class="mb-1">RUC</label>
                            <input type="text" class="form-control" id="txt_rucDet" disabled>
                        </div>
                    </div>
                    <div class="col-8 juridica">
                        <div class="form-group">
                            <label for="txt_razon_social" class="mb-1">Razón Social</label>
                            <input type="text" class="form-control" id="txt_rSocialDet" disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="txt_telefono" class="mb-1">Teléfono</label>
                            <input type="text" class="form-control" id="txt_telefonoDet" disabled>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label for="txt_email" class="mb-1">Email</label>
                            <input type="email" class="form-control" id="txt_emailDet" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="txt_departamento" class="mb-1">Departamento</label>
                            <input type="text" class="form-control" id="txt_departamentoDet" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="txt_provincia" class="mb-1">Provincia</label>
                            <input type="text" class="form-control" id="txt_provinciaDet" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="txt_distrito" class="mb-1">Distrito</label>
                            <input type="text" class="form-control" id="txt_distritoDet" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="txt_direccion" class="mb-1">Dirección</label>
                            <input type="text" class="form-control" id="txt_direccionDet" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdlEditarProcesal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="overlay" style="display:none;" id="loader_EditarProcesal">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">Editar Procesal</h4>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="cbx_tipoProcesal" class="mb-1">Tipo Procesal</label>
                            <select class="custom-select text-sm" id="cbx_tipoProcesal">
                                <option value="" selected disabled>--SELECCIONAR--</option>
                                <option value="DEMANDANTE">DEMANDANTE</option>
                                <option value="DEMANDADO">DEMANDADO</option>
                                <option value="DENUNCIANTE">DENUNCIANTE</option>
                                <option value="DENUNCIADO">DENUNCIADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="cbx_tipoPersona" class="mb-1">Tipo Persona</label>
                            <select class="custom-select text-sm" id="cbx_tipoPersona">
                                <option value="" selected disabled>--SELECCIONAR--</option>
                                <option value="NATURAL">NATURAL</option>
                                <option value="JURIDICA">JURIDICA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="cbx_condicion" class="mb-1">Condición</label>
                            <select class="custom-select text-sm" id="cbx_condicion">
                                <option value="" selected disabled>--SELECCIONAR--</option>
                                <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                                <option value="DOCENTE UNIVERSITARIO">DOCENTE UNIVERSITARIO</option>
                                <option value="ESTUDIANTE">ESTUDIANTE</option>
                                <option value="TERCERO">TERCERO</option>
                                <option value="FUNCIONARIO">FUNCIONARIO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3 natural">
                        <div class="form-group">
                            <label for="txt_dni" class="mb-1">DNI</label>
                            <input type="text" class="form-control text-sm" id="txt_dni">
                        </div>
                    </div>
                    <div class="col-3 natural">
                        <div class="form-group">
                            <label for="txt_nombres" class="mb-1">Nombres</label>
                            <input type="text" class="form-control text-sm" id="txt_nombres">
                        </div>
                    </div>
                    <div class="col-3 natural">
                        <div class="form-group">
                            <label for="txt_apellidoPaterno" class="mb-1">Apellido Paterno</label>
                            <input type="text" class="form-control text-sm" id="txt_apellidoPaterno">
                        </div>
                    </div>
                    <div class="col-3 natural">
                        <div class="form-group">
                            <label for="txt_apellidoMaterno" class="mb-1">Apellido Materno</label>
                            <input type="text" class="form-control text-sm" id="txt_apellidoMaterno">
                        </div>
                    </div>
                    <div class="col-4 juridica">
                        <div class="form-group">
                            <label for="txt_ruc" class="mb-1">RUC</label>
                            <input type="text" class="form-control text-sm" id="txt_ruc">
                        </div>
                    </div>
                    <div class="col-8 juridica">
                        <div class="form-group">
                            <label for="txt_razonSocial" class="mb-1">Razón Social</label>
                            <input type="text" class="form-control text-sm" id="txt_razonSocial">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="txt_telefono" class="mb-1">Teléfono</label>
                            <input type="text" class="form-control text-sm" id="txt_telefono">
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label for="txt_email" class="mb-1">Email</label>
                            <input type="email" class="form-control text-sm" id="txt_email">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="cbx_departamentos" class="mb-1">Departamento</label>
                            <select class="custom-select text-sm" id="cbx_departamentos">
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="cbx_provincias" class="mb-1">Provincia</label>
                            <select class="custom-select text-sm" id="cbx_provincias">
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="cbx_distritos" class="mb-1">Distrito</label>
                            <select class="custom-select text-sm" id="cbx_distritos">
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="txt_direccion" class="mb-1">Dirección</label>
                            <input type="text" class="form-control text-sm" id="txt_direccion">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-success" onclick="fct_ActualizarProcesal()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdlComunicacionProcesal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registrar Comunicacion</h4>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="cbx_expediente" class="mb-1">Expediente</label>
                            <select class="custom-select rounded-0" id="cbx_expediente">
                                <option value="" selected disabled>--SELECCIONAR--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="cbx_medio" class="mb-1">Medio</label>
                            <select class="custom-select rounded-0" id="cbx_medio">
                                <option value="" selected disabled>--SELECCIONAR--</option>
                                <option value="PRESENCIAL">PRESENCIAL</option>
                                <option value="LLAMADA">LLAMADA</option>
                                <option value="CORREO">CORREO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="txt_dscComunicacion" class="mb-1">Descripcion</label>
                            <textarea class="form-control rounded-0" id="txt_dscComunicacion" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-success" onclick="fct_RegistrarComunicacion()">Registrar</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script defer>
        var IdPersona;
        var tbl_procesales;

        $(document).ready(function() {
            fct_listarDepartamentos();

            fct_listarTablaProcesales();

            $('#cbx_TipoPersona').on('change', function() {
                const tipoPersona = $(this).val();
                if (tipoPersona === 'NATURAL') {
                    $('#div_PersonaNatural').removeClass('d-none');
                    $('#div_PersonaJuridica').addClass('d-none');
                } else if (tipoPersona === 'JURIDICA') {
                    $('#div_PersonaNatural').addClass('d-none');
                    $('#div_PersonaJuridica').removeClass('d-none');
                }
            });

            $('#cbx_departamentos').on('change', function() {
                const selectedId = $(this).val();
                if (selectedId) {
                    $('#cbx_provincias').find('option:not(:first)').remove();
                    $('#cbx_distritos').find('option:not(:first)').remove();
                    GetProvincias(selectedId);
                }
            });
        });

        function fct_listarTablaProcesales() {
            tbl_procesales = $('#tbl_procesales').DataTable({
                scrollY: '450px',
                // scrollX: false,
                scrollCollapse: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: false,
                orderable: true,
                dom: `<"row mb-2"<"col-6"B><"col-6">> <"row mb-2"<"col-6"l><"col-6"f>> <"row mb-2"<"col-12"tr>> <"row"<"col-5"i><"col-7"p>>`,
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
                        filename: 'Listado_Procesales', 
                        title: 'Reporte de Procesales',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger mr-2 rounded-lg',
                        text: '<i class="fas fa-file-pdf"></i>',
                        filename: 'Listado_Procesales', 
                        title: 'Reporte de Procesales', 
                        orientation: 'landscape', 
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    }
                ],
                ajax: {
                    url: '/GetProcesales',
                    type: 'GET',
                    cache: true,
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los usuarios:', error);
                    }
                },
                columns: [{
                        data: 'IdPersona',
                        className: 'py-1 text-center text-sm'
                    },
                    {
                        data: 'TipoProcesal',
                        className: 'py-1 text-sm text-nowrap'
                    },
                    {
                        data: 'TipoPersona',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'Condicion',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'Documento',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'DatosProcesal',
                        className: 'py-1 text-sm text-nowrap'
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'py-1 text-center text-sm',
                        render: function(data, type, row) {

                            let btnVer = `<button class="btn btn-sm btn-info" onclick="fct_detalleProcesal(${data.IdPersona})"><i class="fas fa-eye"></i></button>`;
                            let btnEditar = `<button class="btn btn-sm btn-warning ml-1 btn-editar" onclick="fct_editarProcesal(${data.IdPersona})"><i class="fas fa-edit"></i></button>`;
                            let btnCon = `<button class="btn btn-sm btn-success ml-1" onclick="fct_mdlComunicacion(${data.IdPersona})"><i class="fas fa-phone"></i></button>`;
                            return btnVer + btnEditar + btnCon;
                        }
                    }
                ],
                initComplete: function() {
                    $('.new').removeClass('d-none');
                    let $nuevo = $('.new').detach();
                    $('.btn-new').append($nuevo);
                }
            });
        }

        function fct_detalleProcesal(id) {
            $.ajax({
                url: `/procesal/detalle/${id}`,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success' && response.data) {
                        let d = response.data;

                        $('input').val('');

                        $('#txt_tipoPersonaDet').val(d.TipoPersona ?? '');
                        $('#txt_tipoProcesalDet').val(d.TipoProcesal ?? '');
                        $('#txt_CondicionDet').val(d.Condicion ?? '');
                        $('#txt_departamentoDet').val(d.Departamento ?? '');
                        $('#txt_provinciaDet').val(d.Provincia ?? '');
                        $('#txt_distritoDet').val(d.Distrito ?? '');
                        $('#txt_direccionDet').val(d.Direccion ?? '');
                        $('#txt_telefonoDet').val(d.Telefono ?? '');
                        $('#txt_emailDet').val(d.Correo ?? '');

                        if (d.TipoPersona === 'NATURAL') {
                            $('.natural').removeClass('d-none');
                            $('.juridica').addClass('d-none');
                            $('#txt_dniDet').val(d.Documento ?? '');
                            $('#txt_datosDet').val(d.DatosProcesal ?? '');
                        }

                        if (d.TipoPersona === 'JURIDICA') {
                            $('.juridica').removeClass('d-none');
                            $('.natural').addClass('d-none');
                            $('#txt_rucDet').val(d.Documento ?? '');
                            $('#txt_rSocialDet').val(d.DatosProcesal ?? '');
                        }

                        $('#mdlDetalleProcesal').modal('show');
                    } else {
                        alert('No se encontró el procesal');
                    }
                },
                error: function() {
                    alert('Error al cargar el detalle');
                }
            });
        }

        function fct_listarDepartamentos() {
            $.getJSON('/GetDepartamentos', function(data) {
                if (data.status === 'success') {
                    var $select = $('#cbx_departamentos');
                    $select.empty().append('<option value="">--SELECCIONAR--</option>');

                    $.each(data.data, function(index, item) {
                        $select.append(
                            `<option value="${item.Id}">${item.Descripcion}</option>`
                        );
                    });
                }
            });
        }

        function fct_listarProvincias(idDepartamento) {
            $.getJSON('/GetProvincias', {
                idDepartamento: idDepartamento
            }, function(data) {
                if (data.status === 'success') {
                    var $select = $('#cbx_provincias');
                    $select.empty().append('<option value="">--SELECCIONAR--</option>');
                    $.each(data.data, function(index, item) {
                        $select.append(
                            `<option value="${item.Id}">${item.Descripcion}</option>`
                        );
                    });
                }
            });
        }

        function fct_listarDistritos(idProvincia) {
            $.getJSON('/GetDistritos', {
                idProvincia: idProvincia
            }, function(data) {
                if (data.status === 'success') {
                    var $select = $('#cbx_distritos');
                    $select.empty().append('<option value="">--SELECCIONAR--</option>');
                    $.each(data.data, function(index, item) {
                        $select.append(
                            `<option value="${item.Id}">${item.Descripcion}</option>`
                        );
                    });
                }
            });
        }

        async function GetUbigeo(persona) {

            $('#cbx_departamentos').val(persona.IdDepartamento);

            $.getJSON('/GetProvincias', {
                idDepartamento: persona.IdDepartamento
            }, function(data) {
                if (data.status === 'success') {

                    let $provinciaSelect = $('#cbx_provincias');
                    data.data.forEach(function(item) {
                        $provinciaSelect.append(
                            `<option value="${item.Id}">${item.Descripcion}</option>`);
                    });

                    $('#cbx_provincias').val(persona.IdProvincia);

                    $.getJSON('/GetDistritos', {
                        idProvincia: persona.IdProvincia
                    }, function(data) {
                        if (data.status === 'success') {

                            let $distritoSelect = $('#cbx_distritos');
                            data.data.forEach(function(item) {
                                $distritoSelect.append(
                                    `<option value="${item.Id}">${item.Descripcion}</option>`
                                );
                            });

                            $('#cbx_distritos').val(persona.IdDistrito);
                            $('#txt_direccion').val(persona.Direccion);
                        }
                    });
                }
                hideLoaderProcesal();
            });
        }

        function fct_editarProcesal(id) {
            limpiarCamposProcesal();
            showLoaderProcesal();

            $.getJSON('/procesal/editar/' + id, function(data) {
                if (data.status === 'success') {
                    $('#mdlEditarProcesal').modal('show');

                    const persona = data.data;

                    if (persona) {
                        IdPersona = persona.IdPersona;

                        $('#cbx_tipoProcesal').val(persona.TipoProcesal);
                        $('#cbx_tipoPersona').val(persona.TipoPersona);
                        $('#cbx_condicion').val(persona.Condicion);

                        if (persona.TipoPersona === 'NATURAL') {
                            $('.natural').removeClass('d-none');
                            $('.juridica').addClass('d-none');
                            $('#txt_dni').val(persona.Dni ?? '');
                            $('#txt_apellidoPaterno').val(persona.APaterno ?? '');
                            $('#txt_apellidoMaterno').val(persona.AMaterno ?? '');
                            $('#txt_nombres').val(persona.Nombres ?? '');
                        } else if (persona.TipoPersona === 'JURIDICA') {
                            $('.juridica').removeClass('d-none');
                            $('.natural').addClass('d-none');
                            $('#txt_ruc').val(persona.Ruc ?? '');
                            $('#txt_razonSocial').val(persona.RazonSocial ?? '');
                        }

                        $('#txt_telefono').val(persona.Telefono ?? '');
                        $('#txt_email').val(persona.Correo ?? '');

                        GetUbigeo(persona);
                    }
                }
            });
        }

        function fct_ActualizarProcesal() {

            let formData = new FormData();

            formData.append('IdProcesal', IdPersona);
            formData.append('TipoProcesal', $('#cbx_tipoProcesal').val().toUpperCase());
            formData.append('TipoPersona', $('#cbx_tipoPersona').val().toUpperCase());
            formData.append('Condicion', $('#cbx_condicion').val().toUpperCase());
            formData.append('Dni', $('#txt_dni').val());
            formData.append('Nombres', $('#txt_nombres').val().toUpperCase());
            formData.append('APaterno', $('#txt_apellidoPaterno').val().toUpperCase());
            formData.append('AMaterno', $('#txt_apellidoMaterno').val().toUpperCase());
            formData.append('Ruc', $('#txt_ruc').val());
            formData.append('RazonSocial', $('#txt_razonSocial').val().toUpperCase());
            formData.append('Telefono', $('#txt_telefono').val());
            formData.append('Correo', $('#txt_email').val());
            formData.append('Direccion', $('#txt_direccion').val().toUpperCase());
            formData.append('IdDepartamento', $('#cbx_departamentos').val());
            formData.append('IdProvincia', $('#cbx_provincias').val());
            formData.append('IdDistrito', $('#cbx_distritos').val());

            $.ajax({
                url: '/procesal/actualizar',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        toast.success("SISLEPGA", response.Msj);

                        $('#mdlEditarProcesal').modal('hide');

                        tbl_procesales.ajax.reload();
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISLEPGA", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Ocurrió un error al registrar');
                }
            });
        }

        function fct_mdlComunicacion(id) {
            $('#cbx_expediente').val('');
            $('#cbx_medio').val('');

            $.getJSON('/procesal/expedientes', {
                id: id
            }, function(data) {
                if (data.status === 'success') {
                    IdPersona = id;
                    let $select = $('#cbx_expediente');
                    $select.find('option:not(:first)').remove();

                    $.each(data.data, function(index, expediente) {
                        $select.append(
                            $('<option>', {
                                value: expediente.id_expediente,
                                text: expediente.numero
                            })
                        );
                    });

                    $('#mdlComunicacionProcesal').modal('show');
                }
            }).fail(function(xhr, status, error) {
                console.error('Error en la petición:', error);
            });
        }

        function fct_RegistrarComunicacion() {

            let formData = new FormData();

            formData.append('id_persona', IdPersona);
            formData.append('id_expediente', $('#cbx_expediente').val());
            formData.append('medio', $('#cbx_medio').val());
            formData.append('descripcion', $('#txt_dscComunicacion').val());

            $.ajax({
                url: '/procesal/comunicacion-registrar',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        $('#mdlComunicacionProcesal').modal('hide');
                        toast.success("SISLEPGA", data.Msj);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la petición:', error);
                }
            });
        }

        function limpiarCamposProcesal() {
            $('#cbx_tipoProcesal').val('');
            $('#cbx_tipoPersona').val('');
            $('#cbx_condicion').val('');
            $('#txt_dni').val('');
            $('#txt_nombres').val('');
            $('#txt_apellidoPaterno').val('');
            $('#txt_apellidoMaterno').val('');
            $('#txt_ruc').val('');
            $('#txt_razonSocial').val('');
            $('#txt_telefono').val('');
            $('#txt_email').val('');
            $('#txt_direccion').val('');
            $('#cbx_departamentos').val('');
            $('#cbx_provincias').val('');
            $('#cbx_distritos').val('');
            $('.natural').addClass('d-none');
            $('.juridica').addClass('d-none');
        }

        function showLoaderProcesal() {
            $("#loader_EditarProcesal").show();
        }

        function hideLoaderProcesal() {
            $("#loader_EditarProcesal").hide();
        }
    </script>
@endpush
@push('styles')
    <style>
        .text-sm {
            font-size: 0.875rem;
        }

        .btn-editar {
            padding-right: 5px;
        }
    </style>
@endpush
