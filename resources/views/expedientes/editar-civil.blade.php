@extends('layouts.app')
@section('page_title', 'Editar Expediente Civil - Laboral')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/expedientes/civilLaboral') }}">Expedientes</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/expedientes/civilLaboral') }}">Civil - Laboral</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    <div class="overlay" style="display:none;" id="loader_editarCivil">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_numeroCivil">Numero</label>
                                                <input type="text" class="form-control" id="txt_numeroCivil">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_fechaInicioCivil">Fecha de Inicio</label>
                                                <input type="date" class="form-control" id="txt_fechaInicioCivil" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_pretensionesCivil">Pretension</label>
                                                <select class="select2" id="cbx_pretensionesCivil"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_montoPretensionCivil">Monto de Pretension</label>
                                                <input type="number" class="form-control" id="txt_montoPretensionCivil">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_materiasCivil">Materia</label>
                                                <select class="custom-select text-sm" id="cbx_materiasCivil"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_dJudicialesCivil">Distrito Judicial</label>
                                                <select class="select2" id="cbx_dJudicialesCivil"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_instanciasCivil">Instancia</label>
                                                <select class="custom-select text-sm" id="cbx_instanciasCivil"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_especialidadesCivil">Especialidad</label>
                                                <select class="custom-select text-sm" id="cbx_especialidadesCivil"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_juzgadosCivil">Organo Jurisdiccional</label>
                                                <select class="select2" id="cbx_juzgadosCivil"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="cbx_EstadoCivil">Estado Proceso</label>
                                                <select class="custom-select text-sm" id="cbx_EstadoCivil">
                                                    <option value="" disabled>--SELECIONAR--</option>
                                                    <option value="1" selected>EN TRAMITE</option>
                                                    <option value="2">EN EJECUCION</option>
                                                    <option value="3">ARCHIVADO</option>
                                                </select>
                                            </div>
                                        </div>
                                        @include('expedientes.asignar-abogado')
                                    </div>
                                    <div class="row d-none" id="div_MontosCivil">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_montoCivil">Monto Total Sentencia</label>
                                                <input type="number" class="form-control" id="txt_montoCivil">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1" for="txt_saldoCivil">Saldo Total</label>
                                                <input type="number" class="form-control" id="txt_saldoCivil">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <button class="btn btn-success" id="btn_ActualizarCivil">Actualizar Expediente</button>
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
        var IdTipoExpediente = 1;

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
            showLoaderEditarCivil();

            $('#txt_numeroCivil').val(numeroExpediente);
            $('#txt_fechaInicioCivil').val(fechaInicio);
            $('#txt_montoPretensionCivil').val(montoPretension);
            $('#txt_montoCivil').val(totalSentencia);
            $('#txt_saldoCivil').val(saldoTotal);

            if (idEstadoExpediente != 1) {
                $('#div_MontosCivil').removeClass('d-none');
                $('#cbx_EstadoCivil').val(idEstadoExpediente);
            } else {
                $('#div_MontosCivil').addClass('d-none');
            }

            $('#cbx_EstadoCivil').on('change', function() {
                const estado = $(this).val();
                $('#div_MontosCivil').toggleClass('d-none', estado === '1');
            });

            $('#btn_ActualizarCivil').click(function() {
                actualizarExpedienteCivil();
            });

            fct_ListarDatos(IdTipoExpediente);
            Get_Especialidades();

            $('#cbx_dJudicialesCivil').on('change', function() {
                $('#cbx_juzgadosCivil').find('option:not(:first)').remove();
                const selectedId = $(this).val();
                if (selectedId) {
                    Get_Juzgados(IdTipoExpediente, selectedId);
                }
            });

            $('#cbx_dJudicialesCivil').on('select2:clear', function(e) {
                $('#cbx_juzgadosCivil').find('option:not(:first)').remove();
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
            Get_Materias(IdTipoExpediente);
            Get_Instancias(IdTipoExpediente);
            Get_Juzgados(IdTipoExpediente, idDistritoJudicial);
        }

        function Get_Pretensiones(IdTipoExpediente) {
            var $select = $('#cbx_pretensionesCivil');

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

            var $select = $('#cbx_materiasCivil');
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

            var $select = $('#cbx_dJudicialesCivil');

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

            var $select = $('#cbx_instanciasCivil');
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

            var $select = $('#cbx_especialidadesCivil');
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

                    $select = $('#cbx_juzgadosCivil');

                    $select.empty().append('<option value="">--SELECCIONAR--</option>');

                    $.each(data, function(index, item) {
                        $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                    });
                    $select.val(idJuzgado);
                    //$select.trigger('change');

                    hideLoaderEditarCivil();
                },
                error: function() {
                    alert('Error al cargar las pretensiones.');
                }
            });
        }

        function validarFormularioCivil() {
            let errores = [];

            if (!$('#txt_numeroCivil').val().trim()) errores.push('Numero');
            if (!$('#txt_fechaInicioCivil').val()) errores.push('Fecha de Inicio');
            if (!$('#cbx_pretensionesCivil').val()) errores.push('Pretension');
            if (!$('#txt_montoPretensionCivil').val()) errores.push('Monto de Pretension');
            if (!$('#cbx_materiasCivil').val()) errores.push('Materia');
            if (!$('#cbx_dJudicialesCivil').val()) errores.push('Distrito Judicial');
            if (!$('#cbx_instanciasCivil').val()) errores.push('Instancia');
            if (!$('#cbx_especialidadesCivil').val()) errores.push('Especialidad');
            if (!$('#cbx_juzgadosCivil').val()) errores.push('Organo Jurisdiccional');
            if (!$('#cbx_EstadoCivil').val()) errores.push('Estado Proceso');

            if ($('#cbx_EstadoCivil').val() !== '1') {
                if (!$('#txt_montoCivil').val()) errores.push('Monto Total Sentencia');
                if (!$('#txt_saldoCivil').val()) errores.push('Saldo Total');
            }

            if (errores.length > 0) {
                const listaHTML =
                    `<ul style="margin: 0; padding-left: 1.2rem;">${errores.map(e => `<li>${e}</li>`).join('')}</ul>`;

                toast.warning("CAMPOS OBLIGATORIOS", listaHTML);

                return false;
            }

            return true;
        }

        function actualizarExpedienteCivil() {

            if (!validarFormularioCivil()) {
                return;
            }

            const formData = new FormData();

            formData.append('IdExpediente', IdExpediente);
            formData.append('Numero', $('#txt_numeroCivil').val());
            formData.append('Fecha_Inicio', $('#txt_fechaInicioCivil').val());
            formData.append('Id_Pretension', $('#cbx_pretensionesCivil').val());
            formData.append('Monto_Pretension', $('#txt_montoPretensionCivil').val());
            formData.append('Id_Materia', $('#cbx_materiasCivil').val());
            formData.append('Id_DJudicial', $('#cbx_dJudicialesCivil').val());
            formData.append('Id_Instancia', $('#cbx_instanciasCivil').val());
            formData.append('Id_Especialidad', $('#cbx_especialidadesCivil').val());
            formData.append('Id_Juzgado', $('#cbx_juzgadosCivil').val());
            formData.append('Id_Abogado', $('#cbx_Abogado').val());
            formData.append('Id_EstadoExpediente', $('#cbx_EstadoCivil').val());
            formData.append('Id_TipoExpediente', 1);

            if ($('#cbx_EstadoCivil').val() !== '1') {
                formData.append('Monto_Sentencia', $('#txt_montoCivil').val());
                formData.append('Saldo_Total', $('#txt_saldoCivil').val());
            }

            $('#btn_RegistrarCivil').prop('disabled', true).text('Registrando...');

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
            $('#btn_RegistrarCivil').prop('disabled', false).text('Registrar Expediente');
        }

        function showLoaderEditarCivil() {
            $("#loader_editarCivil").show();
        }

        function hideLoaderEditarCivil() {
            $("#loader_editarCivil").hide();
        }
    </script>
@endpush
@push('styles')
    <style>
        #loader_editarCivil {
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
