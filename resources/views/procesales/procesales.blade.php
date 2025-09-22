@extends('layouts.app')
@section('page_title', 'Procesales')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Procesales</li>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="tabProcesal" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tabProcesales" data-toggle="pill" href="#paneProcesales" role="tab" aria-controls="paneProcesales" aria-selected="true">PROCESALES</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tabComunicaciones" data-toggle="pill" href="#paneComunicaciones" role="tab" aria-controls="paneComunicaciones" aria-selected="false">COMUNICACIONES</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="paneProcesales" role="tabpanel" aria-labelledby="tabProcesales">
                                    @include('procesales.procesal-listar')
                                </div>
                                <div class="tab-pane fade" id="paneComunicaciones" role="tabpanel" aria-labelledby="tabComunicaciones">
                                    @include('procesales.procesal-comunicacion')
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
        $(document).ready(function() {
            $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                let tabId = $(e.target).attr('id'); 

                if (tabId === 'tabProcesales') {
                    tbl_procesales.ajax.reload();
                } else if (tabId === 'tabComunicaciones') {
                   tbl_comunicacion.ajax.reload();
                }
            });
        });
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
