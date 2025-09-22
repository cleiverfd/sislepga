<section>
    <div class="card" id="archivosEscritos">
        <div class="card-header py-2 bg-danger">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 mr-3">REVISIONES DE EXPEDIENTE</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tbl_revisiones">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th>
                                    <th class="text-nowrap">USUARIO</th>
                                    <th class="text-nowrap">FECHA</th>
                                   
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
</section>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tbl_revisiones').DataTable({});
        });
    </script>
@endpush
