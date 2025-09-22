 <div class="card card-primary card-outline" id="procesales">
     <div class="card-header py-2">
         <h5 class="card-title mb-0 mr-3">PARTES PROCESAL</h5>
     </div>
     <div class="card-body">
         <div class="row">
             <div class="col-md-12">
                 <div class="table-responsive">
                     <table class="table table-hover table-bordered" id="tbl_procesales">
                         <thead>
                             <tr>
                                 <th class="text-nowrap">ID</th>
                                 <th class="text-nowrap">PARTE</th>
                                 <th class="text-nowrap">TIPO DE PERSONA</th>
                                 <th class="text-nowrap">CONDICION</th>
                                 <th class="text-nowrap">NOMBRES COMPLETOS / RAZON SOCIAL</th>
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
 <div class="modal fade" id="mdl-procesal-nuevo" tabindex="-1" role="dialog" aria-labelledby="modalProcesalNuevoLabel">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="overlay" style="display:none;" id="loader_registrarProcesal">
                 <i class="fas fa-2x fa-sync-alt fa-spin"></i>
             </div>
             <div class="modal-header">
                 <h4 class="modal-title" id="modalProcesalNuevoLabel">Registrar Procesal</h4>
                 <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Cerrar">
                     <i class="fas fa-times"></i>
                 </button>
             </div>
             <div class="modal-body">
                 <section>
                     <div class="row">
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="mb-1" for="cbx_TipoProcesal">Tipo Procesal</label>
                                 <select class="form-control text-sm" id="cbx_TipoProcesal">
                                     <option value="" selected disabled>--SELECCIONAR--</option>
                                     <option value="DEMANDANTE">DEMANDANTE</option>
                                     <option value="DEMANDADO">DEMANDADO</option>
                                     <option value="DENUNCIANTE">DENUNCIANTE</option>
                                     <option value="DENUNCIADO">DENUNCIADO</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="mb-1" for="cbx_TipoPersona">Tipo Persona</label>
                                 <select class="form-control text-sm" id="cbx_TipoPersona">
                                     <option value="" selected disabled>--SELECCIONAR--</option>
                                     <option value="NATURAL">NATURAL</option>
                                     <option value="JURIDICA">JURIDICA</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="mb-1" for="cbx_Condicion">Condicion</label>
                                 <select class="form-control text-sm" id="cbx_Condicion">
                                     <option value="" selected disabled>--SELECCIONAR--</option>
                                     <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                                     <option value="DOCENTE UNIVERSITARIO">DOCENTE UNIVERSITARIO</option>
                                     <option value="ESTUDIANTE">ESTUDIANTE</option>
                                     <option value="TERCERO">TERCERO</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                     <div class="row d-none" id="div_PersonaNatural">
                         <div class="col-md-3">
                             <label class="mb-1" for="txt_dni">DNI</label>
                             <div class="input-group">
                                 <input type="text" class="form-control text-sm rounded-0" id="txt_dni" maxlength="8" pattern="\d{8}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                 <div class="input-group-prepend">
                                     <button class="btn btn-success" type="button" id="btn_buscarPersonaNatural"><i class="fas fa-search"></i></button>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label class="mb-1" for="txt_nombre">Nombres</label>
                                 <input type="text" class="form-control text-sm" id="txt_Nombre">
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label class="mb-1" for="txt_APaterno">Apellido Paterno</label>
                                 <input type="text" class="form-control text-sm" id="txt_APaterno">
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label class="mb-1" for="txt_AMaterno">Apellido Materno</label>
                                 <input type="text" class="form-control text-sm" id="txt_AMaterno">
                             </div>
                         </div>
                     </div>
                     <div class="row d-none" id="div_PersonaJuridica">
                         <div class="col-md-4">
                             <label class="mb-1" for="txt_Ruc">RUC</label>
                             <div class="input-group">
                                 <input type="text" class="form-control text-sm rounded-0" id="txt_Ruc" maxlength="11" pattern="\d{11}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                 <div class="input-group-prepend">
                                     <button class="btn btn-success" type="button" id="btn_buscarPersonaJuridica"><i class="fas fa-search"></i></button>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-8">
                             <div class="form-group">
                                 <label class="mb-1" for="txt_RazonSocial">Razon Social</label>
                                 <input type="text" class="form-control text-sm" id="txt_RazonSocial">
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label class="mb-1" for="cbx_departamentos">Departamento</label>
                                 <select class="form-control text-sm" id="cbx_departamentos">
                                     <option value="" selected disabled>--SELECCIONAR--</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label class="mb-1" for="cbx_provincias">Provincia</label>
                                 <select class="form-control text-sm" id="cbx_provincias">
                                     <option value="" selected disabled>--SELECCIONAR--</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label class="mb-1" for="cbx_distritos">Distrito</label>
                                 <select class="form-control text-sm" id="cbx_distritos">
                                     <option value="" selected disabled>--SELECCIONAR--</option>
                                 </select>
                             </div>
                         </div>

                         <div class="col-md-6">
                             <div class="form-group">
                                 <label class="mb-1" for="txt_calle">Calle, Avenida, S/N</label>
                                 <input type="text" class="form-control text-sm" id="txt_calle">
                             </div>
                         </div>
                     </div>
                 </section>
             </div>
             <div class="modal-footer justify-content-end">
                 <button class="btn btn-success" id="btn_GuardarProcesal">Registrar Procesal</button>
             </div>
         </div>
     </div>
 </div>
 @push('scripts')
     <script defer>
         let tbl_procesales;
         var IdExpediente = 0;
         var IdProcesal;

         $(document).ready(function() {

             IdExpediente = sessionStorage.getItem('IdExpediente');

             $("#btn_buscarPersonaNatural").on("click", function() {
                 BuscarPersona();
             });

             $("#btn_buscarPersonaJuridica").on("click", function() {
                 BuscarPersona();
             });

             $.getJSON('/GetDepartamentos', function(data) {
                 if (data.status === 'success') {
                     var $select = $('#cbx_departamentos');
                     $select.empty().append('<option value="">--SELECCIONAR--</option>');

                     $.each(data.data, function(index, item) {
                         $select.append(
                             `<option value="${item.Id}">${item.Descripcion}</option>`
                         );
                     });
                 }
             });

             $('#cbx_TipoPersona').on('change', function() {
                 const tipoPersona = $(this).val();
                 if (tipoPersona === 'NATURAL') {
                     $('#div_PersonaNatural').removeClass('d-none');
                     $('#div_PersonaJuridica').addClass('d-none');
                 } else if (tipoPersona === 'JURIDICA') {
                     $('#div_PersonaNatural').addClass('d-none');
                     $('#div_PersonaJuridica').removeClass('d-none');
                 }
             });

             $('#cbx_departamentos').on('change', function() {
                 const selectedId = $(this).val();
                 if (selectedId) {
                     $('#cbx_provincias').find('option:not(:first)').remove();
                     $('#cbx_distritos').find('option:not(:first)').remove();
                     GetProvincias(selectedId);
                 }
             });

             $('#cbx_provincias').on('change', function() {
                 const selectedId = $(this).val();
                 if (selectedId) {
                     $('#cbx_distritos').find('option:not(:first)').remove();
                     GetDistritos(selectedId);
                 }
             });

             $('#btn_GuardarProcesal').click(function() {
                 if ($('#btn_GuardarProcesal').hasClass('edit')) {
                     fct_ActualizarProcesal();
                 } else {
                     fct_RegistrarProcesal();
                 }
             });

             $('#cbx_TipoPersona').on('change', function() {
                 const tipoPersona = $(this).val();
                 limpiarCamposSegunTipoPersona(tipoPersona);
             });

             //tbl_procesales.DataTable({});
             fct_listarTablaProcesales();
         });

         function fct_NuevoProcesal() {
             limpiarCamposProcesal();
             $('#mdl-procesal-nuevo').modal('show');
             $('#modalProcesalNuevoLabel').text('Registrar Procesal');
             $('#btn_GuardarProcesal').removeClass('edit');
             $('#btn_GuardarProcesal').text('Registrar Procesal');
         }

         function fct_listarTablaProcesales() {
             tbl_procesales = $('#tbl_procesales').DataTable({
                 //scrollY: '350px',
                 // scrollX: true,
                 // scrollCollapse: true,
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
                         exportOptions: {
                             columns: ':visible:not(:last-child)'
                         }
                     },
                     //  {
                     //      extend: 'print',
                     //      className: 'btn btn-primary mr-2 rounded-lg',
                     //      text: '<i class="fas fa-print"></i>',
                     //      exportOptions: {
                     //          columns: ':visible:not(:last-child)'
                     //      }
                     //  },
                     // {
                     //     extend: 'colvis',
                     //     className: 'btn btn-warning mr-2 rounded-lg',
                     //     text: '<i class="fas fa-list"></i>'
                     // },
                     {
                         text: '<i class="fas fa-plus"></i> Nuevo',
                         className: 'btn btn-success rounded-lg d-none new',
                         action: function() {
                             fct_NuevoProcesal();
                         }
                     }
                 ],
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
                     },
                     {
                         data: null,
                         orderable: false,
                         className: 'py-1 text-center text-sm text-nowrap',
                         render: function(data, type, row) {
                             const btnVer =
                                 `<button class="btn btn-sm btn-warning" title="Ver detalles" onclick="fct_editarProcesal(${data.IdPersona})"><i class="fas fa-edit"></i></button>`;
                             const btnEditar =
                                 `<button class="btn btn-sm btn-danger ml-1" title="Editar datos" onclick="fct_eliminarProcesal(${data.IdPersona})"><i class="fas fa-trash-alt"></i></button>`;

                             return btnVer + btnEditar;
                         }
                     }
                 ],
                 initComplete: function() {
                     //table.columns.adjust().draw();
                     $('.new').removeClass('d-none');
                     let $nuevo = $('.new').detach();
                     $('.btn-new').append($nuevo);

                     $('.buttons-copy').removeClass().addClass('btn btn-secondary mr-2 rounded-lg');
                     $('.buttons-excel').removeClass().addClass('btn btn-success mr-2 rounded-lg');
                     $('.buttons-pdf').removeClass().addClass('btn btn-danger mr-2 rounded-lg');
                     //  $('.buttons-print').removeClass().addClass('btn btn-primary mr-2 rounded-lg');
                     //$('.buttons-colvis').removeClass().addClass('btn btn-warning mr-2 rounded-lg');

                 }
             });
         }

         function GetProvincias(idDepartamento) {
             $.getJSON('/GetProvincias', {
                 idDepartamento: idDepartamento
             }, function(data) {
                 if (data.status === 'success') {
                     var $select = $('#cbx_provincias');
                     $select.empty().append('<option value="">--SELECCIONAR--</option>');
                     $.each(data.data, function(index, item) {
                         $select.append(
                             `<option value="${item.Id}">${item.Descripcion}</option>`
                         );
                     });
                 }
             });
         }

         function GetDistritos(idProvincia) {
             $.getJSON('/GetDistritos', {
                 idProvincia: idProvincia
             }, function(data) {
                 if (data.status === 'success') {
                     var $select = $('#cbx_distritos');
                     $select.empty().append('<option value="">--SELECCIONAR--</option>');
                     $.each(data.data, function(index, item) {
                         $select.append(
                             `<option value="${item.Id}">${item.Descripcion}</option>`
                         );
                     });
                 }
             });
         }

         function BuscarPersona() {
             showLoaderProcesal();
             var tipoPersona = $('#cbx_TipoPersona').val();
             var documento = '';

             if (tipoPersona === 'NATURAL') {
                 documento = $('#txt_dni').val();
             } else if (tipoPersona === 'JURIDICA') {
                 documento = $('#txt_Ruc').val();
             }

             $.getJSON('/GetBuscarPersona', {
                 tipoPersona: tipoPersona,
                 documento: documento
             }, function(data) {
                 if (data.status === 'success') {
                     const persona = data.data.length > 0 ? data.data[0] : null;

                     if (persona) {
                         $('#cbx_TipoProcesal').val(persona.TipoProcesal);
                         $('#cbx_Condicion').val(persona.Condicion);
                         $('#txt_Nombre').val(persona.Nombre);
                         $('#txt_APaterno').val(persona.APaterno);
                         $('#txt_AMaterno').val(persona.AMaterno);
                         $('#txt_Ruc').val(persona.Ruc);
                         $('#txt_RazonSocial').val(persona.RazonSocial);
                         GetUbigeo(persona);
                     } else {
                         $('#cbx_TipoProcesal').val('');
                         $('#cbx_Condicion').val('');
                         $('#txt_Nombre').val('');
                         $('#txt_APaterno').val('');
                         $('#txt_AMaterno').val('');
                         $('#txt_RazonSocial').val('');
                         $('#cbx_departamentos').val('');
                         $('#cbx_provincias option:not(:first)').remove();
                         $('#cbx_provincias').val(null).trigger('change');
                         $('#cbx_distritos option:not(:first)').remove();
                         $('#cbx_distritos').val(null).trigger('change');
                         $('#txt_calle').val('');
                         hideLoaderProcesal();
                         toast.warning("SISGE", "PERSONA NO ENCONTRADA, INGRESE MANUALMENTE");
                     }
                 }
             });
         }

         async function GetUbigeo(persona) {

             $('#cbx_departamentos').val(persona.IdDepartamento);

             $.getJSON('/GetProvincias', {
                 idDepartamento: persona.IdDepartamento
             }, function(data) {
                 if (data.status === 'success') {

                     let $provinciaSelect = $('#cbx_provincias');
                     data.data.forEach(function(item) {
                         $provinciaSelect.append(
                             `<option value="${item.Id}">${item.Descripcion}</option>`);
                     });

                     $('#cbx_provincias').val(persona.IdProvincia);

                     $.getJSON('/GetDistritos', {
                         idProvincia: persona.IdProvincia
                     }, function(data) {
                         if (data.status === 'success') {

                             let $distritoSelect = $('#cbx_distritos');
                             data.data.forEach(function(item) {
                                 $distritoSelect.append(
                                     `<option value="${item.Id}">${item.Descripcion}</option>`
                                 );
                             });

                             $('#cbx_distritos').val(persona.IdDistrito);
                             $('#txt_calle').val(persona.CalleAv);
                         }
                     });
                 }
                 hideLoaderProcesal();
             });
         }

         function fct_RegistrarProcesal() {
             console.log('IdExpediente: ', IdExpediente);
             if (IdExpediente === null || IdExpediente === 0) {
                 toast.error("SISGE", "TIENE QUE REGISTRAR PRIMERO EL EXPEDIENTE");
                 return;
             }

             const tipoPersona = $('#cbx_TipoPersona').val();

             if (!tipoPersona) {
                 toast.warning("SISGE", 'SELECCIONE EL TIPO DE PERSONA');
                 return;
             }

             let esValido = false;

             if (tipoPersona === 'NATURAL') {
                 esValido = validarCamposNaturales();
             } else if (tipoPersona === 'JURIDICA') {
                 esValido = validarCamposJuridicos();
             }

             if (!esValido) {
                 return;
             }

             let formData = new FormData();

             formData.append('IdExpediente', IdExpediente);
             formData.append('TipoPersona', tipoPersona);
             formData.append('TipoProcesal', $('#cbx_TipoProcesal').val());
             formData.append('Condicion', $('#cbx_Condicion').val());
             formData.append('Dni', $('#txt_dni').val());
             formData.append('Nombre', $('#txt_Nombre').val());
             formData.append('APaterno', $('#txt_APaterno').val());
             formData.append('AMaterno', $('#txt_AMaterno').val());
             formData.append('Ruc', $('#txt_Ruc').val());
             formData.append('RazonSocial', $('#txt_RazonSocial').val());
             formData.append('IdDepartamento', $('#cbx_departamentos').val());
             formData.append('IdProvincia', $('#cbx_provincias').val());
             formData.append('IdDistrito', $('#cbx_distritos').val());
             formData.append('Calle', $('#txt_calle').val());

             $.ajax({
                 url: '/expediente/registrarProcesal',
                 type: 'POST',
                 data: formData,
                 processData: false,
                 contentType: false,
                 success: function(response) {
                     if (response.status === 'success' && response.Msj != '') {
                         toast.success("SISGE", response.Msj);
                         $('#mdl-procesal-nuevo').modal('hide');
                         limpiarCamposProcesal();
                         tbl_procesales.ajax.reload();
                     } else if (response.status === 'success' && response.Msj2 != '') {
                         toast.error("SISGE", response.Msj2);
                     }
                 },
                 error: function(xhr) {
                     console.error('Error:', xhr.responseText);
                     alert('Ocurrió un error al registrar');
                 }
             });
         }

         function fct_editarProcesal(idProcesal) {
             showLoaderProcesal();

             $.getJSON('/Get_EditarProcesal', {
                 IdProcesal: idProcesal
             }, function(data) {
                 if (data.status === 'success') {
                     $('#mdl-procesal-nuevo').modal('show');
                     $('#modalProcesalNuevoLabel').text('Editar Procesal');
                     $('#btn_GuardarProcesal').text('Guardar Cambios');
                     $('#btn_GuardarProcesal').addClass('edit');
                     const persona = data.data;
                     console.log('persona: ', persona);
                     if (persona) {
                         IdProcesal = persona.Id;
                         var tipoPersona = persona.TipoPersona;
                         limpiarCamposSegunTipoPersona(tipoPersona);

                         $('#cbx_TipoProcesal').val(persona.TipoProcesal);
                         $('#cbx_TipoPersona').val(persona.TipoPersona);
                         if (tipoPersona === 'NATURAL') {
                             $('#div_PersonaNatural').removeClass('d-none');
                             $('#div_PersonaJuridica').addClass('d-none');
                             $('#txt_dni').val(persona.Dni);
                             $('#txt_Nombre').val(persona.Nombre);
                             $('#txt_APaterno').val(persona.APaterno);
                             $('#txt_AMaterno').val(persona.AMaterno);
                         } else if (tipoPersona === 'JURIDICA') {
                             $('#div_PersonaNatural').addClass('d-none');
                             $('#div_PersonaJuridica').removeClass('d-none');
                             $('#txt_Ruc').val(persona.Ruc);
                             $('#txt_RazonSocial').val(persona.RazonSocial);
                         }

                         $('#cbx_Condicion').val(persona.Condicion);

                         GetUbigeo(persona);
                     } else {
                         $('#cbx_TipoProcesal').val('');
                         $('#cbx_Condicion').val('');
                         $('#txt_Nombre').val('');
                         $('#txt_APaterno').val('');
                         $('#txt_AMaterno').val('');
                         $('#cbx_departamentos').val('');
                         $('#cbx_provincias option:not(:first)').remove();
                         $('#cbx_provincias').val(null).trigger('change');
                         $('#cbx_distritos option:not(:first)').remove();
                         $('#cbx_distritos').val(null).trigger('change');
                         $('#txt_calle').val('');
                         hideLoaderProcesal();
                     }
                 }
             });
         }

         function fct_ActualizarProcesal() {
             const tipoPersona = $('#cbx_TipoPersona').val();

             if (!tipoPersona) {
                 toast.warning("SISGE", 'SELECCIONE EL TIPO DE PERSONA');
                 return;
             }

             let esValido = false;

             if (tipoPersona === 'NATURAL') {
                 esValido = validarCamposNaturales();
             } else if (tipoPersona === 'JURIDICA') {
                 esValido = validarCamposJuridicos();
             }

             if (!esValido) {
                 return;
             }

             let formData = new FormData();

             formData.append('IdProcesal', IdProcesal);
             formData.append('IdExpediente', IdExpediente);
             formData.append('TipoPersona', tipoPersona);
             formData.append('TipoProcesal', $('#cbx_TipoProcesal').val());
             formData.append('Condicion', $('#cbx_Condicion').val());
             formData.append('Dni', $('#txt_dni').val());
             formData.append('Nombre', $('#txt_Nombre').val());
             formData.append('APaterno', $('#txt_APaterno').val());
             formData.append('AMaterno', $('#txt_AMaterno').val());
             formData.append('Ruc', $('#txt_Ruc').val());
             formData.append('RazonSocial', $('#txt_RazonSocial').val());
             formData.append('IdDepartamento', $('#cbx_departamentos').val());
             formData.append('IdProvincia', $('#cbx_provincias').val());
             formData.append('IdDistrito', $('#cbx_distritos').val());
             formData.append('Calle', $('#txt_calle').val());

             $.ajax({
                 url: '/expediente/editarProcesal',
                 type: 'POST',
                 data: formData,
                 processData: false,
                 contentType: false,
                 success: function(response) {
                     if (response.status === 'success' && response.Msj != '') {
                         toast.success("SISGE", response.Msj);
                         $('#btn_GuardarProcesal').removeClass('edit');
                         $('#mdl-procesal-nuevo').modal('hide');
                         limpiarCamposProcesal();
                         tbl_procesales.ajax.reload();
                     } else if (response.status === 'success' && response.Msj2 != '') {
                         toast.error("SISGE", response.Msj2);
                     }
                 },
                 error: function(xhr) {
                     console.error('Error:', xhr.responseText);
                     alert('Ocurrió un error al registrar');
                 }
             });
         }

         function fct_eliminarProcesal(idProcesal) {
             Swal.fire({
                 title: '¿Estás seguro?',
                 text: "Esta acción eliminará el registro de forma permanente.",
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#d33',
                 cancelButtonColor: '#3085d6',
                 confirmButtonText: 'Sí, eliminar',
                 cancelButtonText: 'Cancelar'
             }).then((result) => {
                 if (result.isConfirmed) {
                     $.ajax({
                         url: '/expediente/eliminarProcesal',
                         method: 'POST',
                         data: {
                             IdProcesal: idProcesal
                         },
                         success: function(response) {
                             if (response.status === 'success') {
                                 toast.success("SISGE", response.Msj);
                                 limpiarCamposProcesal();
                             }
                         },
                         error: function(xhr, status, error) {
                             Swal.fire(
                                 'Error',
                                 'Hubo un problema al eliminar el registro.',
                                 'error'
                             );
                         }
                     });
                 }
             });
         }

         function mostrarErroresValidacion(errores) {
             if (errores.length > 0) {
                 const listaHTML =
                     `<ul style="margin: 0; padding-left: 1.2rem;">${errores.map(e => `<li>${e}</li>`).join('')}</ul>`;
                 toast.warning("CAMPOS OBLIGATORIOS", listaHTML, {
                     dangerouslyUseHTMLString: true
                 });
                 return false;
             }
             return true;
         }

         function validarCamposNaturales() {
             let errores = [];

             if (!$('#txt_dni').val().trim()) errores.push('DNI');
             if (!$('#txt_Nombre').val().trim()) errores.push('Nombre');
             if (!$('#txt_APaterno').val().trim()) errores.push('Apellido Paterno');
             if (!$('#txt_AMaterno').val().trim()) errores.push('Apellido Materno');
             if (!$('#cbx_TipoProcesal').val()) errores.push('Tipo Procesal');
             if (!$('#cbx_Condicion').val()) errores.push('Condición');
             if (!$('#cbx_departamentos').val()) errores.push('Departamento');
             if (!$('#cbx_provincias').val()) errores.push('Provincia');
             if (!$('#cbx_distritos').val()) errores.push('Distrito');
             if (!$('#txt_calle').val().trim()) errores.push('Dirección');

             return mostrarErroresValidacion(errores);
         }

         function validarCamposJuridicos() {
             let errores = [];

             if (!$('#txt_Ruc').val().trim()) errores.push('RUC');
             if (!$('#txt_RazonSocial').val().trim()) errores.push('Razón Social');
             if (!$('#cbx_TipoProcesal').val()) errores.push('Tipo Procesal');
             if (!$('#cbx_Condicion').val()) errores.push('Condición');
             if (!$('#cbx_departamentos').val()) errores.push('Departamento');
             if (!$('#cbx_provincias').val()) errores.push('Provincia');
             if (!$('#cbx_distritos').val()) errores.push('Distrito');
             if (!$('#txt_calle').val().trim()) errores.push('Dirección');

             return mostrarErroresValidacion(errores);
         }

         function limpiarCamposProcesal() {
             $('#cbx_TipoPersona').val('');
             limpiarCamposComunes();
             limpiarCamposPersonaNatural();
             limpiarCamposPersonaJuridica();
             $('#div_PersonaNatural').addClass('d-none');
             $('#div_PersonaJuridica').addClass('d-none');
         }

         function limpiarCamposComunes() {
             $('#cbx_TipoProcesal').val('');
             $('#cbx_Condicion').val('');
             $('#cbx_departamentos').val('');
             $('#cbx_provincias option:not(:first)').remove();
             $('#cbx_provincias').val('').trigger('change');
             $('#cbx_distritos option:not(:first)').remove();
             $('#cbx_distritos').val(null).trigger('change');
             $('#txt_calle').val('');
         }

         function limpiarCamposPersonaNatural() {
             $('#txt_dni').val('');
             $('#txt_Nombre').val('');
             $('#txt_APaterno').val('');
             $('#txt_AMaterno').val('');
         }

         function limpiarCamposPersonaJuridica() {
             $('#txt_Ruc').val('');
             $('#txt_RazonSocial').val('');
         }

         function limpiarCamposSegunTipoPersona(tipo) {
             limpiarCamposComunes();
             if (tipo === 'NATURAL') {
                 limpiarCamposPersonaJuridica();
             } else if (tipo === 'JURIDICA') {
                 limpiarCamposPersonaNatural();
             }
         }

         function showLoaderProcesal() {
             $("#loader_registrarProcesal").show();
         }

         function hideLoaderProcesal() {
             $("#loader_registrarProcesal").hide();
         }
     </script>
 @endpush
