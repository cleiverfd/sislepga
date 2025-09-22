@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid mb-4">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-gradient-primary elevation-2">
                            <i class="fas fa-folder"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Expedientes</span>
                            <span class="info-box-number" id="totalExpedientes">0<small>expedientes</small></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-gradient-warning elevation-2">
                            <i class="fas fa-clock"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">En Tramite</span>
                            <span class="info-box-number" id="totalTramite">0<small>expedientes</small></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-gradient-success elevation-2">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">En Ejecucion</span>
                            <span class="info-box-number" id="totalEjecucion">0<small>expedientes</small></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-gradient-danger elevation-2">
                            <i class="fas fa-users"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Procesales</span>
                            <span class="info-box-number" id="totalProcesales">0<small>procesales</small></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header py-2">
                            <h3 class="card-title mt-1">
                                <i class="fas fa-chart-line mr-2"></i>
                                Expedientes por Mes
                            </h3>
                            <div class="card-tools d-flex align-items-center">
                                <div id="chart_expedienteMes_anios" class="btn-group mr-2"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart_expedienteMes" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-2"></i>
                                Expedientes por estado
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="chart_expedienteTipo" style="width: 100%; height: 351.5px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-alt mr-2"></i>
                                Últimos expedientes registrados
                            </h3>
                        </div>
                        <div class="card-body px-0 pt-0 mt-0 pb-4">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped" id="tbl_ultimosExpedientes">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NÚMERO</th>
                                            <th>FECHA INICIO</th>
                                            <th>PRETENSIÓN</th>
                                            <th>PROCESALES</th>
                                            <th>ESTADO</th>
                                            <th>FECHA CREACIÓN</th>
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
@endsection
@push('scripts')
    <script>
        var tbl_ultimosExpedientes;

        $(document).ready(function() {
            fct_totalProcesales();
            $.getJSON('/GetExpedientesPorMes', function(response) {
                if (response.status === 'success') {
                    fct_totalesGeneral(response.data);
                    fct_chartExpedientesPorMes(response.data);
                    fct_chartExpedientesPorTipo(response.data);
                }
            });
            fct_listarUltimosExpedientes();
        });

        function fct_totalProcesales() {
            $.getJSON('/GetTotalProcesales', function(response) {
                if (response.status === 'success') {
                    animateCount("#totalProcesales", response.data, 'procesales');
                }
            });
        }

        function fct_chartExpedientesPorMes(response) {
            if (response) {
                var data = dataChartMes(response);
                var chartDom = document.getElementById('chart_expedienteMes');
                var myChart = echarts.init(chartDom);

                var meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                    'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
                ];

                var anios = Object.keys(data);
                var anioActual = new Date().getFullYear().toString();
                if (!anios.includes(anioActual)) {
                    anioActual = anios[0];
                }

                function getSeries(anio) {
                    return [{
                            name: 'Trámite',
                            type: 'bar',
                            data: data[anio].tramite
                        },
                        {
                            name: 'Ejecución',
                            type: 'bar',
                            data: data[anio].ejecucion
                        },
                        {
                            name: 'Archivado',
                            type: 'bar',
                            data: data[anio].archivado
                        }
                    ];
                }

                var option = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    legend: {
                        top: 10
                    },
                    toolbox: {
                        right: 30, // pegado a la derecha
                        top: 10, // 🔥 arriba (no centrado)
                        itemSize: 18,
                        feature: {
                            dataView: {
                                show: true,
                                readOnly: false
                            },
                            magicType: {
                                show: true,
                                type: ['line', 'bar']
                            },
                            restore: {
                                show: true
                            },
                            saveAsImage: {
                                show: true
                            }
                        }
                    },

                    grid: {
                        top: 60, // espacio arriba
                        bottom: 40, // espacio abajo 🔥
                        left: '5%', // margen izquierdo proporcional
                        right: '5%', // margen derecho igual que el izquierdo
                        containLabel: true // asegura que etiquetas no se salgan
                    },
                    xAxis: {
                        type: 'category',
                        data: meses
                    },
                    yAxis: {
                        type: 'value',
                        name: 'Cantidad'
                    },
                    series: getSeries(anioActual)
                };

                myChart.setOption(option);

                // 🔥 Renderizar botones en el header
                var $contenedorAnios = $('#chart_expedienteMes_anios');
                $contenedorAnios.empty();
                anios.forEach(function(anio) {
                    var $btn = $('<button>')
                        .addClass('btn btn-sm ' + (anio === anioActual ? 'btn-primary' : 'btn-outline-primary'))
                        .text(anio)
                        .on('click', function() {
                            anioActual = anio;
                            myChart.setOption({
                                series: getSeries(anioActual)
                            });

                            // actualizar estilos de botones
                            $contenedorAnios.find('button').removeClass('btn-primary').addClass('btn-outline-primary');
                            $(this).removeClass('btn-outline-primary').addClass('btn-primary');
                        });

                    $contenedorAnios.append($btn);
                });

                window.addEventListener('resize', function() {
                    myChart.resize();
                });
            }
        }

        function fct_chartExpedientesPorTipo(data) {
            var chartDom = document.getElementById('chart_expedienteTipo');
            var myChart = echarts.init(chartDom);

            const pieData = dataChartPie(data);

            var option = {
                title: {
                    text: 'Expedientes por Estado',
                    subtext: 'Totales acumulados',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: '{b}<br/>{c} expedientes ({d}%)'
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    formatter: function(name) {
                        let item = pieData.find(d => d.name === name);
                        return `${name} (${item ? item.value.toLocaleString() : 0})`;
                    }
                },
                series: [{
                    name: 'Expedientes',
                    type: 'pie',
                    radius: '50%',
                    data: pieData,
                    label: {
                        show: true,
                        formatter: '{b}'
                    },
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }]
            };

            myChart.setOption(option);
        }

        function dataChartMes(data) {
            const result = {};

            data.forEach(item => {
                const anio = item.anio;
                const mes = item.mes - 1; // índice de 0 a 11
                const estadoId = item.id_estado_expediente;

                if (!result[anio]) {
                    result[anio] = {
                        tramite: Array(12).fill(0),
                        ejecucion: Array(12).fill(0),
                        archivado: Array(12).fill(0)
                    };
                }

                if (estadoId === 1) {
                    result[anio].tramite[mes] = item.total;
                } else if (estadoId === 2) {
                    result[anio].ejecucion[mes] = item.total;
                } else if (estadoId === 3) {
                    result[anio].archivado[mes] = item.total;
                }
            });

            return result;
        }

        function dataChartPie(data) {
            let totales = {
                1: 0, // EN TRAMITE
                2: 0, // EN EJECUCION
                3: 0 // ARCHIVADO
            };

            data.forEach(item => {
                if (totales[item.id_estado_expediente] !== undefined) {
                    totales[item.id_estado_expediente] += item.total;
                }
            });

            return [{
                    value: totales[1],
                    name: 'Trámite'
                },
                {
                    value: totales[2],
                    name: 'Ejecución'
                },
                {
                    value: totales[3],
                    name: 'Archivado'
                }
            ];
        }

        function animateCount(id, endValue, label = '') {
            let element = $(id);
            let startValue = 0;
            let duration = 1000; // duración en ms
            let increment = Math.ceil(endValue / (duration / 30)); // paso por frame
            let current = startValue;

            let counter = setInterval(() => {
                current += increment;
                if (current >= endValue) {
                    current = endValue;
                    clearInterval(counter);
                }
                element.html(`${current.toLocaleString()} ${label ? `<small>${label}</small>` : ''}`);
            }, 30);
        }

        function fct_totalesGeneral(data) {
            let totales = {
                total: 0,
                tramite: 0,
                ejecucion: 0,
                archivado: 0
            };

            data.forEach(item => {
                totales.total += item.total;

                if (item.id_estado_expediente === 1) {
                    totales.tramite += item.total;
                } else if (item.id_estado_expediente === 2) {
                    totales.ejecucion += item.total;
                } else if (item.id_estado_expediente === 3) {
                    totales.archivado += item.total;
                }
            });

            // Inyectar valores con animación
            animateCount("#totalExpedientes", totales.total, 'expedientes');
            animateCount("#totalTramite", totales.tramite, 'expedientes');
            animateCount("#totalEjecucion", totales.ejecucion, 'expedientes');
            //animateCount("#totalArchivado", totales.archivado);
        }

        function fct_listarUltimosExpedientes() {
            tbl_ultimosExpedientes = $('#tbl_ultimosExpedientes').DataTable({
                // scrollY: '450px',
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
                dom: `<"row mb-2"<"col-12"tr>>`,
                ajax: {
                    url: '/GetUltimosExpedientes',
                    type: 'GET',
                    cache: true,
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los usuarios:', error);
                    }
                },
                columns: [{
                        data: 'idExpediente',
                        className: 'py-1 text-sm text-center'
                    },
                    {
                        data: 'numero',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'fechaInicio',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'pretension',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'procesales',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: null,
                        className: 'py-1 pl-3 text-sm text-nowrap',
                        orderable: false,
                        render: function(data, type, row) {
                            var idEstado = data.idEstadoExpediente;

                            var badge = '';

                            if (idEstado === 1) {
                                badge = `<span class="badge badge-warning py-1 px-2">${data.estadoExpediente}</span>`;
                            } else if (idEstado === 2) {
                                badge = `<span class="badge badge-success py-1 px-2">${data.estadoExpediente}</span>`;
                            } else if (idEstado === 3) {
                                badge = `<span class="badge badge-danger py-1 px-2">${data.estadoExpediente}</span>`;
                            }

                            return badge;
                        }
                    },
                    {
                        data: 'fechaRegistro',
                        className: 'py-1 text-sm'
                    }
                ],
            });
        }
    </script>
@endpush
