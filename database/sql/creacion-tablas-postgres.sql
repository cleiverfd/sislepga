CREATE TABLE direcciones (
    id SERIAL PRIMARY KEY,
    id_persona INT,
    id_distrito INT,
    id_provincia INT,
    id_departamento INT,
    calle_avenida VARCHAR(255),
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_direcciones_distrito FOREIGN KEY (id_distrito) REFERENCES distritos (id),
    CONSTRAINT fk_direcciones_provincia FOREIGN KEY (id_provincia) REFERENCES provincias (id),
    CONSTRAINT fk_direcciones_departamento FOREIGN KEY (id_departamento) REFERENCES departamentos (id),
    CONSTRAINT fk_direcciones_persona FOREIGN KEY (id_persona) REFERENCES personas (id)
);

CREATE TABLE alertas (
    id SERIAL PRIMARY KEY,
    id_expediente INT,
    fecha_vencimiento VARCHAR(255),
    descripcion TEXT,
    dias_faltantes TEXT,
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_alertas_expediente FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
);

CREATE TABLE areas (
    id SERIAL PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    email VARCHAR(50) NOT NULL,
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1
);

CREATE TABLE audiencias (
    id SERIAL PRIMARY KEY,
    id_expediente INT,
    id_persona INT,
    id_abogado INT,
    fecha DATE,
    hora TIME,
    lugar VARCHAR(255),
    enlace VARCHAR(255),
    detalles VARCHAR(255),
    dias_faltantes DECIMAL(10, 2),
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_audiencias_expediente FOREIGN KEY (id_expediente) REFERENCES expedientes (id),
    CONSTRAINT fk_audiencias_abogado FOREIGN KEY (id_abogado) REFERENCES abogados (id),
    CONSTRAINT fk_audiencias_persona FOREIGN KEY (id_persona) REFERENCES personas (id)
);

CREATE TABLE auditorias (
    id SERIAL PRIMARY KEY,
    accion VARCHAR(255),
    modelo VARCHAR(255),
    id_modelo VARCHAR(255),
    id_usuario INT,
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_auditorias_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
);

CREATE TABLE pretensiones (
    id SERIAL PRIMARY KEY,
    id_tipo INT,
    descripcion VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_reclamos_tipo FOREIGN KEY (id_tipo) REFERENCES tipos_procedimiento (id)
);

CREATE TABLE juzgados (
    id SERIAL PRIMARY KEY,
    id_tipo INT,
    id_distrito_judicial INT,
    descripcion VARCHAR(255),
    favorito INT DEFAULT 0,
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_tribunales_distrito FOREIGN KEY (id_distrito_judicial) REFERENCES distritos_judiciales (id),
    CONSTRAINT fk_tribunales_tipo FOREIGN KEY (id_tipo) REFERENCES tipos_procedimiento (id)
);

CREATE TABLE departamentos (
    id SERIAL PRIMARY KEY,
    descripcion VARCHAR(100)
);

CREATE TABLE distritos (
    id SERIAL PRIMARY KEY,
    id_provincia INT,
    id_departamento INT,
    descripcion VARCHAR(255),
    CONSTRAINT fk_distritos_departamento FOREIGN KEY (id_departamento) REFERENCES departamentos (id),
    CONSTRAINT fk_distritos_provincia FOREIGN KEY (id_provincia) REFERENCES provincias (id)
);

CREATE TABLE montos_ejecucion (
    id SERIAL PRIMARY KEY,
    id_expediente INT,
    ejecucion_1 DECIMAL(20, 2),
    ejecucion_2 DECIMAL(20, 2),
    interes_1 DECIMAL(20, 2),
    interes_2 DECIMAL(20, 2),
    costos DECIMAL(20, 2),
    monto_total_sentencia DECIMAL(10, 2),
    saldo_total_pagadero DECIMAL(10, 2),
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_montos_expediente FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
);

CREATE TABLE historiales (
    id SERIAL PRIMARY KEY,
    id_persona INT,
    id_expediente INT,
    fecha_hora TIMESTAMP,
    medio_comunicacion VARCHAR(255),
    detalle TEXT,
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_historiales_persona FOREIGN KEY (id_persona) REFERENCES personas (id),
    CONSTRAINT fk_historiales_expediente FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
);

