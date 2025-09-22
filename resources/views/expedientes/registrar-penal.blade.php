@extends('layouts.app')
@section('page_title', 'Registrar Expediente Penal')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/expedientes/penal') }}">Expedientes</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/expedientes/penal') }}">Penal</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Registrar</li>
@endsection
@section('content')
    <div class="overlay" style="display:none;" id="loader_registrarPenal">
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
                                <label class="mb-1" for="txt_carpetaFiscal">Carpeta Fiscal</label>
                                <input type="email" class="form-control" id="txt_carpetaFiscal">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-1" for="txt_numeroPenal">Numero</label>
                                <input type="email" class="form-control" id="txt_numeroPenal">
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-1" for="txt_montoPretensionPenal">Monto de Reparacion Civil</label>
                                <input type="number" class="form-control" id="txt_montoPretensionPenal">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-1" for="cbx_dJudicialesPenal">Distrito Judicial/Penal/Fiscal</label>
                                <select class="select2" id="cbx_dJudicialesPenal"></select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-1" for="cbx_Fiscalias">Fiscalia</label>
                                <select class="select2" id="cbx_Fiscalias"></select>
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
                        @include('expedientes.asignar-abogado')
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
                            <button class="btn btn-success" id="btn_RegistrarPenal">Registrar Expediente</button>
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
        var IdTipoExpediente = 2;
        var IdExpediente = 0;

        $(document).ready(function() {
            showLoaderRegistrarPenal();

            let idExpGuardado = sessionStorage.getItem('IdExpediente');

            $('#cbx_EstadoPenal').on('change', function() {
                const estado = $(this).val();
                $('#div_MontosPenal').toggleClass('d-none', estado === '1');
            });

            $('#btn_RegistrarPenal').click(function() {
                registrarExpedientePenal();
            });

            fct_ListarDatos(IdTipoExpediente);

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

            cargarValoresPenal();
        });

        function fct_ListarDatos(IdTipoExpediente) {
            Get_Pretensiones(IdTipoExpediente);
            Get_DistritosJudiciales(IdTipoExpediente);
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

                $select.trigger('change');
            });
        }

        function Get_DistritosJudiciales(IdTipoExpediente) {

            var $select = $('#cbx_dJudicialesPenal');

            $select.empty().append('<option value="">--SELECCIONAR--</option>');

            $.getJSON('/GetDistritosJudiciales', function(data) {
                $.each(data, function(index, item) {
                    $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                });

                $select.trigger('change');
                hideLoaderRegistrarPenal();
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

                    $select.trigger('change');
                },
                error: function() {
                    alert('Error al cargar las pretensiones.');
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

                    $select = $('#cbx_Fiscalias');

                    $select.empty().append('<option value="">--SELECCIONAR--</option>');

                    $.each(data, function(index, item) {
                        $select.append(`<option value="${item.Id}">${item.Descripcion}</option>`);
                    });

                    $select.trigger('change');

                    hideLoaderRegistrarPenal();
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
            if (!$('#cbx_Fiscalias').val()) errores.push('Fiscalia');
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

        function registrarExpedientePenal() {

            if (!validarFormularioPenal()) {
                return;
            }

            const formData = new FormData();

            formData.append('Carpeta', $('#txt_carpetaFiscal').val());
            formData.append('Numero', $('#txt_numeroPenal').val());
            formData.append('Fecha_Inicio', $('#txt_fechaInicioPenal').val());
            formData.append('Id_Pretension', $('#cbx_pretensionesPenal').val());
            formData.append('Monto_Pretension', $('#txt_montoPretensionPenal').val());
            formData.append('Id_DJudicial', $('#cbx_dJudicialesPenal').val());
            formData.append('Id_Fiscalia', $('#cbx_Fiscalias').val());
            formData.append('Id_Juzgado', $('#cbx_juzgadosPenal').val());
            formData.append('Id_Abogado', $('#cbx_Abogado').val());
            formData.append('Id_EstadoExpediente', $('#cbx_EstadoPenal').val());
            formData.append('Id_TipoExpediente', IdTipoExpediente);

            if ($('#cbx_EstadoPenal').val() !== '1') {
                formData.append('Monto_Sentencia', $('#txt_montoPenal').val());
                formData.append('Saldo_Total', $('#txt_saldoPenal').val());
            }

            $('#btn_RegistrarPenal').prop('disabled', true).text('Registrando...');

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

                        toast.success("SISGE", response.Msj);

                        fct_desabilitarCampos();
                        guardarValoresPenal();
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISGE", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
            $('#btn_RegistrarPenal').prop('disabled', false).text('Registrar Expediente');
        }

        function fct_desabilitarCampos() {
            $('#txt_carpetaFiscal').prop('disabled', true);
            $('#txt_numeroPenal').prop('disabled', true);
            $('#txt_fechaInicioPenal').prop('disabled', true);
            $('#cbx_pretensionesPenal').prop('disabled', true);
            $('#txt_montoPretensionPenal').prop('disabled', true);
            $('#cbx_dJudicialesPenal').prop('disabled', true);
            $('#cbx_Fiscalias').prop('disabled', true);
            $('#cbx_juzgadosPenal').prop('disabled', true);
            $('#cbx_Abogado').prop('disabled', true);
            $('#cbx_EstadoPenal').prop('disabled', true);
            $('#txt_montoPenal').prop('disabled', true);
            $('#txt_saldoPenal').prop('disabled', true);

            $('#Monto_Sentencia').prop('disabled', true);
            $('#Saldo_Total').prop('disabled', true);
        }

        function guardarValoresPenal() {
            const campos = [
                'txt_carpetaFiscal',
                'txt_numeroPenal',
                'txt_fechaInicioPenal',
                'cbx_pretensionesPenal',
                'txt_montoPretensionPenal',
                'cbx_dJudicialesPenal',
                'cbx_Fiscalias',
                'cbx_juzgadosPenal',
                'cbx_Abogado',
                'cbx_EstadoPenal',
                'txt_montoPenal',
                'txt_saldoPenal',
                'Monto_Sentencia',
                'Saldo_Total'
            ];

            campos.forEach(id => {
                const valor = $('#' + id).val();
                sessionStorage.setItem(id, valor);
            });
        }

        function cargarValoresPenal() {
            const campos = [
                'txt_carpetaFiscal',
                'txt_numeroPenal',
                'txt_fechaInicioPenal',
                'cbx_pretensionesPenal',
                'txt_montoPretensionPenal',
                'cbx_dJudicialesPenal',
                'cbx_Fiscalias',
                'cbx_juzgadosPenal',
                'cbx_Abogado',
                'cbx_EstadoPenal',
                'txt_montoPenal',
                'txt_saldoPenal',
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

        function showLoaderRegistrarPenal() {
            $("#loader_registrarPenal").show();
        }

        function hideLoaderRegistrarPenal() {
            $("#loader_registrarPenal").hide();
        }
    </script>
@endpush
@push('styles')
    <style>
        #loader_registrarPenal {
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
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
@endpush
