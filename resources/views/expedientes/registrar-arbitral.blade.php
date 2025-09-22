 <section>
     <div id="form-expediente">
         <div class="row">
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="mb-1" for="txt_procesoArbitral">N° de proceso arbitral</label>
                     <input type="email" class="form-control" id="txt_procesoArbitral">
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="mb-1" for="txt_contratoReferencia">Contrato de referencia</label>
                     <input type="email" class="form-control" id="txt_contratoReferencia">
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="mb-1" for="txt_fechaInicioArbitral">Fecha de Inicio</label>
                     <input type="date" class="form-control" id="txt_fechaInicioArbitral" />
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="mb-1" for="cbx_pretensionesArbitral">Pretension</label>
                     <select class="select2" id="cbx_pretensionesArbitral"></select>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="mb-1" for="txt_montoPretensionArbitral">Monto de pretension</label>
                     <input type="number" class="form-control" id="txt_montoPretensionArbitral">
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="mb-1" for="cbx_sedeArbitraje">Sede de arbitraje</label>
                     <select class="select2" id="cbx_sedeArbitraje"></select>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="mb-1" for="cbx_tribunalArbitral">Tribunal arbitral</label>
                     <select class="select2" id="cbx_tribunalArbitral"></select>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="mb-1" for="cbx_estadoArbitral">Estado Proceso</label>
                     <select class="custom-select text-sm" id="cbx_estadoArbitral">
                         <option value="" disabled>--SELECIONAR--</option>
                         <option value="1" selected>EN TRAMITE</option>
                         <option value="2">EN EJECUCION</option>
                         <option value="3">ARCHIVADO</option>
                     </select>
                 </div>
             </div>
         </div>
         <div class="row d-none" id="div_montosArbitral">
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="mb-1" for="txt_montoPenal">Monto Total Sentencia</label>
                     <input type="number" class="form-control" id="txt_montoArbitral">
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="mb-1" for="txt_saldoPenal">Saldo Total</label>
                     <input type="number" class="form-control" id="txt_saldoArbitral">
                 </div>
             </div>
         </div>
         <div class="row my-3">
             <div class="col-md-12 d-flex justify-content-end">
                 <button class="btn btn-success" id="btn_RegistrarArbitral">Registrar Expediente</button>
             </div>
         </div>
     </div>
 </section>
 @push('scripts')
<script defer>
    $(document).ready(function () {
        $('#cbx_estadoArbitral').on('change', function () {
            const estado = $(this).val();
            $('#div_montosArbitral').toggleClass('d-none', estado === '1');
        });

        $('#btn_RegistrarArbitral').click(function () {
            registrarExpedienteArbitral();
        });
    });

</script>
@endpush
