@extends('layouts.app')
@section('page_title', 'Editar Expediente Penal')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/expedientes/penal') }}">Expedientes</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/expedientes/penal') }}">Penal</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    <div class="overlay" style="display:none;" id="loader_editarPenal">
        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
    </div>
    <section class="content">
        <input type="hidden" name="expediente_id" id="expediente_id" value="{{ $expediente['id'] }}">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">EXPEDIENTE</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">ARCHIVOS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">TAREAS</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">REVISIONES</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">OFICIOS E INFORMES</a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_carpetaFiscal">Carpeta Fiscal</label>
                                                <input type="email" class="form-control" id="txt_carpetaFiscal">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_numeroPenal">Numero</label>
                                                <input type="text" class="form-control" id="txt_numeroPenal">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_fechaInicioPenal">Fecha de Inicio</label>
                                                <input type="date" class="form-control" id="txt_fechaInicioPenal" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_pretensionesPenal">Delito</label>
                                                <select class="select2" id="cbx_pretensionesPenal"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_montoPretensionPenal">Monto de Reparacion Civil</label>
                                                <input type="number" class="form-control" id="txt_montoPretensionPenal">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_dJudicialesPenal">Distrito Judicial/Penal/Fiscal</label>
                                                <select class="select2" id="cbx_dJudicialesPenal"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_Fiscalia">Fiscalia</label>
                                                <select class="select2" id="cbx_Fiscalia"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_juzgadosPenal">Sala Penal/Juzgado</label>
                                                <select class="select2" id="cbx_juzgadosPenal"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_EstadoPenal">Estado Proceso</label>
                                                <select class="custom-select text-sm" id="cbx_EstadoPenal">
                                                    <option value="" disabled>--SELECIONAR--</option>
                                                    <option value="1" selected>EN TRAMITE</option>
                                                    <option value="2">EN EJECUCION</option>
                                                    <option value="3">ARCHIVADO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-none" id="div_MontosPenal">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_montoPenal">Monto Total Sentencia</label>
                                                <input type="number" class="form-control" id="txt_montoPenal">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_saldoPenal">Saldo Total</label>
                                                <input type="number" class="form-control" id="txt_saldoPenal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <button class="btn btn-success" id="btn_ActualizarPenal">Actualizar Expediente</button>
                                        </div>
                                    </div>
                                    @include('expedientes.registrar-procesales')
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                    @include('expedientes.expediente-archivos')
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                    @include('expedientes.expediente-tareas')
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                    @include('expedientes.expediente-revisiones')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script defer>
        var IdTipoExpediente = 2;

        var IdExpediente = '{{ $expediente['id'] ?? '' }}';
        sessionStorage.setItem('IdExpediente', IdExpediente);
        const numeroExpediente = '{{ $expediente['numero'] ?? '' }}';
        const carpetaFiscal = '{{ $expediente['carpeta_fiscal'] ?? '' }}';
        const contratoReferencia = '{{ $expediente['contrato_referencia'] ?? '' }}';
        const fechaInicio = '{{ $expediente['fecha_inicio'] ?? '' }}';
        const idPretension = '{{ $expediente['id_pretension'] ?? '' }}';
        const idMateria = '{{ $expediente['id_materia'] ?? '' }}';
        const idDistritoJudicial = '{{ $expediente['id_distrito_judicial'] ?? '' }}';
        const idInstancia = '{{ $expediente['id_instancia'] ?? '' }}';
        const idEspecialidad = '{{ $expediente['id_especialidad'] ?? '' }}';
        const idJuzgado = '{{ $expediente['id_juzgado'] ?? '' }}';
        const idFiscalia = '{{ $expediente['id_fiscalia'] ?? '' }}';
        const idAbogado = '{{ $expediente['id_abogado'] ?? '' }}';
        const idEstadoExpediente = '{{ $expediente['id_estado_expediente'] ?? '' }}';
        const estadoExpediente = '{{ $expediente['estado_expediente'] ?? '' }}';
        const idTipoExpediente = '{{ $expediente['id_tipo_expediente'] ?? '' }}';
        const montoPretension = '{{ $expediente['monto_pretension'] ?? '' }}';
        const totalSentencia = '{{ $expediente['total_sentencia'] ?? '' }}';
        const saldoTotal = '{{ $expediente['saldo_total'] ?? '' }}';
        const fechaRegistro = '{{ $expediente['fecha_registro'] ?? '' }}';
        const fechaActualizacion = '{{ $expediente['fecha_actualizacion'] ?? '' }}';

        $(document).ready(function() {
            showLoaderEditarPenal();

            $('#txt_carpetaFiscal').val(carpetaFiscal);
            $('#txt_numeroPenal').val(numeroExpediente);
            $('#txt_fechaInicioPenal').val(fechaInicio);
            $('#txt_montoPretensionPenal').val(montoPretension);
            $('#txt_montoPenal').val(totalSentencia);
            $('#txt_saldoPenal').val(saldoTotal);

            if (idEstadoExpediente != 1) {
                $('#div_MontosPenal').removeClass('d-none');
                $('#cbx_EstadoPenal').val(idEstadoExpediente);
            } else {
                $('#div_MontosPenal').addClass('d-none');
            }

            $('#cbx_EstadoPenal').on('change', function() {
                const estado = $(this).val();
                $('#div_MontosPenal').toggleClass('d-none', estado === '1');
            });

            $('#btn_ActualizarPenal').click(function() {
                actualizarExpedientePenal();
            });

            fct_ListarDatos(IdTipoExpediente);
            Get_Especialidades();

            $('#cbx_dJudicialesPenal').on('change', function() {
                $('#cbx_juzgadosPenal').find('option:not(:first)').remove();
                const selectedId = $(this).val();
                if (selectedId) {
                    Get_Juzgados(IdTipoExpediente, selectedId);
                    Get_Fiscalias(IdTipoExpediente, selectedId);
                }
            });

            $('#cbx_dJudicialesPenal').on('select2:clear', function(e) {
                $('#cbx_juzgadosPenal').find('option:not(:first)').remove();
            });

        });

        function setSelectValue(idSelector, value) {
            if (value) {
                $(idSelector).val(value).trigger('change');
            }
        }

        function fct_ListarDatos(IdTipoExpediente) {
            Get_Pretensiones(IdTipoExpediente);
            Get_DistritosJudiciales(IdTipoExpediente);
            Get_Fiscalias(IdTipoExpediente, idDistritoJudicial);
            Get_Juzgados(IdTipoExpediente, idDistritoJudicial);
        }

        function Get_Pretensiones(IdTipoExpediente) {
            var $select = $('#cbx_pretensionesPenal');

            $select.empty().append('<option value="">--SELECCIONAR--</option>');

            $.getJSON('/GetPretensiones', {
                IdTipoExpediente: IdTipoExpediente
            }, function(data) {
                $.each(data, function(index, item) {
                    $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                });
                $select.val(idPretension);
                //$select.trigger('change');
            });
        }

        function Get_Materias(IdIdTipoExpediente) {

            var $select = $('#cbx_materiasPenal');
            $select.empty().append('<option value="">--SELECCIONAR--</option>');

            $.getJSON('/GetMaterias', {
                IdTipoExpediente: IdIdTipoExpediente
            }, function(data) {
                $.each(data, function(index, item) {
                    $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                });
                //$select.trigger('change');
                $select.val(idMateria);
            });


        }

        function Get_DistritosJudiciales(IdTipoExpediente) {

            var $select = $('#cbx_dJudicialesPenal');

            $select.empty().append('<option value="">--SELECCIONAR--</option>');

            $.getJSON('/GetDistritosJudiciales', function(data) {
                $.each(data, function(index, item) {
                    $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                });
                $select.val(idDistritoJudicial);
                //$select.trigger('change');
            });
        }

        function Get_Instancias(IdTipoExpediente) {

            var $select = $('#cbx_instanciasPenal');
            $select.empty().append('<option value="">--SELECCIONAR--</option>');

            $.getJSON('/GetInstancias', {
                IdTipoExpediente: IdTipoExpediente
            }, function(data) {
                $.each(data, function(index, item) {
                    $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                });
                $select.val(idInstancia);
                //$select.trigger('change');
            });
        }

        function Get_Especialidades() {

            var $select = $('#cbx_especialidadesPenal');
            $select.empty().append('<option value="">--SELECCIONAR--</option>');

            $.getJSON('/GetEspecialidades', function(data) {
                $.each(data, function(index, item) {
                    $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                });
                $select.val(idEspecialidad);
                //$select.trigger('change');
            });
        }

        function Get_Juzgados(IdTipoExpediente, IdDJudicial) {
            $.ajax({
                url: '/GetJuzgados',
                type: 'GET',
                data: {
                    IdTipoExpediente: IdTipoExpediente,
                    IdDJudicial: IdDJudicial
                },
                dataType: 'json',
                success: function(data) {

                    $select = $('#cbx_juzgadosPenal');

                    $select.empty().append('<option value="">--SELECCIONAR--</option>');

                    $.each(data, function(index, item) {
                        $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                    });
                    $select.val(idJuzgado);
                    //$select.trigger('change');

                    hideLoaderEditarPenal();
                },
                error: function() {
                    alert('Error al cargar las pretensiones.');
                    hideLoaderEditarPenal();
                }
            });
        }

        function Get_Fiscalias(IdTipoExpediente, IdDJudicial) {
            $.ajax({
                url: '/GetFiscalias',
                type: 'GET',
                data: {
                    IdTipoExpediente: IdTipoExpediente,
                    IdDJudicial: IdDJudicial
                },
                dataType: 'json',
                success: function(data) {

                    $select = $('#cbx_Fiscalia');

                    $select.empty().append('<option value="">--SELECCIONAR--</option>');

                    $.each(data, function(index, item) {
                        $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                    });
                    $select.val(idFiscalia);
                    //$select.trigger('change');
                },
                error: function() {
                    alert('Error al cargar las pretensiones.');
                }
            });
        }

        function validarFormularioPenal() {
            let errores = [];

            if (!$('#txt_numeroPenal').val().trim()) errores.push('Numero');
            if (!$('#txt_fechaInicioPenal').val()) errores.push('Fecha de Inicio');
            if (!$('#cbx_pretensionesPenal').val()) errores.push('Pretension');
            if (!$('#txt_montoPretensionPenal').val()) errores.push('Monto de Pretension');
            if (!$('#cbx_dJudicialesPenal').val()) errores.push('Distrito Judicial');
            if (!$('#cbx_Fiscalia').val()) errores.push('Fiscalia');
            if (!$('#cbx_juzgadosPenal').val()) errores.push('Organo Jurisdiccional');
            if (!$('#cbx_EstadoPenal').val()) errores.push('Estado Proceso');

            if ($('#cbx_EstadoPenal').val() !== '1') {
                if (!$('#txt_montoPenal').val()) errores.push('Monto Total Sentencia');
                if (!$('#txt_saldoPenal').val()) errores.push('Saldo Total');
            }

            if (errores.length > 0) {
                const listaHTML =
                    `<ul style="margin: 0; padding-left: 1.2rem;">${errores.map(e => `<li>${e}</li>`).join('')}</ul>`;

                toast.warning("CAMPOS OBLIGATORIOS", listaHTML);

                return false;
            }

            return true;
        }

        function actualizarExpedientePenal() {

            if (!validarFormularioPenal()) {
                return;
            }

            const formData = new FormData();

            formData.append('IdExpediente', IdExpediente);
            formData.append('Carpeta', $('#txt_carpetaFiscal').val());
            formData.append('Numero', $('#txt_numeroPenal').val());
            formData.append('Fecha_Inicio', $('#txt_fechaInicioPenal').val());
            formData.append('Id_Pretension', $('#cbx_pretensionesPenal').val());
            formData.append('Monto_Pretension', $('#txt_montoPretensionPenal').val());
            formData.append('Id_DJudicial', $('#cbx_dJudicialesPenal').val());
            formData.append('Id_Juzgado', $('#cbx_juzgadosPenal').val());
            formData.append('Id_EstadoExpediente', $('#cbx_EstadoPenal').val());
            formData.append('Id_TipoExpediente', 1);

            if ($('#cbx_EstadoPenal').val() !== '1') {
                formData.append('Monto_Sentencia', $('#txt_montoPenal').val());
                formData.append('Saldo_Total', $('#txt_saldoPenal').val());
            }

            $('#btn_RegistrarPenal').prop('disabled', true).text('Registrando...');

            $.ajax({
                url: '/expediente/actualizar',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        toast.success("SISLEPGA", response.Msj);
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISLEPGA", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
            $('#btn_RegistrarPenal').prop('disabled', false).text('Registrar Expediente');
        }

        function showLoaderEditarPenal() {
            $("#loader_editarPenal").show();
        }

        function hideLoaderEditarPenal() {
            $("#loader_editarPenal").hide();
        }
    </script>
@endpush
@push('styles')
    <style>
        #loader_editarPenal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0,0,0,0.5);
        }
    </style>
@endpush