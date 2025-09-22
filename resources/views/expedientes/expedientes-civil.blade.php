@extends('layouts.app')
@section('page_title', 'Expedientes Civil - Laboral')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/expedientes/civilLaboral') }}">Expedientes</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Civil - Laboral</li>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cbx_estadoExpediente" class="mb-0">ESTADO EXPEDIENTE</label>
                        <select class="custom-select rounded-0" id="cbx_estadoExpediente">
                            <option value="" selected>TODOS</option>
                            <option value="1">EN TRAMITE</option>
                            <option value="2">EN EJECUCION</option>
                            <option value="3">ARCHIVADO</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cbx_estadoExpediente" class="mb-0">PRETENSION</label>
                        <select class="select2 rounded-0" id="cbx_pretensionCivilLista"></select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-hover table-bordered" id="tbl_expedientesCivil">
                                    <thead>
                                        <tr>
                                            <th class="text-nowrap">ID</th>
                                            <th class="text-nowrap">NUMERO</th>
                                            <th class="text-nowrap">FECHA INICIO</th>
                                            <th class="text-nowrap">PRETENSION</th>
                                            <th class="text-nowrap">FECHA REGISTRO</th>
                                            <th class="text-nowrap">ESTADO</th>
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
        </div>
    </section>
    <div class="modal fade" id="mdlCivilDetalle" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalProcesalNuevoLabel">Detalle de Expediente</h4>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" id="bodyModalCivil">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script defer>
        $(document).ready(function() {

            $('#cbx_estadoExpediente').on('change', function() {
                if (tblExpedientesCivil) {
                    tblExpedientesCivil.ajax.reload();
                }
            });

            $('#cbx_pretensionCivilLista').on('change', function() {
                if (tblExpedientesCivil) {
                    tblExpedientesCivil.ajax.reload();
                }
            });

            Get_Pretensiones();
            Get_ListarExpedientes();
        });

        function Get_Pretensiones() {
            $select = $('#cbx_pretensionCivilLista');

            $select.empty().append('<option value="" selected>TODOS</option>');

            $.getJSON('/GetPretensiones', {
                IdTipoExpediente: 1
            }, function(data) {
                $.each(data, function(index, item) {
                    $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                });
            });
        }

        var tblExpedientesCivil;

        function Get_ListarExpedientes() {
            tblExpedientesCivil = $('#tbl_expedientesCivil').DataTable({
                scrollY: '450px',
                //scrollX: true,
                scrollCollapse: true,
                destroy: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: false,
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
                        orientation: 'landscape', 
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    // {
                    //     extend: 'colvis',
                    //     className: 'btn btn-warning mr-2 rounded-lg',
                    //     text: '<i class="fas fa-list"></i>'
                    // },
                    {
                        text: '<i class="fas fa-plus"></i> Nuevo',
                        className: 'btn btn-success rounded-lg d-none new',
                        action: function() {
                            fct_RegistrarExpediente();
                        }
                    }
                ],
                ajax: {
                    url: '/GetExpedientes',
                    type: 'GET',
                    data: function(d) {
                        d.IdTipoExpediente = 1;
                        d.IdEstadoExpediente = $('#cbx_estadoExpediente').val();
                        d.IdPretension = $('#cbx_pretensionCivilLista').val();
                    },
                    error: function(xhr, status, error) {
                        toast.error("ERROR", error);
                        console.error('Error al cargar los expedientes:', error);
                    }
                },
                columns: [{
                        data: 'Id',
                        className: 'py-1 text-center text-sm',
                        orderable: true
                    },
                    {
                        data: 'Numero',
                        className: 'py-1 pl-3 text-sm text-nowrap',
                        orderable: false
                    },
                    {
                        data: 'FechaInicio',
                        className: 'py-1 pl-3 text-sm',
                        orderable: false
                    },
                    {
                        data: 'Pretension',
                        className: 'py-1 pl-3 text-sm',
                        orderable: false
                    },
                    {
                        data: 'FechaRegistro',
                        className: 'py-1 pl-3 text-sm text-nowrap',
                        orderable: false
                    },
                    {
                        data: null,
                        className: 'py-1 pl-3 text-sm text-nowrap',
                        orderable: false,
                        render: function(data, type, row) {
                            var idEstado = data.IdEstadoExpediente;

                            var badge = '';

                            if (idEstado === 1) {
                                badge = `<span class="badge badge-warning py-1 px-2">${data.EstadoExpediente}</span>`;
                            } else if (idEstado === 2) {
                                badge = `<span class="badge badge-success py-1 px-2">${data.EstadoExpediente}</span>`;
                            } else if (idEstado === 3) {
                                badge = `<span class="badge badge-danger py-1 px-2">${data.EstadoExpediente}</span>`;
                            }

                            return badge;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'py-1 text-center text-sm text-nowrap',
                        render: function(data, type, row) {
                            let btnDetalle = `<button class="btn btn-sm btn-info btn-detalle" onclick="fct_DetalleExpediente(${data.Id})"><i class="fas fa-eye"></i></button>`;
                            let btnEditar = `<button class="btn btn-sm btn-warning ml-1 btn-editar" onclick="fct_EditarExpediente(${data.Id})"><i class="fas fa-edit"></i></button>`;
                            return btnDetalle + btnEditar;
                        }
                    }
                ],
                lengthMenu: [
                    [25, 50, , 100, -1],
                    [25, 50, 100, "Todos"]
                ],
                pageLength: 100,
                order: [
                    [0, 'desc']
                ],
                initComplete: function() {

                    $('.new').removeClass('d-none');
                    let $nuevo = $('.new').detach();
                    $('.btn-new').append($nuevo);

                    $('.buttons-copy').removeClass().addClass('btn btn-secondary mr-2 rounded-lg');
                    $('.buttons-excel').removeClass().addClass('btn btn-success mr-2 rounded-lg');
                    $('.buttons-pdf').removeClass().addClass('btn btn-danger mr-2 rounded-lg');

                }
            });
        }

        function fct_RegistrarExpediente() {
            window.open('/expedientes/civil-laboral/registrar', '_blank');
        }

        function fct_DetalleExpediente(Id) {
            $.ajax({
                url: `/expedientes/civil-laboral/detalle/${Id}`,
                type: 'GET',
                success: function(html) {
                    $('#bodyModalCivil').html(html);
                    $('#mdlCivilDetalle').modal('show');
                    fct_listarTablaProcesalesExpediente(Id);
                },
                error: function() {
                    alert('Error al cargar el detalle');
                }
            });
        }

        function fct_EditarExpediente(Id_Expediente) {
            window.open(`/expedientes/civil-laboral/editar/${Id_Expediente}`, '_blank');
        }

        function fct_listarTablaProcesalesExpediente(IdExpediente) {
            $('#tbl_DetalleExpedienteProcesales').DataTable({
                scrollY: '350px',
                // scrollX: true,
                scrollCollapse: true,
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
                destroy: true,
                dom: `<"row mb-2"<"col-6"l><"col-6"f>> <"row mb-2"<"col-12"tr>>`,
                ajax: {
                    url: '/ListarProcesales',
                    type: 'POST',
                    data: function(d) {
                        d.IdExpediente = IdExpediente;
                    },
                    error: function(xhr, status, error) {
                        toast.error("ERROR", error);
                        console.error('Error al cargar procesales:', error);
                    }
                },
                columns: [{
                        data: 'IdProcesal',
                        className: 'py-1 text-center text-sm'
                    },
                    {
                        data: 'TipoProcesal',
                        className: 'py-1 pl-3 text-sm text-nowrap'
                    },
                    {
                        data: 'TipoPersona',
                        className: 'py-1 pl-3 text-sm'
                    },
                    {
                        data: 'Condicion',
                        className: 'py-1 pl-3 text-sm'
                    },
                    {
                        data: 'DatosProcesal',
                        className: 'py-1 pl-3 text-sm text-nowrap'
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                pageLength: -1
            });
        }
    </script>
@endpush
@push('styles')
    <style>
        .text-sm {
            font-size: 0.875rem;
        }

        .btn-detalle {
            padding-left: 6.5px;
            padding-right: 6.5px;
        }

        .btn-editar {
            padding-right: 5px;
        }
    </style>
@endpush
