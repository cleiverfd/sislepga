<section>
    <div class="card card-primary card-outline">
        <div class="card-header py-2">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 mr-3">ARCHIVO EJE</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tbl_archivosEje">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th>
                                    <th class="text-nowrap">NOMBRE</th>
                                    <th class="text-nowrap">DESCRIPCION</th>
                                    <th class="text-nowrap">ARCHIVO</th>
                                    <th class="text-nowrap">CREACION</th>
                                    <th class="text-nowrap">ACTUALIZACION</th>
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
    <div class="card card-primary card-outline">
        <div class="card-header py-2">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 mr-3">ESCRITOS PRESENTADOS</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tbl_archivosEscritos">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th>
                                    <th class="text-nowrap">NOMBRE</th>
                                    <th class="text-nowrap">DESCRIPCION</th>
                                    <th class="text-nowrap">ARCHIVO</th>
                                    <th class="text-nowrap">CREACION</th>
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
    <div class="modal fade" id="mdl-eje">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalEjeLabel">Registrar Archivo Eje</h4>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1" for="txt_ejeDescripcion">DESCRIPCION</label>
                                <input type="text" class="form-control" id="txt_ejeDescripcion">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txt_ejeArchivo">ARCHIVO</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input txt_fileEje" id="txt_ejeArchivo">
                                    <label class="custom-file-label" for="txt_ejeArchivo">Seleccionar archivo...</label>
                                </div>
                                <div id="spn_ejeNombre" class="d-none mt-2 p-2 border rounded bg-light">
                                    <i class="fas fa-file-alt text-primary mr-1"></i>
                                    <strong class="text-dark" id="fileNameEje"></strong>
                                    <small class="text-muted ml-1" id="fileSizeEje"></small>
                                </div>
                                <span class="small text-secondary">Formatos: pdf, doc, docx. max(10 MB)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button class="btn btn-success" id="btn_GuardarEje">Registrar Archivo Eje</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdl-escrito">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalEscritoLabel">Registrar Escrito</h4>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1" for="txt_escritoDescripcion">DESCRIPCION</label>
                                <input type="text" class="form-control" id="txt_escritoDescripcion">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txt_escritoArchivo">ARCHIVO</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input txt_fileEscrito" id="txt_escritoArchivo">
                                    <label class="custom-file-label" for="txt_escritoArchivo">Seleccionar archivo...</label>
                                </div>
                                <div id="spn_escritoNombre" class="d-none mt-2 p-2 border rounded bg-light">
                                    <i class="fas fa-file-alt text-primary mr-1"></i>
                                    <strong class="text-dark" id="fileNameEscrito"></strong>
                                    <small class="text-muted ml-1" id="fileSizeEscrito"></small>
                                </div>
                                <span class="small text-secondary">Formatos: pdf, doc, docx. max(10 MB)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button class="btn btn-success" id="btn_GuardarEscrito">Registrar Escrito</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPdfPreview" tabindex="-1" role="dialog" aria-labelledby="modalPdfTitle">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body p-0" style="height: 80vh;">
                    <iframe id="iframePdfViewer" src="" frameborder="0" style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        var tbl_archivosEje;
        var tbl_archivosEscritos;
        var id_eje;
        var id_escrito;

        $(document).ready(function() {

            fct_listarArchivosEje();
            fct_listarArchivosEscritos();

            $('#tbl_archivosEje').on('click', '.btn-ver-pdf', function() {
                const pdfUrl = $(this).data('url');
                $('#iframePdfViewer').attr('src', pdfUrl);
                $('#modalPdfPreview').modal('show');
            });

            $('#tbl_archivosEscritos').on('click', '.btn-ver-pdf', function() {
                const pdfUrl = $(this).data('url');
                $('#iframePdfViewer').attr('src', pdfUrl);
                $('#modalPdfPreview').modal('show');
            });

            $('#btn_GuardarEje').click(function() {
                if ($("#btn_GuardarEje").hasClass("edit")) {
                    fct_ActualizarEje();
                } else {
                    fct_RegistrarEje();
                }
            });

            $('#btn_GuardarEscrito').click(function() {
                if ($("#btn_GuardarEscrito").hasClass("edit")) {
                    fct_ActualizarEscrito();
                } else {
                    fct_RegistrarEscrito();
                }
            });
        });

        document.querySelector('.txt_fileEje').addEventListener('change', function(e) {
            let fileName = e.target.files[0] ? e.target.files[0].name : 'Elige un archivo...';
            e.target.nextElementSibling.innerText = fileName;
        });

        document.querySelector('.txt_fileEscrito').addEventListener('change', function(e) {
            let fileName = e.target.files[0] ? e.target.files[0].name : 'Elige un archivo...';
            e.target.nextElementSibling.innerText = fileName;
        });

        function fct_listarArchivosEje() {
            tbl_archivosEje = $('#tbl_archivosEje').DataTable({
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
                dom: `<"row mb-2"<"col-6"B><"col-6 btn-new-eje text-right">> <"row mb-2"<"col-6"l><"col-6"f>> <"row mb-2"<"col-12"tr>> <"row"<"col-5"i><"col-7"p>>`,
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
                    {
                        text: '<i class="fas fa-plus"></i> Nuevo',
                        className: 'btn btn-success rounded-lg d-none btn-nuevo-eje',
                        action: function() {
                            fct_NuevoEje();
                        }
                    }
                ],
                ajax: {
                    url: '/expedientes/listar-eje',
                    type: 'POST',
                    data: function(d) {
                        d.IdExpediente = IdExpediente;
                    },
                    dataSrc: function(json) {
                        if (json.status === 'success') {
                            return json.data;
                        }
                        return [];
                    },
                    error: function(xhr, status, error) {
                        toast.error("ERROR", error);
                        console.error('Error al cargar archivo eje:', error);
                    }
                },
                columns: [{
                        data: 'id',
                        className: 'py-1 text-center text-sm'
                    },
                    {
                        data: 'nombre',
                        className: 'py-1 pl-3 text-sm text-nowrap'
                    },
                    {
                        data: 'descripcion',
                        className: 'py-1 pl-3 text-sm'
                    },
                    {
                        data: 'url',
                        className: 'py-1 pl-3 text-sm text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            if (!data || row.formato == null || row.url == null) {
                                return `
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Sin archivo">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                `;
                            }

                            const formato = (row.formato || '').toLowerCase();

                            if (formato === 'pdf') {
                                return `
                                    <button class="btn btn-sm btn-outline-danger btn-ver-pdf" data-url="${data}" title="Ver PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                `;
                            } else if (formato === 'doc' || formato === 'docx' || formato.includes('word')) {
                                return `
                                    <a href="${data}" class="btn btn-sm btn-outline-primary" title="Descargar Word" download>
                                        <i class="fas fa-file-word"></i>
                                    </a>
                                `;
                            }
                        }
                    },
                    {
                        data: 'fecha_registro',
                        className: 'py-1 pl-3 text-sm text-nowrap'
                    },
                    {
                        data: 'fecha_actualizacion',
                        className: 'py-1 pl-3 text-sm text-nowrap'
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'py-1 text-center text-sm text-nowrap',
                        render: function(data, type, row) {
                            const btnVer = `<button class="btn btn-sm btn-warning" title="Editar" onclick="fct_EditarEje(${data.id})"><i class="fas fa-edit"></i></button>`;
                            const btnEliminar = `<button class="btn btn-sm btn-danger ml-1" title="Eliminar" onclick="fct_EliminarEje(${data.id})"><i class="fas fa-trash-alt"></i></button>`;
                            return btnVer + btnEliminar;
                        }
                    }
                ],
                initComplete: function() {
                    // Mostrar botón nuevo
                    $('.btn-nuevo-eje').removeClass('d-none');
                    const $nuevoBtn = $('.btn-nuevo-eje').detach();
                    $('.btn-new-eje').html($nuevoBtn);

                    // Normalizar clases de botones exportar
                    $('.buttons-copy').removeClass().addClass('btn btn-secondary mr-2 rounded-lg');
                    $('.buttons-excel').removeClass().addClass('btn btn-success mr-2 rounded-lg');
                    $('.buttons-pdf').removeClass().addClass('btn btn-danger mr-2 rounded-lg');
                }
            });
        }

        function fct_listarArchivosEscritos() {
            tbl_archivosEscritos = $('#tbl_archivosEscritos').DataTable({
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
                dom: `<"row mb-2"<"col-6"B><"col-6 btn-new-escrito text-right">> <"row mb-2"<"col-6"l><"col-6"f>> <"row mb-2"<"col-12"tr>> <"row"<"col-5"i><"col-7"p>>`,
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
                    {
                        text: '<i class="fas fa-plus"></i> Nuevo',
                        className: 'btn btn-success rounded-lg d-none btn-nuevo-escrito',
                        action: function() {
                            fct_NuevoEscrito();
                        }
                    }
                ],
                ajax: {
                    url: '/expedientes/listar-escritos',
                    type: 'POST',
                    data: function(d) {
                        d.IdExpediente = IdExpediente;
                    },
                    dataSrc: function(json) {
                        if (json.status === 'success') {
                            return json.data;
                        }
                        return [];
                    },
                    error: function(xhr, status, error) {
                        toast.error("ERROR", error);
                        console.error('Error al cargar archivo eje:', error);
                    }
                },
                columns: [{
                        data: 'id',
                        className: 'py-1 text-center text-sm'
                    },
                    {
                        data: 'nombre',
                        className: 'py-1 pl-3 text-sm text-nowrap'
                    },
                    {
                        data: 'descripcion',
                        className: 'py-1 pl-3 text-sm'
                    },
                    {
                        data: 'url',
                        className: 'py-1 pl-3 text-sm text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            if (!data || row.formato == null || row.url == null) {
                                return `
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Sin archivo">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                `;
                            }

                            const formato = (row.formato || '').toLowerCase();

                            if (formato === 'pdf') {
                                return `
                                    <button class="btn btn-sm btn-outline-danger btn-ver-pdf" data-url="${data}" title="Ver PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                `;
                            } else if (formato === 'doc' || formato === 'docx' || formato.includes('word')) {
                                return `
                                    <a href="${data}" class="btn btn-sm btn-outline-primary" title="Descargar Word" download>
                                        <i class="fas fa-file-word"></i>
                                    </a>
                                `;
                            }
                        }
                    },
                    {
                        data: 'fecha_registro',
                        className: 'py-1 pl-3 text-sm text-nowrap'
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'py-1 text-center text-sm text-nowrap',
                        render: function(data) {
                            const btnVer = `<button class="btn btn-sm btn-warning" title="Ver detalles" onclick="fct_EditarEscrito(${data.id})"><i class="fas fa-edit"></i></button>`;
                            const btnEliminar = `<button class="btn btn-sm btn-danger ml-1" title="Eliminar" onclick="fct_EliminarEscrito(${data.id})"><i class="fas fa-trash-alt"></i></button>`;
                            return btnVer + btnEliminar;
                        }
                    }
                ],
                initComplete: function() {
                    // Mostrar botón nuevo
                    $('.btn-nuevo-escrito').removeClass('d-none');
                    const $nuevoBtn = $('.btn-nuevo-escrito').detach();
                    $('.btn-new-escrito').html($nuevoBtn);

                    // Normalizar clases de botones exportar
                    $('.buttons-copy').removeClass().addClass('btn btn-secondary mr-2 rounded-lg');
                    $('.buttons-excel').removeClass().addClass('btn btn-success mr-2 rounded-lg');
                    $('.buttons-pdf').removeClass().addClass('btn btn-danger mr-2 rounded-lg');
                }
            });
        }

        function fct_NuevoEje() {
            fct_limpiarCamposEje();
            $('#mdl-eje').modal('show');
            $('#modalEjeLabel').text('Registrar');
            $('#btn_GuardarEje').removeClass('edit').text('Registrar');
        }

        function fct_RegistrarEje() {

            var descripcion = $('#txt_ejeDescripcion').val().trim();
            var fileInput = document.getElementById('txt_ejeArchivo');
            var archivo = fileInput.files[0];

            if (descripcion === '') {
                toast.warning("SISLEPGA", 'Por favor ingrese una descripcion');
                return;
            }

            if (!archivo) {
                toast.warning("SISLEPGA", 'Por favor seleccione un archivo');
                return;
            }

            let formData = new FormData();

            formData.append('idExpediente', IdExpediente);
            formData.append('file', archivo);
            formData.append('descripcion', descripcion);

            $.ajax({
                url: '/expedientes/registrar-eje',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        toast.success("SISLEPGA", response.Msj);
                        $('#mdl-eje').modal('hide');
                        fct_limpiarCamposEje();
                        tbl_archivosEje.ajax.reload();
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISLEPGA", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    toast.error("SISLEPGA", xhr.responseText);
                }
            });
        }

        function fct_EditarEje(id) {
            fct_limpiarCamposEje();
            $('#mdl-eje').modal('show');
            $('#modalEjeLabel').text('Actualizar Archivo Eje');
            $('#btn_GuardarEje').addClass('edit').text('Guardar Cambios');

            $.getJSON('/Get_EditarEje', {
                IdEje: id
            }, function(json) {
                id_eje = json.data.id;
                $('#txt_ejeDescripcion').val(json.data.descripcion);
                if (json.data.nombre) {
                    $("#fileNameEje").text(json.data.nombre.toUpperCase());
                    $("#fileSizeEje").text(`(${formatoPeso(json.data.peso)})`);
                    $("#spn_ejeNombre").removeClass("d-none");
                }
            });
        }

        function fct_ActualizarEje() {

            var descripcion = $('#txt_ejeDescripcion').val().trim();
            var fileInput = document.getElementById('txt_ejeArchivo');
            var archivo = fileInput.files[0];

            if (descripcion === '') {
                toast.warning("SISLEPGA", 'Por favor ingrese una descripcion');
                return;
            }

            if (!archivo) {
                toast.warning("SISLEPGA", 'Por favor seleccione un archivo');
                return;
            }

            let formData = new FormData();

            formData.append('id', id_eje);
            formData.append('file', archivo);
            formData.append('descripcion', descripcion);

            $.ajax({
                url: '/expedientes/editar-eje',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        toast.success("SISLEPGA", response.Msj);
                        $('#mdl-eje').modal('hide');
                        fct_limpiarCamposEje();
                        tbl_archivosEje.ajax.reload();
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISLEPGA", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    toast.error("SISLEPGA", xhr.responseText);
                }
            });
        }

        function fct_EliminarEje(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Este archivo eje se eliminará de forma permanente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/expedientes/eliminar-eje',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(json) {
                            if (json.status === 'success') {
                                $('#tbl_archivosEje').DataTable().ajax.reload();
                                toast.success("SISLEPGA", json.Msj);
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                            toast.error("SISLEPGA", xhr.responseText);
                        }
                    });
                }
            });
        }

        function fct_NuevoEscrito() {
            fct_limpiarCamposEscrito();
            $('#modalEscritoLabel').text('Registrar Escrito');
            $('#btn_GuardarEscrito').removeClass('edit').text('Registrar');
            $('#mdl-escrito').modal('show');
        }

        function fct_RegistrarEscrito() {

            var descripcion = $('#txt_escritoDescripcion').val().trim();
            var fileInput = document.getElementById('txt_escritoArchivo');
            var archivo = fileInput.files[0];

            if (descripcion === '') {
                toast.warning("SISLEPGA", 'Por favor ingrese una descripcion');
                return;
            }

            if (!archivo) {
                toast.warning("SISLEPGA", 'Por favor seleccione un archivo');
                return;
            }

            let formData = new FormData();

            formData.append('idExpediente', IdExpediente);
            formData.append('file', archivo);
            formData.append('descripcion', descripcion);

            $.ajax({
                url: '/expedientes/registrar-escrito',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        toast.success("SISLEPGA", response.Msj);
                        $('#mdl-escrito').modal('hide');
                        fct_limpiarCamposEscrito();
                        tbl_archivosEscritos.ajax.reload();
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISLEPGA", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    toast.error("SISLEPGA", xhr.responseText);
                }
            });
        }

        function fct_EditarEscrito(id) {
            fct_limpiarCamposEscrito();
            $('#modalEscritoLabel').text('Actualizar Escrito');
            $('#btn_GuardarEscrito').addClass('edit').text('Guardar Cambios');
            $('#mdl-escrito').modal('show');

            $.getJSON('/Get_EditarEscrito', {
                IdEscrito: id
            }, function(json) {
                id_escrito = json.data.id;
                $('#txt_escritoDescripcion').val(json.data.descripcion);
                if (json.data.nombre) {
                    $("#fileNameEscrito").text(json.data.nombre.toUpperCase());
                    $("#fileSizeEscrito").text(`(${formatoPeso(json.data.peso)})`);
                    $("#spn_escritoNombre").removeClass("d-none");
                }
            });
        }

        function fct_ActualizarEscrito() {

            var descripcion = $('#txt_escritoDescripcion').val().trim();
            var fileInput = document.getElementById('txt_escritoArchivo');
            var archivo = fileInput.files[0];

            if (descripcion === '') {
                toast.warning("SISLEPGA", 'Por favor ingrese una descripcion');
                return;
            }

            if (!archivo) {
                // toast.warning("SISLEPGA", 'Por favor seleccione un archivo');
                // return;
                archivo = null;
            }

            let formData = new FormData();

            formData.append('id', id_escrito);
            formData.append('file', archivo);
            formData.append('descripcion', descripcion);

            $.ajax({
                url: '/expedientes/editar-escrito',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success' && response.Msj != '') {
                        toast.success("SISLEPGA", response.Msj);
                        $('#mdl-escrito').modal('hide');
                        fct_limpiarCamposEscrito();
                        tbl_archivosEscritos.ajax.reload();
                    } else if (response.status === 'success' && response.Msj2 != '') {
                        toast.error("SISLEPGA", response.Msj2);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    toast.error("SISLEPGA", xhr.responseText);
                }
            });
        }

        function fct_EliminarEscrito(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Este escrito se eliminará de forma permanente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/expedientes/eliminar-escrito',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(json) {
                            if (json.status === 'success') {
                                $('#tbl_archivosEscritos').DataTable().ajax.reload();
                                toast.success("SISLEPGA", json.Msj);
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                            toast.error("SISLEPGA", xhr.responseText);
                        }
                    });
                }
            });
        }

        function fct_limpiarCamposEje() {
            $('#txt_ejeDescripcion').val('');
            $('.txt_fileEje').val('');
            $('.custom-file-label').text('Seleccionar archivo...');
            $("#fileNameEje").text('');
            $("#fileSizeEje").text('');
            $("#spn_ejeNombre").addClass("d-none");
        }

        function fct_limpiarCamposEscrito() {
            $('#txt_escritoDescripcion').val('');
            $('.txt_fileEscrito').val('');
            $('.custom-file-label').text('Seleccionar archivo...');
            $("#fileNameEscrito").text('');
            $("#fileSizeEscrito").text('');
            $("#spn_escritoNombre").addClass("d-none");
        }

        function formatoPeso(bytes) {
            if (bytes < 1024) return `${bytes} B`;
            else if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(2)} KB`;
            else return `${(bytes / 1024 / 1024).toFixed(2)} MB`;
        }
    </script>
@endpush