CREATE TABLE instancias (
    id SERIAL PRIMARY KEY,
    id_tipo INT,
    id_distrito_judicial INT,
    nombre VARCHAR(255),
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_instancias_distrito FOREIGN KEY (id_distrito_judicial) REFERENCES distritos_judiciales (id),
    CONSTRAINT fk_instancias_tipo FOREIGN KEY (id_tipo) REFERENCES tipos_procedimiento (id)
);

CREATE TABLE empleos (
    id SERIAL PRIMARY KEY,
    id_persona INT,
    profesion_ocupacion VARCHAR(255),
    centro_trabajo VARCHAR(255),
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_empleos_persona FOREIGN KEY (id_persona) REFERENCES personas (id)
);

CREATE TABLE distritos_judiciales (
    id SERIAL PRIMARY KEY,
    descripcion VARCHAR(255),
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1
);

CREATE TABLE abogados (
    id SERIAL PRIMARY KEY,
    id_persona INT,
    expedientes_asignados INT DEFAULT 0,
    disponibilidad BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_abogados_persona FOREIGN KEY (id_persona) REFERENCES personas (id)
);

CREATE TABLE documentos_legales (
    id SERIAL PRIMARY KEY,
    id_expediente INT,
    nombre VARCHAR(255),
    tipo VARCHAR(255),
    descripcion TEXT,
    ruta_archivo VARCHAR(255),
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_documentos_legales_expediente FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
);

CREATE TABLE oficios_expedientes (
    id SERIAL PRIMARY KEY,
    id_expediente INT,
    numero_correlativo VARCHAR(255),
    asunto TEXT,
    fecha_envio DATE,
    destinatario VARCHAR(255),
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_oficios_expedientes_expediente FOREIGN KEY (id_expediente) REFERENCES expedientes (id)
);

CREATE TABLE personas (
    id SERIAL PRIMARY KEY,
    dni VARCHAR(8) UNIQUE,
    apellido_paterno VARCHAR(55),
    apellido_materno VARCHAR(55),
    nombres VARCHAR(55),
    telefono_natural VARCHAR(55),
    correo_natural VARCHAR(55),
    ruc VARCHAR(255),
    razon_social VARCHAR(255),
    telefono_juridico VARCHAR(255),
    correo_juridico VARCHAR(255),
    representante_legal VARCHAR(255),
    tipo_procesal VARCHAR(55),
    condicion VARCHAR(55),
    tipo_persona VARCHAR(255),
    fallecido INT DEFAULT 0,
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1
);

CREATE TABLE expedientes (
    id SERIAL PRIMARY KEY,
    numero VARCHAR(255) UNIQUE,
    carpeta_fiscal VARCHAR(255),
    sentencia VARCHAR(255),
    fecha_inicio DATE,
    id_pretension INT,
    id_materia INT,
    id_distrito_judicial INT,
    id_instancia INT,
    id_especialidad INT,
    id_juzgado INT,
    id_abogado INT,
    id_tipo INT,
    monto_pretension DECIMAL(20, 2),
    estado_proceso VARCHAR(255),
    fecha_registro TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_procesos_pretension FOREIGN KEY (id_pretension) REFERENCES pretensiones(id),
    CONSTRAINT fk_procesos_materia FOREIGN KEY (id_materia) REFERENCES materias(id),
    CONSTRAINT fk_procesos_distrito_judicial FOREIGN KEY (id_distrito_judicial) REFERENCES distritos_judiciales(id),
    CONSTRAINT fk_procesos_instancia FOREIGN KEY (id_instancia) REFERENCES instancias(id),
    CONSTRAINT fk_procesos_especialidad FOREIGN KEY (id_especialidad) REFERENCES especialidades(id),
    CONSTRAINT fk_procesos_juzgado FOREIGN KEY (id_juzgado) REFERENCES juzgados(id),
    CONSTRAINT fk_procesos_abogado FOREIGN KEY (id_abogado) REFERENCES abogados(id),
    CONSTRAINT fk_procesos_tipo FOREIGN KEY (id_tipo) REFERENCES tipos(id)
);

CREATE TABLE tipos_expedientes (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(255),
    estado VARCHAR(255)
);

