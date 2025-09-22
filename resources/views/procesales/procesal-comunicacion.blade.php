<section>
    <table class="table table-hover table-bordered" id="tbl_comunicacion">
        <thead>
            <tr>
                <th class="text-nowrap">ID</th>
                <th class="text-nowrap">EXPEDIENTE</th>
                <th class="text-nowrap">DOCUMENTO</th>
                <th class="text-nowrap">NOMBRES COMPLETOS / RAZON SOCIAL</th>
                <th class="text-nowrap">MEDIO</th>
                <th class="text-nowrap">DESCRIPCION</th>
                <th class="text-nowrap">FECHA</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</section>
@push('scripts')
    <script defer>
        var tbl_comunicacion;

        $(document).ready(function() {
            fct_listarComunicaciones();
        });

        function fct_listarComunicaciones() {
            tbl_comunicacion = $('#tbl_comunicacion').DataTable({
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
                dom: `<"row mb-2"<"col-6"B>> <"row mb-2"<"col-6"l><"col-6"f>> <"row mb-2"<"col-12"tr>> <"row"<"col-5"i><"col-7"p>>`,
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
                        filename: 'Listado_Comunicaciones', 
                        title: 'Reporte de Comunicaciones', 
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger mr-2 rounded-lg',
                        text: '<i class="fas fa-file-pdf"></i>',
                        filename: 'Listado_Comunicaciones', 
                        title: 'Reporte de Comunicaciones', 
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                ],
                ajax: {
                    url: '/GetComunicaciones',
                    type: 'GET',
                    cache: true,
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los usuarios:', error);
                    }
                },
                columns: [{
                        data: 'id',
                        className: 'py-1 text-center text-sm'
                    },
                    {
                        data: 'expediente',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'documento',
                        className: 'py-1 text-sm text-nowrap'
                    },
                    {
                        data: 'persona',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'medio',
                        className: 'py-1 text-sm'
                    },
                    {
                        data: 'descripcion',
                        className: 'py-1 text-sm text-nowrap'
                    },
                    {
                        data: 'fechaRegistro',
                        className: 'py-1 text-sm text-nowrap'
                    },
                ],

            });
        }
    </script>
@endpush
@push('styles')
    <style>
        .text-sm {
            font-size: 0.875rem;
        }
    </style>
@endpush
