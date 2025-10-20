@extends('layouts.app')
@section('page_title', 'Registrar Expediente Civil - Laboral')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/expedientes/civilLaboral') }}">Expedientes</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/expedientes/civilLaboral') }}">Civil - Laboral</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Registrar</li>
@endsection
@section('content')
    <div class="overlay" style="display:none;" id="loader_registrarCivil">
        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline" id="procesales">
                <div class="card-header py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 mr-3">DATOS GENERALES</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-1" for="txt_numeroCivil">Numero</label>
                                <input type="email" class="form-control" id="txt_numeroCivil">
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
                            <button class="btn btn-success" id="btn_RegistrarCivil">Registrar Expediente</button>
                        </div>
                    </div>
                </div>
            </div>
            @include('expedientes.registrar-procesales')
        </div>
    </section>
@endsection
@push('scripts')
    <script defer>
        var IdTipoExpediente = 1;
        var IdExpediente = 0;

        $(document).ready(function() {
            showLoaderRegistrar();

            let idExpGuardado = sessionStorage.getItem('IdExpediente');

            $('#cbx_EstadoCivil').on('change', function() {
                const estado = $(this).val();
                $('#div_MontosCivil').toggleClass('d-none', estado === '1');
            });

            $('#btn_RegistrarCivil').click(function() {
                registrarExpedienteCivil();
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

            cargarValoresCivil();
        });

        function fct_ListarDatos(IdTipoExpediente) {
            Get_Pretensiones(IdTipoExpediente);
            Get_DistritosJudiciales(IdTipoExpediente);
            Get_Materias(IdTipoExpediente);
            Get_Instancias(IdTipoExpediente);
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

                $select.trigger('change');
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
                $select.trigger('change');
            });
        }

        function Get_DistritosJudiciales(IdTipoExpediente) {

            var $select = $('#cbx_dJudicialesCivil');

            $select.empty().append('<option value="">--SELECCIONAR--</option>');

            $.getJSON('/GetDistritosJudiciales', function(data) {
                $.each(data, function(index, item) {
                    $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                });

                $select.trigger('change');
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

                $select.trigger('change');
            });
        }

        function Get_Especialidades() {

            var $select = $('#cbx_especialidadesCivil');
            $select.empty().append('<option value="">--SELECCIONAR--</option>');

            $.getJSON('/GetEspecialidades', function(data) {
                $.each(data, function(index, item) {
                    $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                });

                $select.trigger('change');
                hideLoaderRegistrar();
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

                    $select.trigger('change');

                    hideLoaderRegistrar();
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

        function registrarExpedienteCivil() {

            if (!validarFormularioCivil()) {
                return;
            }

            const formData = new FormData();

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
                url: '/expediente/registrar',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        IdExpediente = response.IdExpediente;

                        sessionStorage.setItem('IdExpediente', IdExpediente);

                        toast.success("SISLEPGA", response.Msj);

                        fct_desabilitarCampos();
                        guardarValoresCivil();
                        //fct_limpiarFormularioCivil();
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

        function fct_limpiarFormularioCivil() {
            $('#txt_numeroCivil').val('');
            $('#txt_fechaInicioCivil').val('');
            $('#cbx_pretensionesCivil').val(null).trigger('change');
            $('#txt_montoPretensionCivil').val('');
            $('#cbx_materiasCivil').val('');
            $('#cbx_dJudicialesCivil').val(null).trigger('change');
            $('#cbx_instanciasCivil').val('');
            $('#cbx_especialidadesCivil').val('');
            $('#cbx_juzgadosCivil').val(null).trigger('change');
            $('#cbx_EstadoCivil').val('1').trigger('change');
            $('#txt_montoCivil').val('');
            $('#txt_saldoCivil').val('');
            $('#div_MontosCivil').addClass('d-none');
        }

        function fct_desabilitarCampos() {
            $('#txt_numeroCivil').prop('disabled', true);
            $('#txt_fechaInicioCivil').prop('disabled', true);
            $('#cbx_pretensionesCivil').prop('disabled', true);
            $('#txt_montoPretensionCivil').prop('disabled', true);
            $('#cbx_materiasCivil').prop('disabled', true);
            $('#cbx_dJudicialesCivil').prop('disabled', true);
            $('#cbx_instanciasCivil').prop('disabled', true);
            $('#cbx_especialidadesCivil').prop('disabled', true);
            $('#cbx_juzgadosCivil').prop('disabled', true);
            $('#cbx_Abogado').prop('disabled', true);
            $('#cbx_EstadoCivil').prop('disabled', true);
            $('#txt_montoCivil').prop('disabled', true);
            $('#txt_saldoCivil').prop('disabled', true);

            $('#Monto_Sentencia').prop('disabled', true);
            $('#Saldo_Total').prop('disabled', true);
        }

        function guardarValoresCivil() {
            const campos = [
                'txt_numeroCivil',
                'txt_fechaInicioCivil',
                'cbx_pretensionesCivil',
                'txt_montoPretensionCivil',
                'cbx_materiasCivil',
                'cbx_dJudicialesCivil',
                'cbx_instanciasCivil',
                'cbx_especialidadesCivil',
                'cbx_juzgadosCivil',
                'cbx_Abogado',
                'cbx_EstadoCivil',
                'txt_montoCivil',
                'txt_saldoCivil',
                'Monto_Sentencia',
                'Saldo_Total'
            ];

            campos.forEach(id => {
                const valor = $('#' + id).val();
                sessionStorage.setItem(id, valor);
            });
        }

        function cargarValoresCivil() {
            const campos = [
                'txt_numeroCivil',
                'txt_fechaInicioCivil',
                'cbx_pretensionesCivil',
                'txt_montoPretensionCivil',
                'cbx_materiasCivil',
                'cbx_dJudicialesCivil',
                'cbx_instanciasCivil',
                'cbx_especialidadesCivil',
                'cbx_juzgadosCivil',
                'cbx_Abogado',
                'cbx_EstadoCivil',
                'txt_montoCivil',
                'txt_saldoCivil',
                'Monto_Sentencia',
                'Saldo_Total'
            ];

            let hayDatos = false;

            campos.forEach(id => {
                const valorGuardado = sessionStorage.getItem(id);
                if (valorGuardado !== null && valorGuardado !== '') {
                    const $el = $('#' + id);

                    if ($el.is('select')) {

                        const esperarYSeleccionar = setInterval(() => {
                            const opcionExiste = $el.find('option[value="' + valorGuardado + '"]').length > 0;

                            if (opcionExiste) {

                                $el.val(valorGuardado).trigger('change');
                                clearInterval(esperarYSeleccionar);
                            }
                        }, 300);

                        setTimeout(() => clearInterval(esperarYSeleccionar), 10000);
                    } else {
                        $el.val(valorGuardado);
                    }

                    hayDatos = true;
                }
            });

            if (hayDatos) {
                fct_desabilitarCampos();
            }
        }

        function showLoaderRegistrar() {
            $("#loader_registrarCivil").show();
        }

        function hideLoaderRegistrar() {
            $("#loader_registrarCivil").hide();
        }
    </script>
@endpush
@push('styles')
    <style>
        #loader_registrarCivil {
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