CREATE TABLE procesales (
    id SERIAL PRIMARY KEY,
    id_persona INT,
    id_expediente INT,
    tipo_procesal VARCHAR(255),
    tipo_persona VARCHAR(255),
    condicion_persona VARCHAR(255),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_procesales_expediente FOREIGN KEY (id_expediente) REFERENCES expedientes (id),
    CONSTRAINT fk_procesales_persona FOREIGN KEY (id_persona) REFERENCES personas (id)
);

CREATE TABLE provincias (
    id SERIAL PRIMARY KEY,
    id_departamento INT,
    descripcion VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_provincias_departamento FOREIGN KEY (id_departamento) REFERENCES departamentos (id)
);

CREATE TABLE reportes (
    id SERIAL PRIMARY KEY,
    id_usuario INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_reportes_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
);

CREATE TABLE especialidades (
    id SERIAL PRIMARY KEY,
    id_tipo INT,
    id_instancia INT,
    descripcion VARCHAR(255),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_especialidades_instancias FOREIGN KEY (id_instancia) REFERENCES instancias (id),
    CONSTRAINT fk_especialidades_tipos FOREIGN KEY (id_tipo) REFERENCES tipos_expedientes (id)
);

CREATE TABLE materias (
    id SERIAL PRIMARY KEY,
    id_tipo INT,
    descripcion VARCHAR(255),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_materias_tipos FOREIGN KEY (id_tipo) REFERENCES tipos_procedimientos (id)
);

CREATE TABLE sucesores (
    id SERIAL PRIMARY KEY,
    id_fallecido INT,
    id_succesor INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_sucesores_fallecido FOREIGN KEY (id_fallecido) REFERENCES personas (id),
    CONSTRAINT fk_sucesores_sucesor FOREIGN KEY (id_succesor) REFERENCES personas (id)
);

CREATE TABLE tramites (
    id SERIAL PRIMARY KEY,
    area_id INT,
    abogado_id INT,
    numero VARCHAR(50),
    expediente_externo VARCHAR(255),
    asunto VARCHAR(255),
    fecha_llegada VARCHAR(255),
    documento_recepcion VARCHAR(255),
    estado_legal CHAR(1),
    ubicacion VARCHAR(255),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    documento_pdf VARCHAR(255),
    nombre TEXT,
    anio INT,
    fecha_derivacion TIMESTAMP,
    CONSTRAINT fk_tramites_abogado FOREIGN KEY (abogado_id) REFERENCES abogados (id),
    CONSTRAINT fk_tramites_area FOREIGN KEY (area_id) REFERENCES areas (id)
);

CREATE TABLE documentos_tramite (
    id SERIAL PRIMARY KEY,
    asunto VARCHAR(255),
    descripcion VARCHAR(255),
    id_tramite INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_documentos_tramite_tramite FOREIGN KEY (id_tramite) REFERENCES tramites (id)
);

CREATE TABLE reportes_tramite (
    id SERIAL PRIMARY KEY,
    id_tramite INT,
    id_expediente INT,
    id_abogado INT,
    id_area INT,
    informe VARCHAR(255),
    oficio VARCHAR(255),
    anio INT NOT NULL,
    pdf_oficio VARCHAR(255),
    pdf_informe VARCHAR(255),
    informe_externo VARCHAR(255),
    asunto VARCHAR(2000),
    fecha_llegada VARCHAR(50),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_reportes_tramite_abogado FOREIGN KEY (id_abogado) REFERENCES abogados (id),
    CONSTRAINT fk_reportes_tramite_area FOREIGN KEY (id_area) REFERENCES areas (id),
    CONSTRAINT fk_reportes_tramite_expediente FOREIGN KEY (id_expediente) REFERENCES expedientes (id),
    CONSTRAINT fk_reportes_tramite_tramite FOREIGN KEY (id_tramite) REFERENCES tramites (id)
);

CREATE TABLE referencias_tipo (
    id SERIAL PRIMARY KEY,
    nombre_tipo VARCHAR(50),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1
);

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(255),
    correo VARCHAR(255),
    rol VARCHAR(255),
    id_persona INT,
    password VARCHAR(255),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP,
    estado_registro INT DEFAULT 1,
    CONSTRAINT fk_usuarios_persona FOREIGN KEY (id_persona) REFERENCES personas (id)
);