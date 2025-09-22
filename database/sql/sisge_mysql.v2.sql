-- ============================================
-- SISTEMA DE GESTIÓN LEGAL - BASE DE DATOS OPTIMIZADA
-- ============================================

-- Configuración inicial
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;

-- ============================================
-- TABLAS INDEPENDIENTES (Sin llaves foráneas)
-- ============================================

-- Tabla de departamentos
CREATE TABLE departamentos (
    id VARCHAR(10),
    descripcion VARCHAR(100),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de tipos de expedientes
CREATE TABLE tipos_expedientes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    codigo VARCHAR(10) UNIQUE NOT NULL,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nombre (nombre),
    INDEX idx_codigo (codigo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de distritos judiciales
CREATE TABLE distritos_judiciales (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    codigo VARCHAR(10) UNIQUE NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_descripcion (descripcion),
    INDEX idx_codigo (codigo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de áreas
CREATE TABLE areas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_descripcion (descripcion),
    INDEX idx_codigo (codigo),
    INDEX idx_email (email),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de personas
CREATE TABLE personas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dni CHAR(8) UNIQUE COMMENT 'DNI para personas naturales',
    apellido_paterno VARCHAR(100),
    apellido_materno VARCHAR(100),
    nombres VARCHAR(100),
    telefono_personal VARCHAR(20),
    correo_personal VARCHAR(100),
    
    -- Datos para personas jurídicas
    ruc CHAR(11) UNIQUE COMMENT 'RUC para personas jurídicas',
    razon_social VARCHAR(255),
    telefono_corporativo VARCHAR(20),
    correo_corporativo VARCHAR(100),
    representante_legal VARCHAR(255),
    
    -- Campos generales
    tipo_persona ENUM('NATURAL', 'JURIDICA') NOT NULL DEFAULT 'NATURAL',
    fallecido BOOLEAN DEFAULT FALSE,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Índices
    INDEX idx_dni (dni),
    INDEX idx_ruc (ruc),
    INDEX idx_apellidos (apellido_paterno, apellido_materno),
    INDEX idx_nombres (nombres),
    INDEX idx_razon_social (razon_social),
    INDEX idx_tipo_persona (tipo_persona),
    INDEX idx_fallecido (fallecido),
    INDEX idx_activo (activo),
    
    -- Validaciones
    CONSTRAINT chk_persona_natural CHECK (
        (tipo_persona = 'NATURAL' AND dni IS NOT NULL AND nombres IS NOT NULL) OR
        (tipo_persona = 'JURIDICA' AND ruc IS NOT NULL AND razon_social IS NOT NULL)
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de referencias de tipo
CREATE TABLE referencias_tipo (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nombre_tipo (nombre_tipo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLAS CON DEPENDENCIAS DE PRIMER NIVEL
-- ============================================

-- Tabla de provincias
CREATE TABLE provincias (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_departamento INT UNSIGNED NOT NULL,
    descripcion VARCHAR(100) NOT NULL,
    codigo_ubigeo CHAR(4) UNIQUE COMMENT 'Código UBIGEO de la provincia',
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_provincias_departamento 
        FOREIGN KEY (id_departamento) REFERENCES departamentos (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_departamento (id_departamento),
    INDEX idx_descripcion (descripcion),
    INDEX idx_codigo_ubigeo (codigo_ubigeo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de instancias
CREATE TABLE instancias (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_distrito_judicial INT UNSIGNED NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    nivel TINYINT UNSIGNED NOT NULL COMMENT '1=Primera, 2=Segunda, 3=Casación',
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_instancias_distrito_judicial 
        FOREIGN KEY (id_distrito_judicial) REFERENCES distritos_judiciales (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_distrito_judicial (id_distrito_judicial),
    INDEX idx_nombre (nombre),
    INDEX idx_codigo (codigo),
    INDEX idx_nivel (nivel),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de materias
CREATE TABLE materias (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_tipo_expediente INT UNSIGNED NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_materias_tipo_expediente 
        FOREIGN KEY (id_tipo_expediente) REFERENCES tipos_expedientes (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_tipo_expediente (id_tipo_expediente),
    INDEX idx_descripcion (descripcion),
    INDEX idx_codigo (codigo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de pretensiones
CREATE TABLE pretensiones (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_tipo_expediente INT UNSIGNED NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_pretensiones_tipo_expediente 
        FOREIGN KEY (id_tipo_expediente) REFERENCES tipos_expedientes (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_tipo_expediente (id_tipo_expediente),
    INDEX idx_descripcion (descripcion),
    INDEX idx_codigo (codigo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de abogados
CREATE TABLE abogados (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_persona INT UNSIGNED NOT NULL,
    numero_colegiatura VARCHAR(20) UNIQUE NOT NULL,
    colegio_abogados VARCHAR(100),
    expedientes_asignados INT UNSIGNED DEFAULT 0,
    disponible BOOLEAN DEFAULT TRUE,
    especialidad VARCHAR(100),
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_abogados_persona 
        FOREIGN KEY (id_persona) REFERENCES personas (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_persona (id_persona),
    INDEX idx_colegiatura (numero_colegiatura),
    INDEX idx_disponible (disponible),
    INDEX idx_especialidad (especialidad),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_persona INT UNSIGNED NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('ADMIN', 'ABOGADO', 'ASISTENTE', 'LECTURA') NOT NULL DEFAULT 'LECTURA',
    ultimo_acceso TIMESTAMP NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_usuarios_persona 
        FOREIGN KEY (id_persona) REFERENCES personas (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_persona (id_persona),
    INDEX idx_usuario (usuario),
    INDEX idx_rol (rol),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de sucesores
CREATE TABLE sucesores (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_fallecido INT UNSIGNED NOT NULL,
    id_sucesor INT UNSIGNED NOT NULL,
    parentesco VARCHAR(50),
    porcentaje_herencia DECIMAL(5,2) DEFAULT 100.00,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_sucesores_fallecido 
        FOREIGN KEY (id_fallecido) REFERENCES personas (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_sucesores_sucesor 
        FOREIGN KEY (id_sucesor) REFERENCES personas (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_fallecido (id_fallecido),
    INDEX idx_sucesor (id_sucesor),
    INDEX idx_activo (activo),
    
    UNIQUE KEY uk_fallecido_sucesor (id_fallecido, id_sucesor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de empleos
CREATE TABLE empleos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_persona INT UNSIGNED NOT NULL,
    profesion_ocupacion VARCHAR(100),
    centro_trabajo VARCHAR(255),
    cargo VARCHAR(100),
    ingreso_mensual DECIMAL(10,2),
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_empleos_persona 
        FOREIGN KEY (id_persona) REFERENCES personas (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_persona (id_persona),
    INDEX idx_profesion (profesion_ocupacion),
    INDEX idx_centro_trabajo (centro_trabajo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLAS CON DEPENDENCIAS DE SEGUNDO NIVEL
-- ============================================

-- Tabla de distritos
CREATE TABLE distritos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_provincia INT UNSIGNED NOT NULL,
    id_departamento INT UNSIGNED NOT NULL,
    descripcion VARCHAR(100) NOT NULL,
    codigo_ubigeo CHAR(6) UNIQUE COMMENT 'Código UBIGEO del distrito',
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_distritos_provincia 
        FOREIGN KEY (id_provincia) REFERENCES provincias (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_distritos_departamento 
        FOREIGN KEY (id_departamento) REFERENCES departamentos (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_provincia (id_provincia),
    INDEX idx_departamento (id_departamento),
    INDEX idx_descripcion (descripcion),
    INDEX idx_codigo_ubigeo (codigo_ubigeo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de especialidades
CREATE TABLE especialidades (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_tipo_expediente INT UNSIGNED NOT NULL,
    id_instancia INT UNSIGNED NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_especialidades_tipo_expediente 
        FOREIGN KEY (id_tipo_expediente) REFERENCES tipos_expedientes (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_especialidades_instancia 
        FOREIGN KEY (id_instancia) REFERENCES instancias (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_tipo_expediente (id_tipo_expediente),
    INDEX idx_instancia (id_instancia),
    INDEX idx_descripcion (descripcion),
    INDEX idx_codigo (codigo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de juzgados
CREATE TABLE juzgados (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_tipo_expediente INT UNSIGNED NOT NULL,
    id_distrito_judicial INT UNSIGNED NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    es_favorito BOOLEAN DEFAULT FALSE,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_juzgados_tipo_expediente 
        FOREIGN KEY (id_tipo_expediente) REFERENCES tipos_expedientes (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_juzgados_distrito_judicial 
        FOREIGN KEY (id_distrito_judicial) REFERENCES distritos_judiciales (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_tipo_expediente (id_tipo_expediente),
    INDEX idx_distrito_judicial (id_distrito_judicial),
    INDEX idx_descripcion (descripcion),
    INDEX idx_codigo (codigo),
    INDEX idx_favorito (es_favorito),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de fiscalías
CREATE TABLE fiscalias (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_tipo_expediente INT UNSIGNED NOT NULL,
    id_distrito_judicial INT UNSIGNED NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    usuario_registro VARCHAR(50),
    usuario_actualizacion VARCHAR(50),
    
    CONSTRAINT fk_fiscalias_tipo_expediente 
        FOREIGN KEY (id_tipo_expediente) REFERENCES tipos_expedientes (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_fiscalias_distrito_judicial 
        FOREIGN KEY (id_distrito_judicial) REFERENCES distritos_judiciales (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_tipo_expediente (id_tipo_expediente),
    INDEX idx_distrito_judicial (id_distrito_judicial),
    INDEX idx_descripcion (descripcion),
    INDEX idx_codigo (codigo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de tramites
CREATE TABLE tramites (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_area INT UNSIGNED NOT NULL,
    id_abogado INT UNSIGNED,
    numero VARCHAR(50) UNIQUE NOT NULL,
    expediente_externo VARCHAR(100),
    nombre TEXT,
    asunto TEXT NOT NULL,
    fecha_llegada DATE NOT NULL,
    fecha_derivacion TIMESTAMP NULL,
    anio YEAR NOT NULL,
    documento_recepcion VARCHAR(255),
    documento_pdf VARCHAR(255),
    estado_legal ENUM('P', 'T', 'F') DEFAULT 'P' COMMENT 'P=Pendiente, T=Tramitado, F=Finalizado',
    ubicacion VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_tramites_area 
        FOREIGN KEY (id_area) REFERENCES areas (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_tramites_abogado 
        FOREIGN KEY (id_abogado) REFERENCES abogados (id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    
    INDEX idx_area (id_area),
    INDEX idx_abogado (id_abogado),
    INDEX idx_numero (numero),
    INDEX idx_fecha_llegada (fecha_llegada),
    INDEX idx_anio (anio),
    INDEX idx_estado_legal (estado_legal),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLAS CON DEPENDENCIAS DE TERCER NIVEL
-- ============================================

-- Tabla de direcciones
CREATE TABLE direcciones (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_persona INT UNSIGNED NOT NULL,
    id_distrito INT UNSIGNED NOT NULL,
    id_provincia INT UNSIGNED NOT NULL,
    id_departamento INT UNSIGNED NOT NULL,
    tipo_via ENUM('CALLE', 'AVENIDA', 'JIRON', 'PASAJE', 'CARRETERA') DEFAULT 'CALLE',
    nombre_via VARCHAR(255) NOT NULL,
    numero VARCHAR(20),
    interior VARCHAR(20),
    manzana VARCHAR(10),
    lote VARCHAR(10),
    urbanizacion VARCHAR(100),
    referencia TEXT,
    es_principal BOOLEAN DEFAULT FALSE,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_direcciones_persona 
        FOREIGN KEY (id_persona) REFERENCES personas (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_direcciones_distrito 
        FOREIGN KEY (id_distrito) REFERENCES distritos (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_direcciones_provincia 
        FOREIGN KEY (id_provincia) REFERENCES provincias (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_direcciones_departamento 
        FOREIGN KEY (id_departamento) REFERENCES departamentos (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_persona (id_persona),
    INDEX idx_distrito (id_distrito),
    INDEX idx_provincia (id_provincia),
    INDEX idx_departamento (id_departamento),
    INDEX idx_principal (es_principal),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de expedientes
CREATE TABLE expedientes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(50) UNIQUE NOT NULL,
    carpeta_fiscal VARCHAR(50),
    sentencia VARCHAR(100),
    fecha_inicio DATE NOT NULL,
    id_pretension INT UNSIGNED NOT NULL,
    id_materia INT UNSIGNED NOT NULL,
    id_distrito_judicial INT UNSIGNED NOT NULL,
    id_instancia INT UNSIGNED NOT NULL,
    id_especialidad INT UNSIGNED NOT NULL,
    id_juzgado INT UNSIGNED,
    id_abogado INT UNSIGNED,
    id_tipo_expediente INT UNSIGNED NOT NULL,
    monto_pretension DECIMAL(15,2),
    estado_proceso ENUM('INICIADO', 'EN_TRAMITE', 'SENTENCIADO', 'EJECUTADO', 'ARCHIVADO') DEFAULT 'INICIADO',
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_expedientes_pretension 
        FOREIGN KEY (id_pretension) REFERENCES pretensiones (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_expedientes_materia 
        FOREIGN KEY (id_materia) REFERENCES materias (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_expedientes_distrito_judicial 
        FOREIGN KEY (id_distrito_judicial) REFERENCES distritos_judiciales (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_expedientes_instancia 
        FOREIGN KEY (id_instancia) REFERENCES instancias (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_expedientes_especialidad 
        FOREIGN KEY (id_especialidad) REFERENCES especialidades (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_expedientes_juzgado 
        FOREIGN KEY (id_juzgado) REFERENCES juzgados (id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_expedientes_abogado 
        FOREIGN KEY (id_abogado) REFERENCES abogados (id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_expedientes_tipo_expediente 
        FOREIGN KEY (id_tipo_expediente) REFERENCES tipos_expedientes (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_numero (numero),
    INDEX idx_carpeta_fiscal (carpeta_fiscal),
    INDEX idx_fecha_inicio (fecha_inicio),
    INDEX idx_pretension (id_pretension),
    INDEX idx_materia (id_materia),
    INDEX idx_distrito_judicial (id_distrito_judicial),
    INDEX idx_instancia (id_instancia),
    INDEX idx_especialidad (id_especialidad),
    INDEX idx_juzgado (id_juzgado),
    INDEX idx_abogado (id_abogado),
    INDEX idx_tipo_expediente (id_tipo_expediente),
    INDEX idx_estado_proceso (estado_proceso),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de documentos de trámite
CREATE TABLE documentos_tramite (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_tramite INT UNSIGNED NOT NULL,
    asunto VARCHAR(255) NOT NULL,
    descripcion TEXT,
    tipo_documento VARCHAR(50),
    ruta_archivo VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_documentos_tramite_tramite 
        FOREIGN KEY (id_tramite) REFERENCES tramites (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    
    INDEX idx_tramite (id_tramite),
    INDEX idx_tipo_documento (tipo_documento),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLAS CON DEPENDENCIAS DE CUARTO NIVEL
-- ============================================

-- Tabla de procesales (relación persona-expediente)
CREATE TABLE procesales (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_persona INT UNSIGNED NOT NULL,
    id_expediente INT UNSIGNED NOT NULL,
    tipo_procesal ENUM('DEMANDANTE', 'DEMANDADO', 'TERCERO', 'MINISTERIO_PUBLICO', 'TESTIGO') NOT NULL,
    tipo_persona ENUM('NATURAL', 'JURIDICA') NOT NULL,
    condicion_persona ENUM('ACTIVO', 'FALLECIDO', 'INCAPAZ', 'AUSENTE') DEFAULT 'ACTIVO',
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_procesales_persona 
        FOREIGN KEY (id_persona) REFERENCES personas (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_procesales_expediente 
        FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    
    INDEX idx_persona (id_persona),
    INDEX idx_expediente (id_expediente),
    INDEX idx_tipo_procesal (tipo_procesal),
    INDEX idx_tipo_persona (tipo_persona),
    INDEX idx_condicion_persona (condicion_persona),
    INDEX idx_activo (activo),
    
    UNIQUE KEY uk_persona_expediente_tipo (id_persona, id_expediente, tipo_procesal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de alertas
CREATE TABLE alertas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_expediente INT UNSIGNED NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_vencimiento DATE NOT NULL,
    dias_anticipacion INT DEFAULT 5,
    tipo_alerta ENUM('AUDIENCIA', 'PLAZO', 'VENCIMIENTO', 'RECORDATORIO') DEFAULT 'RECORDATORIO',
    prioridad ENUM('BAJA', 'MEDIA', 'ALTA', 'URGENTE') DEFAULT 'MEDIA',
    estado ENUM('PENDIENTE', 'NOTIFICADA', 'VENCIDA') DEFAULT 'PENDIENTE',
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_alertas_expediente 
        FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    
    INDEX idx_expediente (id_expediente),
    INDEX idx_fecha_vencimiento (fecha_vencimiento),
    INDEX idx_tipo_alerta (tipo_alerta),
    INDEX idx_prioridad (prioridad),
    INDEX idx_estado (estado),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de audiencias
CREATE TABLE audiencias (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_expediente INT UNSIGNED NOT NULL,
    id_persona INT UNSIGNED,
    id_abogado INT UNSIGNED,
    fecha_audiencia DATE NOT NULL,
    hora_audiencia TIME NOT NULL,
    lugar VARCHAR(255),
    enlace_virtual VARCHAR(500),
    tipo_audiencia ENUM('CONCILIACION', 'JUZGAMIENTO', 'ALEGATOS', 'SENTENCIA', 'OTROS') DEFAULT 'OTROS',
    detalles TEXT,
    estado ENUM('PROGRAMADA', 'REALIZADA', 'REPROGRAMADA', 'CANCELADA') DEFAULT 'PROGRAMADA',
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_audiencias_expediente 
        FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_audiencias_persona 
        FOREIGN KEY (id_persona) REFERENCES personas (id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_audiencias_abogado 
        FOREIGN KEY (id_abogado) REFERENCES abogados (id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    
    INDEX idx_expediente (id_expediente),
    INDEX idx_persona (id_persona),
    INDEX idx_abogado (id_abogado),
    INDEX idx_fecha_audiencia (fecha_audiencia),
    INDEX idx_hora_audiencia (hora_audiencia),
    INDEX idx_tipo_audiencia (tipo_audiencia),
    INDEX idx_estado (estado),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de documentos legales
CREATE TABLE documentos_legales (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_expediente INT UNSIGNED NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    tipo_documento ENUM('DEMANDA', 'CONTESTACION', 'RECURSO', 'SENTENCIA', 'RESOLUCION', 'ESCRITO', 'OTROS') DEFAULT 'OTROS',
    descripcion TEXT,
    ruta_archivo VARCHAR(500),
    tamaño_archivo BIGINT UNSIGNED,
    extension VARCHAR(10),
    fecha_documento DATE,
    numero_documento VARCHAR(50),
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_documentos_legales_expediente 
        FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    
    INDEX idx_expediente (id_expediente),
    INDEX idx_nombre (nombre),
    INDEX idx_tipo_documento (tipo_documento),
    INDEX idx_fecha_documento (fecha_documento),
    INDEX idx_numero_documento (numero_documento),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de historiales
CREATE TABLE historiales (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_persona INT UNSIGNED,
    id_expediente INT UNSIGNED NOT NULL,
    fecha_hora DATETIME NOT NULL,
    tipo_comunicacion ENUM('LLAMADA', 'EMAIL', 'WHATSAPP', 'PRESENCIAL', 'CARTA', 'OTROS') DEFAULT 'OTROS',
    detalle TEXT NOT NULL,
    observaciones TEXT,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_historiales_persona 
        FOREIGN KEY (id_persona) REFERENCES personas (id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_historiales_expediente 
        FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    
    INDEX idx_persona (id_persona),
    INDEX idx_expediente (id_expediente),
    INDEX idx_fecha_hora (fecha_hora),
    INDEX idx_tipo_comunicacion (tipo_comunicacion),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de montos de ejecución
CREATE TABLE montos_ejecucion (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_expediente INT UNSIGNED NOT NULL,
    capital_principal DECIMAL(15,2) DEFAULT 0.00,
    capital_secundario DECIMAL(15,2) DEFAULT 0.00,
    interes_principal DECIMAL(15,2) DEFAULT 0.00,
    interes_secundario DECIMAL(15,2) DEFAULT 0.00,
    costos_procesales DECIMAL(15,2) DEFAULT 0.00,
    costas_procesales DECIMAL(15,2) DEFAULT 0.00,
    monto_total_sentencia DECIMAL(15,2) DEFAULT 0.00,
    monto_pagado DECIMAL(15,2) DEFAULT 0.00,
    saldo_pendiente DECIMAL(15,2) DEFAULT 0.00,
    fecha_calculo DATE NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_montos_ejecucion_expediente 
        FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    
    INDEX idx_expediente (id_expediente),
    INDEX idx_fecha_calculo (fecha_calculo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de oficios de expedientes
CREATE TABLE oficios_expedientes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_expediente INT UNSIGNED NOT NULL,
    numero_correlativo VARCHAR(50) NOT NULL,
    numero_oficio VARCHAR(100) UNIQUE NOT NULL,
    asunto TEXT NOT NULL,
    fecha_envio DATE NOT NULL,
    destinatario VARCHAR(255) NOT NULL,
    cargo_destinatario VARCHAR(100),
    institucion_destinataria VARCHAR(255),
    estado_oficio ENUM('ENVIADO', 'RECIBIDO', 'RESPONDIDO', 'PENDIENTE') DEFAULT 'ENVIADO',
    fecha_respuesta DATE,
    ruta_archivo VARCHAR(500),
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_oficios_expedientes_expediente 
        FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    
    INDEX idx_expediente (id_expediente),
    INDEX idx_numero_correlativo (numero_correlativo),
    INDEX idx_numero_oficio (numero_oficio),
    INDEX idx_fecha_envio (fecha_envio),
    INDEX idx_destinatario (destinatario),
    INDEX idx_estado_oficio (estado_oficio),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de reportes de trámite
CREATE TABLE reportes_tramite (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_tramite INT UNSIGNED NOT NULL,
    id_expediente INT UNSIGNED,
    id_abogado INT UNSIGNED,
    id_area INT UNSIGNED NOT NULL,
    numero_informe VARCHAR(50),
    numero_oficio VARCHAR(50),
    anio YEAR NOT NULL,
    asunto TEXT NOT NULL,
    fecha_llegada DATE NOT NULL,
    pdf_oficio VARCHAR(500),
    pdf_informe VARCHAR(500),
    informe_externo VARCHAR(500),
    estado_reporte ENUM('BORRADOR', 'ENVIADO', 'APROBADO', 'RECHAZADO') DEFAULT 'BORRADOR',
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_reportes_tramite_tramite 
        FOREIGN KEY (id_tramite) REFERENCES tramites (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_reportes_tramite_expediente 
        FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_reportes_tramite_abogado 
        FOREIGN KEY (id_abogado) REFERENCES abogados (id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_reportes_tramite_area 
        FOREIGN KEY (id_area) REFERENCES areas (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    
    INDEX idx_tramite (id_tramite),
    INDEX idx_expediente (id_expediente),
    INDEX idx_abogado (id_abogado),
    INDEX idx_area (id_area),
    INDEX idx_anio (anio),
    INDEX idx_fecha_llegada (fecha_llegada),
    INDEX idx_estado_reporte (estado_reporte),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de reportes generales
CREATE TABLE reportes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    tipo_reporte ENUM('EXPEDIENTES', 'AUDIENCIAS', 'TRAMITES', 'ESTADISTICAS', 'OTROS') DEFAULT 'OTROS',
    parametros_reporte JSON,
    fecha_generacion DATETIME NOT NULL,
    ruta_archivo VARCHAR(500),
    estado_reporte ENUM('GENERANDO', 'COMPLETADO', 'ERROR') DEFAULT 'GENERANDO',
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_reportes_usuario 
        FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    
    INDEX idx_usuario (id_usuario),
    INDEX idx_tipo_reporte (tipo_reporte),
    INDEX idx_fecha_generacion (fecha_generacion),
    INDEX idx_estado_reporte (estado_reporte),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de auditorías
CREATE TABLE auditorias (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED,
    accion ENUM('CREATE', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT') NOT NULL,
    tabla_afectada VARCHAR(50) NOT NULL,
    id_registro INT UNSIGNED,
    valores_anteriores JSON,
    valores_nuevos JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_auditorias_usuario 
        FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    
    INDEX idx_usuario (id_usuario),
    INDEX idx_accion (accion),
    INDEX idx_tabla_afectada (tabla_afectada),
    INDEX idx_id_registro (id_registro),
    INDEX idx_fecha_registro (fecha_registro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TRIGGERS Y PROCEDIMIENTOS ALMACENADOS
-- ============================================

-- Trigger para actualizar contador de expedientes en abogados
DELIMITER //
CREATE TRIGGER trg_expedientes_insert_abogado
AFTER INSERT ON expedientes
FOR EACH ROW
BEGIN
    IF NEW.id_abogado IS NOT NULL THEN
        UPDATE abogados 
        SET expedientes_asignados = expedientes_asignados + 1,
            fecha_actualizacion = CURRENT_TIMESTAMP
        WHERE id = NEW.id_abogado;
    END IF;
END //

CREATE TRIGGER trg_expedientes_update_abogado
AFTER UPDATE ON expedientes
FOR EACH ROW
BEGIN
    -- Si se cambió el abogado
    IF OLD.id_abogado != NEW.id_abogado THEN
        -- Decrementar del abogado anterior
        IF OLD.id_abogado IS NOT NULL THEN
            UPDATE abogados 
            SET expedientes_asignados = expedientes_asignados - 1,
                fecha_actualizacion = CURRENT_TIMESTAMP
            WHERE id = OLD.id_abogado;
        END IF;
        
        -- Incrementar al nuevo abogado
        IF NEW.id_abogado IS NOT NULL THEN
            UPDATE abogados 
            SET expedientes_asignados = expedientes_asignados + 1,
                fecha_actualizacion = CURRENT_TIMESTAMP
            WHERE id = NEW.id_abogado;
        END IF;
    END IF;
END //

CREATE TRIGGER trg_expedientes_delete_abogado
AFTER DELETE ON expedientes
FOR EACH ROW
BEGIN
    IF OLD.id_abogado IS NOT NULL THEN
        UPDATE abogados 
        SET expedientes_asignados = expedientes_asignados - 1,
            fecha_actualizacion = CURRENT_TIMESTAMP
        WHERE id = OLD.id_abogado;
    END IF;
END //

-- Trigger para calcular saldo pendiente en montos de ejecución
CREATE TRIGGER trg_montos_ejecucion_calculate
BEFORE INSERT ON montos_ejecucion
FOR EACH ROW
BEGIN
    SET NEW.monto_total_sentencia = NEW.capital_principal + NEW.capital_secundario + 
                                   NEW.interes_principal + NEW.interes_secundario + 
                                   NEW.costos_procesales + NEW.costas_procesales;
    SET NEW.saldo_pendiente = NEW.monto_total_sentencia - NEW.monto_pagado;
END //

CREATE TRIGGER trg_montos_ejecucion_update_calculate
BEFORE UPDATE ON montos_ejecucion
FOR EACH ROW
BEGIN
    SET NEW.monto_total_sentencia = NEW.capital_principal + NEW.capital_secundario + 
                                   NEW.interes_principal + NEW.interes_secundario + 
                                   NEW.costos_procesales + NEW.costas_procesales;
    SET NEW.saldo_pendiente = NEW.monto_total_sentencia - NEW.monto_pagado;
END //

DELIMITER ;

-- ============================================
-- PROCEDIMIENTOS ALMACENADOS ÚTILES
-- ============================================

DELIMITER //

-- Procedimiento para obtener expedientes por abogado
CREATE PROCEDURE sp_expedientes_por_abogado(IN p_id_abogado INT UNSIGNED)
BEGIN
    SELECT 
        e.id,
        e.numero,
        e.fecha_inicio,
        e.estado_proceso,
        e.monto_pretension,
        p.descripcion AS pretension,
        m.descripcion AS materia,
        dj.descripcion AS distrito_judicial,
        j.descripcion AS juzgado
    FROM expedientes e
    LEFT JOIN pretensiones p ON e.id_pretension = p.id
    LEFT JOIN materias m ON e.id_materia = m.id
    LEFT JOIN distritos_judiciales dj ON e.id_distrito_judicial = dj.id
    LEFT JOIN juzgados j ON e.id_juzgado = j.id
    WHERE e.id_abogado = p_id_abogado 
    AND e.activo = TRUE
    ORDER BY e.fecha_inicio DESC;
END //

-- Procedimiento para obtener alertas próximas a vencer
CREATE PROCEDURE sp_alertas_proximas(IN p_dias_anticipacion INT DEFAULT 7)
BEGIN
    SELECT 
        a.id,
        a.titulo,
        a.descripcion,
        a.fecha_vencimiento,
        a.tipo_alerta,
        a.prioridad,
        e.numero AS numero_expediente,
        DATEDIFF(a.fecha_vencimiento, CURDATE()) AS dias_restantes
    FROM alertas a
    INNER JOIN expedientes e ON a.id_expediente = e.id
    WHERE a.activo = TRUE 
    AND a.estado = 'PENDIENTE'
    AND DATEDIFF(a.fecha_vencimiento, CURDATE()) <= p_dias_anticipacion
    AND a.fecha_vencimiento >= CURDATE()
    ORDER BY a.fecha_vencimiento ASC, a.prioridad DESC;
END //

-- Procedimiento para obtener estadísticas de expedientes
CREATE PROCEDURE sp_estadisticas_expedientes()
BEGIN
    SELECT 
        COUNT(*) AS total_expedientes,
        COUNT(CASE WHEN estado_proceso = 'INICIADO' THEN 1 END) AS iniciados,
        COUNT(CASE WHEN estado_proceso = 'EN_TRAMITE' THEN 1 END) AS en_tramite,
        COUNT(CASE WHEN estado_proceso = 'SENTENCIADO' THEN 1 END) AS sentenciados,
        COUNT(CASE WHEN estado_proceso = 'EJECUTADO' THEN 1 END) AS ejecutados,
        COUNT(CASE WHEN estado_proceso = 'ARCHIVADO' THEN 1 END) AS archivados,
        AVG(monto_pretension) AS monto_promedio,
        SUM(monto_pretension) AS monto_total
    FROM expedientes
    WHERE activo = TRUE;
END //

DELIMITER ;

-- ============================================
-- ÍNDICES ADICIONALES PARA OPTIMIZACIÓN
-- ============================================

-- Índices compuestos para consultas frecuentes
CREATE INDEX idx_expedientes_estado_fecha ON expedientes (estado_proceso, fecha_inicio);
CREATE INDEX idx_expedientes_abogado_estado ON expedientes (id_abogado, estado_proceso);
CREATE INDEX idx_audiencias_fecha_estado ON audiencias (fecha_audiencia, estado);
CREATE INDEX idx_alertas_vencimiento_estado ON alertas (fecha_vencimiento, estado);
CREATE INDEX idx_procesales_expediente_tipo ON procesales (id_expediente, tipo_procesal);

-- ============================================
-- DATOS INICIALES (OPCIONAL)
-- ============================================

-- Insertar tipos de expedientes básicos
INSERT INTO tipos_expedientes (nombre, codigo, descripcion) VALUES
('CIVIL', 'CIV', 'Procesos civiles'),
('PENAL', 'PEN', 'Procesos penales'),
('LABORAL', 'LAB', 'Procesos laborales'),
('CONTENCIOSO', 'CON', 'Procesos contencioso administrativos'),
('FAMILIA', 'FAM', 'Procesos de familia'),
('COMERCIAL', 'COM', 'Procesos comerciales');

-- Insertar referencias de tipo básicas
INSERT INTO referencias_tipo (nombre_tipo, descripcion) VALUES
('ESTADO_CIVIL', 'Estados civiles de personas'),
('PARENTESCO', 'Tipos de parentesco'),
('PROFESION', 'Profesiones y ocupaciones'),
('DOCUMENTO', 'Tipos de documentos');

-- Finalizar transacción
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

-- ============================================
-- COMENTARIOS FINALES
-- ============================================

/*
MEJORAS IMPLEMENTADAS:

1. ESTRUCTURA Y ORDEN:
   - Tablas ordenadas por dependencias
   - Nombres más descriptivos y consistentes
   - Tipos de datos optimizados

2. OPTIMIZACIONES:
   - Índices estratégicos para consultas frecuentes
   - Uso de UNSIGNED para IDs
   - Campos ENUM para valores predefinidos
   - Campos JSON para datos estructurados

3. INTEGRIDAD:
   - Constraints de clave foránea con ON DELETE y ON UPDATE
   - Validaciones CHECK
   - Campos únicos donde corresponde

4. FUNCIONALIDAD:
   - Triggers para cálculos automáticos
   - Procedimientos almacenados útiles
   - Campos de auditoría consistentes

5. RENDIMIENTO:
   - Índices compuestos para consultas complejas
   - Uso de InnoDB para transacciones
   - Charset UTF8MB4 para soporte completo

6. MANTENIBILIDAD:
   - Comentarios explicativos
   - Nomenclatura consistente
   - Estructura modular
*/