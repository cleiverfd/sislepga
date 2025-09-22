<?php

use App\Http\Controllers\AbogadoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProcesalController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

#login
//Route::get('/', [AuthController::class, 'guest'])->name('guest');

// Login y registro
Route::get('/', [AuthController::class, 'guest'])->name('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

#vistas
Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {
    Route::get('/inicio', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/GetExpedientesPorMes', [DashboardController::class, 'GetExpedientesPorMes']);
    Route::get('/GetUltimosExpedientes', [DashboardController::class, 'GetUltimosExpedientes']);
    Route::get('/GetTotalProcesales', [DashboardController::class, 'GetTotalProcesales']);
   
    Route::get('/usuarios', [UsuarioController::class, 'listar_Usuarios']);
    Route::get('/GetUsuarios', [UsuarioController::class, 'GetUsuarios']);
    Route::get('/Get_EditarUsuario', [UsuarioController::class, 'Get_EditarUsuario']);
    Route::post('/usuario/registrar', [UsuarioController::class, 'RegistrarUsuario']);
    Route::post('/usuario/editar', [UsuarioController::class, 'EditarUsuario']);
    Route::post('/usuario/eliminar', [UsuarioController::class, 'EliminarUsuario']);
    Route::post('/GetRecursosSistema', [UsuarioController::class, 'listarRecursos']);
    Route::post('/usuario/asignarRecursos', [UsuarioController::class, 'AsignarRecursos']);

    Route::get('/GetExpedientes', [ExpedienteController::class, 'GetExpedientes']);

    Route::get('/GetAbogados', [ExpedienteController::class, 'GetAbogados']);
    Route::get('/GetPretensiones', [ExpedienteController::class, 'GetPretensiones']);
    Route::get('/GetMaterias', [ExpedienteController::class, 'GetMaterias']);
    Route::get('/GetDistritosJudiciales', [ExpedienteController::class, 'GetDistritosJudiciales']);
    Route::get('/GetInstancias', [ExpedienteController::class, 'GetInstancias']);
    Route::get('/GetFiscalias', [ExpedienteController::class, 'GetFiscalias']);
    Route::get('/GetEspecialidades', [ExpedienteController::class, 'GetEspecialidades']);
    Route::get('/GetJuzgados', [ExpedienteController::class, 'GetJuzgados']);

    Route::get('/GetDepartamentos', [ExpedienteController::class, 'GetDepartamentos']);
    Route::get('/GetProvincias', [ExpedienteController::class, 'GetProvincias']);
    Route::get('/GetDistritos', [ExpedienteController::class, 'GetDistritos']);

    Route::post('/ListarProcesales', [ExpedienteController::class, 'ListarProcesales']);

    Route::get('/GetBuscarPersona', [ExpedienteController::class, 'GetBuscarPersona']);

    Route::get('/expedientes', [ExpedienteController::class, 'listar_Expedientes']);

    Route::post('/expediente/registrar', [ExpedienteController::class, 'RegistrarExpediente']);
    Route::post('/expediente/listar', [ExpedienteController::class, 'ListarExpediente']);
    Route::post('/expediente/actualizar', [ExpedienteController::class, 'ActualizarExpediente']);
    Route::post('/expediente/registrarProcesal', [ExpedienteController::class, 'RegistrarProcesal']);
    Route::get('/Get_EditarProcesal', [ExpedienteController::class, 'Get_EditarProcesal']);
    Route::post('/expediente/editarProcesal', [ExpedienteController::class, 'EditarProcesal']);
    Route::post('/expediente/eliminarProcesal', [ExpedienteController::class, 'EliminarProcesal']);

    Route::get('/expediente/editar/{id}', [ExpedienteController::class, 'EditarExpediente']);

    Route::get('/expedientes/civil-laboral', [ExpedienteController::class, 'listar_ExpedientesCivil']);
    Route::get('/expedientes/civil-laboral/registrar', [ExpedienteController::class, 'registrar_ExpedienteCivil']);
    Route::get('/expedientes/civil-laboral/editar/{id}', [ExpedienteController::class, 'editar_ExpedienteCivil']);
    Route::get('/expedientes/civil-laboral/detalle/{id}', [ExpedienteController::class, 'detalle_ExpedienteCivil']);

    Route::get('/expedientes/penal', [ExpedienteController::class, 'listar_ExpedientesPenal']);
    Route::get('/expedientes/penal/registrar', [ExpedienteController::class, 'registrar_ExpedientePenal']);
    Route::get('/expedientes/penal/editar/{id}', [ExpedienteController::class, 'editar_ExpedientePenal']);
    Route::get('/expedientes/penal/detalle/{id}', [ExpedienteController::class, 'detalle_ExpedientePenal']);

    Route::post('/expedientes/listar-eje', [ExpedienteController::class, 'GetArchivosEje']);
    Route::post('/expedientes/registrar-eje', [ExpedienteController::class, 'RegistrarEje']);
    Route::get('/Get_EditarEje', [ExpedienteController::class, 'Get_EditarEje']);
    Route::post('/expedientes/editar-eje', [ExpedienteController::class, 'EditarEje']);
    Route::post('/expedientes/eliminar-eje', [ExpedienteController::class, 'EliminarEje']);

    Route::post('/expedientes/listar-escritos', [ExpedienteController::class, 'GetArchivosEscritos']);
    Route::post('/expedientes/registrar-escrito', [ExpedienteController::class, 'RegistrarEscrito']);
    Route::get('/Get_EditarEscrito', [ExpedienteController::class, 'Get_EditarEscrito']);
    Route::post('/expedientes/editar-escrito', [ExpedienteController::class, 'EditarEscrito']);
    Route::post('/expedientes/eliminar-escrito', [ExpedienteController::class, 'EliminarEscrito']);

    Route::post('/expedientes/listar-audiencias', [ExpedienteController::class, 'GetAudiencias']);
    Route::post('/expedientes/registrar-audiencia', [ExpedienteController::class, 'RegistrarAudiencia']);
    Route::get('/Get_EditarAudiencia', [ExpedienteController::class, 'Get_EditarAudiencia']);
    Route::post('/expedientes/editar-audiencia', [ExpedienteController::class, 'EditarAudiencia']);
    Route::post('/expedientes/eliminar-audiencia', [ExpedienteController::class, 'EliminarAudiencia']);

    Route::post('/expedientes/listar-alertas', [ExpedienteController::class, 'GetAlertas']);
    Route::post('/expedientes/registrar-alerta', [ExpedienteController::class, 'RegistrarAlerta']);
    Route::get('/Get_EditarAlerta', [ExpedienteController::class, 'Get_EditarAlerta']);
    Route::post('/expedientes/editar-alerta', [ExpedienteController::class, 'EditarAlerta']);
    Route::post('/expedientes/eliminar-alerta', [ExpedienteController::class, 'EliminarAlerta']);

    Route::get('/procesales', [ProcesalController::class, 'Procesales']);
    Route::get('/GetProcesales', [ProcesalController::class, 'GetProcesales']);
    Route::get('/procesal/detalle/{id}', [ProcesalController::class, 'ProcesalDetalle']);
    Route::get('/procesal/editar/{id}', [ProcesalController::class, 'ProcesalEditar']);
    Route::post('/procesal/actualizar', [ProcesalController::class, 'ProcesalActualizar']);
    Route::get('/procesal/expedientes', [ProcesalController::class, 'ProcesalExpedientes']);
    Route::post('/procesal/comunicacion', [ProcesalController::class, 'ProcesalComunicacion']);
    Route::post('/procesal/comunicacion-registrar', [ProcesalController::class, 'RegistrarComunicacion']);
    Route::get('/GetComunicaciones', [ProcesalController::class, 'ListarComunicaciones']);

    Route::get('/equipo', [EquipoController::class, 'Equipo']);
    Route::get('/GetEquipo', [EquipoController::class, 'GetEquipo']);
    Route::post('/equipo/registrar', [EquipoController::class, 'RegistrarIntegrante']);
    Route::get('/equipo/editar/{id}', [EquipoController::class, 'EditarIntegrante']);
    Route::post('/equipo/actualizar', [EquipoController::class, 'ActualizarIntegrante']);
    Route::post('/equipo/eliminar', [EquipoController::class, 'EliminarIntegrante']);

    Route::get('/reportes', [ReporteController::class, 'Reportes']);
});
