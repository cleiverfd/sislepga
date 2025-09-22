 <div class="col-md-6">
     <div class="form-group">
         <label class="mb-1" for="cbx_Abogado">Abogado</label>
         <select class="form-control select2" id="cbx_Abogado" style="width: 100%"></select>
     </div>
 </div>
 @push('scripts')
     <script>
         $(document).ready(function() {
             $.getJSON('/GetAbogados', function(data) {

                 $('#cbx_Abogado').select2({
                     placeholder: "--SELECCIONAR--",
                     allowClear: true,
                     data: data
                 });

                 if (typeof idAbogado !== 'undefined' && idAbogado !== null && idAbogado !== '' && parseInt(idAbogado) > 0) {
                     $('#cbx_Abogado').val(idAbogado).trigger('change');
                 } else {
                     $('#cbx_Abogado').val(null).trigger('change');
                 }
             });
         });
     </script>
 @endpush
