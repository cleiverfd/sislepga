@extends('layouts.app')
@section('page_title', 'Equipo')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Equipo</li>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <table class="table table-hover table-bordered" id="tbl_equipo">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th>
                                    <th class="text-nowrap">dni</th>
                                    <th class="text-nowrap">NOMBRES</th>
                                    <th class="text-nowrap">APELLIDO PATERNO</th>
                                    <th class="text-nowrap">APELLIDO MATERNO</th>
                                    <th class="text-nowrap">CARGO</th>
                                    <th class="text-nowrap">CORREO</th>
                                    <th class="text-nowrap">TELEFONO</th>
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
        <div class="modal fade" id="mdlEquipo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalEquipoLabel">Registrar Integrante</h4>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body mb-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="txt_dni" class="mb-1">DNI</label>
                                    <input type="text" class="form-control text-sm" id="txt_dni" maxlength="8" pattern="\d{8}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="txt_nombres" class="mb-1">Nombres</label>
                                    <input type="text" class="form-control" id="txt_nombres">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="txt_apellido_paterno" class="mb-1">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="txt_apellido_paterno">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="txt_apellido_materno" class="mb-1">Apellido Materno</label>
                                    <input type="text" class="form-control" id="txt_apellido_materno">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cbx_cargo" class="mb-1">Cargo</label>
                                    <select class="form-control" id="cbx_cargo">
                                        <option value="" selected disabled>--SELECCIONAR--</option>
                                        <option value="ABOGADO">ABOGADO(A)</option>
                                        <option value="SECRETARIA">SECRETARIA</option>
                                        <option value="PRACTICANTE">PRACTICANTE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="txt_telefono" class="mb-1">Teléfono</label>
                                    <input type="text" class="form-control" id="txt_telefono">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="txt_correo" class="mb-1">Correo</label>
                                    <input type="email" class="form-control" id="txt_correo">
                                </div>
                            </div>
                            {{-- <div class="col-6">
                                <div class="form-group">
                                    <label for="cbx_departamento" class="mb-1">Departamento</label>
                                    <select class="form-control" id="cbx_departamento"></select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cbx_provincia" class="mb-1">Provincia</label>
                                    <select class="form-control" id="cbx_provincia"></select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cbx_distrito" class="mb-1">Distrito</label>
                                    <select class="form-control" id="cbx_distrito"></select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="txt_direccion" class="mb-1">Dirección</label>
                                    <input type="text" class="form-control" id="txt_direccion">
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-success px-3" id="btn_guardarCambios">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@push('scripts')
    <script defer>
        var IdEquipo;
        var tbl_equipo;

        $(document).ready(function() {

            fct_listarTablaEquipos();

            $('#btn_guardarCambios').click(function() {
                if ($('#btn_guardarCambios').hasClass('edit')) {
                    fct_ActualizarIntegrante();
                } else {
                    fct_RegistrarIntegrante();
                }
            });
        });

        function fct_listarTablaEquipos() {
            tbl_equipo = $('#tbl_equipo').DataTable({
                scrollY: '450px',
                scrollX: false,
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
                dom: `<"row mb-2"<"col-6"B><"col-6 btn-new text-right">> <"row mb-2"<"col-6"l><"col-6"f>> <"row mb-2"<"col-12"tr>> <"row"<"col-5"i><"col-7"p>>`,
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
                    },
                    {
                        text: '<i class="fas fa-plus"></i> Nuevo',
                        className: 'btn btn-success rounded-lg d-none new',
                        action: function() {
                            fct_nuevoIntegrante();
                        }
                    }
                ],
                ajax: {
                    url: '/GetEquipo',
                    type: 'GET',
                    cache: true,
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los usuarios:', error);
                    }
                },
                columns: [{
                        data: 'Id',
                        className: 'py-1 text-sm text-center'
                    },
                    {
                        data: 'Dni',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'Nombres',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'ApellidoPaterno',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'ApellidoMaterno',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'Cargo',
                        className: 'py-1 text-sm'
                    },
                    // {
                    //     data: 'Departamento',
                    //     className: 'py-1 text-sm'
                    // },
                    // {
                    //     data: 'Provincia',
                    //     className: 'py-1 text-sm'
                    // },
                    // {
                    //     data: 'Distrito',
                    //     className: 'py-1 text-sm'
                    // },
                    // {
                    //     data: 'Direccion',
                    //     className: 'py-1 text-sm'
                    // },
                    {
                        data: 'Correo',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'Telefono',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'py-1 text-sm text-center',
                        render: function(data, type, row) {

                            let btnEditar = `<button class="btn btn-sm btn-warning ml-1 btn-editar" onclick="fct_editarIntegrante(${data.Id})"><i class="fas fa-edit"></i></button>`;
                            let btnEliminar = `<button class="btn btn-sm btn-danger ml-1" onclick="fct_eliminarIntegrante(${data.Id})"><i class="fas fa-trash"></i></button>`;
                            return btnEditar + btnEliminar;
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

        function fct_nuevoIntegrante() {
            fct_limpiarCamposEquipo();
            $('#mdlEquipo').modal('show');
            $('#modalEquipoLabel').text('Nuevo Integrante');
            $('#btn_guardarCambios').text('Registrar');
            $('#btn_guardarCambios').removeClass('edit');
        }

        function fct_RegistrarIntegrante() {

            let formData = new FormData();

            formData.append('dni', $('#txt_dni').val());
            formData.append('nombres', $('#txt_nombres').val().toUpperCase());
            formData.append('apellido_paterno', $('#txt_apellido_paterno').val().toUpperCase());
            formData.append('apellido_materno', $('#txt_apellido_materno').val().toUpperCase());
            formData.append('cargo', $('#cbx_cargo').val().toUpperCase());
            formData.append('telefono', $('#txt_telefono').val());
            formData.append('correo', $('#txt_correo').val());

            $.ajax({
                url: '/equipo/registrar',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        tbl_equipo.ajax.reload();
                        $('#mdlEquipo').modal('hide');
                        fct_limpiarCamposEquipo();
                        toast.success("SISLEPGA", data.Msj);
                    } else if (data.status === 'error') {
                        toast.error("SISLEPGA", data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la petición:', error);
                }
            });
        }

        function fct_limpiarCamposEquipo() {
            $('#txt_dni').val('');
            $('#txt_nombres').val('');
            $('#txt_apellido_paterno').val('');
            $('#txt_apellido_materno').val('');
            $('#cbx_cargo').val('');
            $('#txt_telefono').val('');
            $('#txt_correo').val('');
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

        function fct_editarIntegrante(id) {
            fct_limpiarCamposEquipo();

            $.getJSON('/equipo/editar/' + id, function(json) {
                if (json.status === 'success') {

                    $('#mdlEquipo').modal('show');
                    $('#modalEquipoLabel').text('Editar Integrante');
                    $('#btn_guardarCambios').text('Guardar Cambios');
                    $('#btn_guardarCambios').addClass('edit');

                    const integrante = json.data;
                    IdEquipo = integrante.Id;
                    $('#txt_dni').val(integrante.Dni);
                    $('#txt_apellido_paterno').val(integrante.ApellidoPaterno);
                    $('#txt_apellido_materno').val(integrante.ApellidoMaterno);
                    $('#txt_nombres').val(integrante.Nombres);
                    $('#cbx_cargo').val(integrante.Cargo);
                    $('#txt_telefono').val(integrante.Telefono);
                    $('#txt_correo').val(integrante.Correo);
                }
            });
        }

        function fct_ActualizarIntegrante() {

            let formData = new FormData();

            formData.append('id', IdEquipo);
            formData.append('dni', $('#txt_dni').val());
            formData.append('nombres', $('#txt_nombres').val().toUpperCase());
            formData.append('apellido_paterno', $('#txt_apellido_paterno').val().toUpperCase());
            formData.append('apellido_materno', $('#txt_apellido_materno').val().toUpperCase());
            formData.append('cargo', $('#cbx_cargo').val().toUpperCase());
            formData.append('telefono', $('#txt_telefono').val());
            formData.append('correo', $('#txt_correo').val());

            $.ajax({
                url: 'equipo/actualizar',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        tbl_equipo.ajax.reload();
                        $('#mdlEquipo').modal('hide');
                        fct_limpiarCamposEquipo();
                        toast.success("SISLEPGA", response.Msj);
                    } else if (response.status === 'error') {
                        toast.error("SISLEPGA", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        }

        function fct_eliminarIntegrante(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/equipo/eliminar',
                        type: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function(data) {
                            if (data.status === 'success') {
                                tbl_equipo.ajax.reload();
                                toast.success("SISLEPGA", data.Msj);
                            } else if (data.status === 'error') {
                                toast.error("SISLEPGA", data.Msj2);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la petición:', error);
                        }
                    });
                }
            });
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
