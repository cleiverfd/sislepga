@extends('layouts.app')
@section('page_title', 'Usuarios')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-bordered" id="tbl_usuarios">
                        <thead>
                            <tr>
                                <th class="text-sm">ID</th>
                                <th class="text-sm">NOMBRE</th>
                                <th class="text-sm">EMAIL</th>
                                <th class="text-sm">CREACIÓN</th>
                                <th class="text-sm">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="mdl-registrar-usuario">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Usuario</h4>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="txt_dni">DNI</label>
                        <input type="text" class="form-control" id="txt_dni">
                    </div>
                    <div class="form-group">
                        <label for="txt_nombre">Nombre</label>
                        <input type="text" class="form-control" id="txt_nombre">
                    </div>
                    <div class="form-group">
                        <label for="txt_email">Email</label>
                        <input type="email" class="form-control" id="txt_email">
                    </div>
                    <div class="form-group">
                        <label for="cbx_rolUsuario">ROL</label>
                        <select class="custom-select" id="cbx_rolUsuario">
                            <option value="" selected disabled>--SELECCIONAR--</option>
                            <option value="ABOGADO">ABOGADO(A)</option>
                            <option value="SECRETARIA">SECRETARIA</option>
                            <option value="PRACTICANTE">PRACTICANTE</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-primary" id="btn_registrarUsuario">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdl-editar-usuario">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Usuario</h4>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="txt_edtDni">DNI</label>
                        <input type="text" class="form-control" id="txt_edtDni">
                    </div>
                    <div class="form-group">
                        <label for="txt_edtNombre">Nombre</label>
                        <input type="text" class="form-control" id="txt_edtNombre">
                    </div>
                    <div class="form-group">
                        <label for="txt_edtEmail">Email</label>
                        <input type="email" class="form-control" id="txt_edtEmail">
                    </div>
                    <div class="form-group">
                        <label for="cbx_edtRol">ROL</label>
                        <select class="custom-select" id="cbx_edtRol">
                            <option value="" selected disabled>--SELECCIONAR--</option>
                            <option value="ABOGADO">ABOGADO(A)</option>
                            <option value="SECRETARIA">SECRETARIA</option>
                            <option value="PRACTICANTE">PRACTICANTE</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-primary" id="btn_editarUsuario">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdl-recursos-sistema">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Recursos Sistema</h4>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-bordered" id="tbl_recursos_sistema">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="chkAllPermisos">
                                        <label for="chkAllPermisos">
                                        </label>
                                    </div>
                                </th>
                                <th>DESCRIPCION</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-primary" onclick="fct_GuardarPermisos()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script defer>
        var IdUsuario;

        $(document).ready(function() {

            let table = $('#tbl_usuarios').DataTable({
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
                    // {
                    //     extend: 'colvis',
                    //     text: '<i class="fas fa-list"></i>',
                    //     className: 'btn btn-warning dropdown-toggle btn-colvis',
                    // },
                    {
                        text: '<i class="fas fa-plus"></i> Nuevo',
                        className: 'btn btn-success rounded-lg d-none new',
                        action: function() {
                            $('#mdl-registrar-usuario').modal('show');
                        }
                    }
                ],
                ajax: {
                    url: '/GetUsuarios',
                    type: 'GET',
                    cache: true,
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los usuarios:', error);
                    }
                },
                columns: [{
                        data: 'Id',
                        className: 'py-1 text-center text-sm'
                    },
                    {
                        data: 'Nombre',
                        className: 'py-1 pl-3 text-sm'
                    },
                    {
                        data: 'Email',
                        className: 'py-1 pl-3 text-sm'
                    },
                    {
                        data: 'FechaRegistro',
                        className: 'py-1 pl-3 text-center text-sm'
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'py-1 pl-3 text-center text-sm',
                        render: function(data, type, row) {

                            let btnPermisos = `<button class="btn btn-sm btn-primary" onclick="fct_permisosUsuario(${data.Id})"><i class="fas fa-lock"></i></button>`;
                            let btnEditar = `<button class="btn btn-sm btn-warning ml-1 btn-editar" onclick="fct_GetEditarUsuario(${data.Id})"><i class="fas fa-edit"></i></button>`;
                            let btnEliminar = `<button class="btn btn-sm btn-danger ml-1" onclick="fct_eliminarUsuario(${data.Id})"><i class="fas fa-trash"></i></button>`;
                            return btnPermisos + btnEditar + btnEliminar;
                        }
                    }
                ],
                initComplete: function() {
                    $('.new').removeClass('d-none');
                    let $nuevo = $('.new').detach();
                    $('.btn-new').append($nuevo);
                }
            });

            $('#btn_registrarUsuario').on('click', function() {
                fct_registrarUsuario();
            });

            $('#btn_editarUsuario').on('click', function() {
                fct_editarUsuario();
            });

        });

        $(document).on('change', '#chkAllPermisos', function() {
            let checked = $(this).is(':checked');
            $('.permiso-checkbox').prop('checked', checked);
        });

        // Sincronizar checkbox maestro si cambian los individuales
        $(document).on('change', '.permiso-checkbox', function() {
            let total = $('.permiso-checkbox').length;
            let marcados = $('.permiso-checkbox:checked').length;
            $('#chkAllPermisos').prop('checked', total === marcados);
        });

        function fct_registrarUsuario() {
            let formData = new FormData();

            formData.append('dni', $('#txt_dni').val().trim());
            formData.append('nombre', $('#txt_nombre').val().trim());
            formData.append('email', $('#txt_email').val().trim());
            formData.append('rol', $('#cbx_rolUsuario').val().trim());

            $.ajax({
                url: '/usuario/registrar',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#mdl-registrar-usuario').modal('hide');
                    $('#tbl_usuarios').DataTable().ajax.reload();
                    $('#txt_dni').val('');
                    $('#txt_nombre').val('');
                    $('#txt_email').val('');
                    $('#cbx_rolUsuario').val('');
                    toast.success("SISGE", response.Msj);
                },
                error: function(xhr) {
                    console.error('Error al registrar usuario:', xhr.responseText);
                }
            });
        }

        function fct_GetEditarUsuario(Id) {
            $.getJSON('/Get_EditarUsuario', {
                IdUsuario: Id
            }, function(response) {
                if (response.status === 'success') {
                    var data = response.data[0];

                    $('#mdl-editar-usuario').modal('show');
                    $('#txt_edtDni').val(data.dni);
                    $('#txt_edtNombre').val(data.nombre);
                    $('#txt_edtEmail').val(data.email);
                    $('#cbx_edtRol').val(data.rol);
                    IdUsuario = data.id;
                }
            });
        }

        function fct_editarUsuario() {
            let formData = new FormData();

            formData.append('IdUsuario', IdUsuario);
            formData.append('Dni', $('#txt_edtDni').val().trim());
            formData.append('Nombre', $('#txt_edtNombre').val().trim());
            formData.append('Correo', $('#txt_edtEmail').val().trim());
            formData.append('Rol', $('#cbx_edtRol').val().trim());

            $.ajax({
                url: '/usuario/editar',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#mdl-editar-usuario').modal('hide');
                    $('#tbl_usuarios').DataTable().ajax.reload();
                    $('#txt_dni').val('');
                    $('#txt_nombre').val('');
                    $('#txt_email').val('');
                    $('#cbx_rolUsuario').val('');
                    toast.success("SISGE", response.Msj);
                },
                error: function(xhr) {
                    console.error('Error al registrar usuario:', xhr.responseText);
                }
            });
        }

        function fct_eliminarUsuario(Id) {

            let formData = new FormData();
            formData.append('IdUsuario', Id);

            Swal.fire({
                title: '¿Estás seguro que desea eliminar este usuario?',
                text: "Esta acción no se podra revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/usuario/eliminar',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#tbl_usuarios').DataTable().ajax.reload();
                                toast.success("SISGE", response.Msj);
                            }
                        },
                        error: function(xhr) {
                            console.error('Error al eliminar usuario:', xhr.responseText);
                            toast.danger("SISGE", xhr.responseText);
                        }
                    });
                }
            });
        }

        function fct_permisosUsuario(id) {
            $('#mdl-recursos-sistema').modal('show');
            fct_listarRecursosSistema(id);
        }

        function fct_listarRecursosSistema(id) {
            IdUsuario = id;
            let $tbody = $('#tbl_recursos_sistema tbody');
            $tbody.empty();

            $.ajax({
                url: '/GetRecursosSistema',
                type: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    response.data.forEach(function(item) {
                        let $tr = $('<tr>');

                        // Checkbox
                        let $tdCheck = $('<td>').addClass('text-center align-middle');
                        let $divCheck = $('<div>').addClass('icheck-primary d-inline');
                        let $input = $('<input>', {
                            type: 'checkbox',
                            id: `permiso_${item.id}`,
                            class: 'permiso-checkbox',
                            'data-id': item.id
                        }).prop('checked', item.permiso);
                        let $label = $('<label>', {
                            for: `permiso_${item.id}`
                        });

                        $divCheck.append($input, $label);
                        $tdCheck.append($divCheck);

                        // Descripción
                        let $tdDesc = $('<td>').text(item.descripcion);

                        $tr.append($tdCheck, $tdDesc);
                        $tbody.append($tr);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar los recursos:', error);
                }

            });
        }

        function fct_GuardarPermisos() {
            let permisos = [];
            $('.permiso-checkbox:checked').each(function() {
                permisos.push($(this).data('id'));
            });

            let formData = new FormData();
            formData.append('IdUsuario', IdUsuario);
            permisos.forEach(id => {
                formData.append('Permisos[]', id); // importante: Permisos[]
            });

            $.ajax({
                url: '/usuario/asignarRecursos',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#mdl-recursos-sistema').modal('hide');
                    toast.success("SISGE", response.Msj);
                },
                error: function(xhr) {
                    console.error('Error al guardar permisos:', xhr.responseText);
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

        tbody tr td {
            align-items: center !important;
        }
    </style>
@endpush
