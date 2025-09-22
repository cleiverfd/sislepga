 <section>
     <div class="row mb-2 text-sm">
         <div class="col-md-4">
             <div class="form-group">
                 <label class="mb-0">Número</label>
                 <input type="text" class="form-control form-control-sm" value="{{ $expediente->numero }}" disabled>
             </div>
         </div>
         <div class="col-md-2">
             <div class="form-group">
                 <label class="mb-0">Fecha de Inicio</label>
                 <input type="date" class="form-control form-control-sm" value="{{ $expediente->fecha_inicio }}" disabled>
             </div>
         </div>
         <div class="col-md-6">
             <div class="form-group">
                 <label class="mb-0">Pretensión</label>
                 <input type="text" class="form-control form-control-sm" value="{{ $expediente->pretension }}" disabled>
             </div>
         </div>
         <div class="col-md-6">
             <div class="form-group">
                 <label class="mb-0">Monto de Pretensión</label>
                 <input type="text" class="form-control form-control-sm" value="{{ number_format($expediente->monto_pretension, 2) }}" disabled>
             </div>
         </div>
         <div class="col-md-6">
             <div class="form-group">
                 <label class="mb-0">Materia</label>
                 <input type="text" class="form-control form-control-sm" value="{{ $expediente->materia }}" disabled>
             </div>
         </div>
         <div class="col-md-6">
             <div class="form-group">
                 <label class="mb-0">Distrito Judicial</label>
                 <input type="text" class="form-control form-control-sm" value="{{ $expediente->djudicial }}" disabled>
             </div>
         </div>
         <div class="col-md-6">
             <div class="form-group">
                 <label class="mb-0">Instancia</label>
                 <input type="text" class="form-control form-control-sm" value="{{ $expediente->instancia }}" disabled>
             </div>
         </div>
         <div class="col-md-6">
             <div class="form-group">
                 <label class="mb-0">Especialidad</label>
                 <input type="text" class="form-control form-control-sm" value="{{ $expediente->especialidad }}" disabled>
             </div>
         </div>
         <div class="col-md-6">
             <div class="form-group">
                 <label class="mb-0">Órgano Jurisdiccional</label>
                 <input type="text" class="form-control form-control-sm" value="{{ $expediente->juzgado }}" disabled>
             </div>
         </div>
         <div class="col-md-4">
             <div class="form-group">
                 <label class="mb-0">Estado del Proceso</label>
                 <input type="text" class="form-control form-control-sm" value="{{ $expediente->estado_expediente }}" disabled>
             </div>
         </div>
         <div class="col-md-4">
             <div class="form-group">
                 <label class="mb-0">Monto Total Sentencia</label>
                 <input type="number" class="form-control form-control-sm" value="{{ $expediente->total_sentencia }}" disabled>
             </div>
         </div>
         <div class="col-md-4">
             <div class="form-group">
                 <label class="mb-0">Saldo Total</label>
                 <input type="number" class="form-control form-control-sm" value="{{ $expediente->saldo_total }}" disabled>
             </div>
         </div>
     </div>
     <div class="row mb-3">
         <div class="col-md-12">
             <div class="alert alert-primary py-2" role="alert">PARTES PROCESALES</div>
         </div>
         <div class="col-md-12">
             <div class="table-responsive">
                 <table class="table table-hover table-bordered" id="tbl_DetalleExpedienteProcesales">
                     <thead>
                         <tr>
                             <th class="text-nowrap">ID</th>
                             <th class="text-nowrap">PARTE</th>
                             <th class="text-nowrap">TIPO DE PERSONA</th>
                             <th class="text-nowrap">CONDICION</th>
                             <th class="text-nowrap">NOMBRES COMPLETOS / RAZÓN SOCIAL</th>
                         </tr>
                     </thead>
                     <tbody>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 </section>
