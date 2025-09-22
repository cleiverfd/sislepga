SELECT
    *
FROM
    sisge_15052025.departments;

SELECT
    *
FROM
    sisge_2.departamentos
INSERT INTO
    sisge_2.departamentos(descripcion)
SELECT
    UPPER(descripcion)
FROM
    sisge_15052025.departments;

SELECT
    *
FROM
    sisge_15052025.provinces
SELECT
    *
FROM
    sisge_2.provincias
INSERT INTO
    sisge_2.provincias(id, id_departamento, descripcion)
SELECT
    pro_id,
    dep_id,
    UPPER(pro_nombre)
FROM
    sisge_15052025.provinces
SELECT
    *
FROM
    sisge_15052025.districts;

SELECT
    *
FROM
    sisge_2.distritos
INSERT INTO
    sisge_2.distritos(id, id_provincia, id_departamento, descripcion)
SELECT
    dis_id,
    pro_id,
    dep_id,
    UPPER(dis_nombre)
FROM
    sisge_15052025.districts
SELECT
    *
FROM
    sisge_15052025.claims;

SELECT
    *
FROM
    sisge_2.pretensiones;

INSERT INTO
    sisge_2.pretensiones(id, id_tipo_expediente, descripcion)
SELECT
    pre_id,
    type_id,
    UPPER(pre_nombre)
FROM
    sisge_15052025.claims;

SELECT
    *
FROM
    sisge_15052025.judicial_districts;

SELECT
    *
FROM
    sisge_2.distritos_judiciales;

INSERT INTO
    sisge_2.distritos_judiciales(id, descripcion)
SELECT
    judis_id,
    UPPER(judis_nombre)
FROM
    sisge_15052025.judicial_districts;

SELECT
    *
FROM
    sisge_15052025.subjects;

SELECT
    *
FROM
    sisge_2.materias;

INSERT INTO
    sisge_2.materias(id, id_tipo_expediente, descripcion)
SELECT
    mat_id,
    type_id,
    UPPER(mat_nombre)
FROM
    sisge_15052025.subjects;

SELECT
    *
FROM
    sisge_15052025.instances;

SELECT
    *
FROM
    sisge_2.instancias;

INSERT INTO
    sisge_2.instancias(
        id,
        id_tipo_expediente,
        id_distrito_judicial,
        descripcion
    )
SELECT
    ins_id,
    type_id,
    judis_id,
    UPPER(ins_nombre)
FROM
    sisge_15052025.instances;

SELECT
    *
FROM
    sisge_15052025.specialties;

SELECT
    *
FROM
    sisge_2.especialidades;

INSERT INTO
    sisge_2.especialidades(id, id_tipo_expediente, descripcion)
SELECT
    esp_id,
    type_id,
    UPPER(esp_nombre)
FROM
    sisge_15052025.specialties;

#juzgados
SELECT
    *
FROM
    sisge_15052025.courts;

SELECT
    *
FROM
    sisge_2.juzgados;

INSERT INTO
    sisge_2.juzgados(
        id,
        id_tipo_expediente,
        id_distrito_judicial,
        descripcion
    )
SELECT
    co_id,
    type_id,
    judis_id,
    UPPER(co_nombre)
FROM
    sisge_15052025.courts;

#personas
SELECT
    *
FROM
    sisge_15052025.persons;

SELECT
    *
FROM
    sisge_2.personas;

INSERT INTO
    sisge_2.personas (
        id,
        dni,
        apellido_paterno,
        apellido_materno,
        nombres,
        telefono_natural,
        correo_natural,
        ruc,
        razon_social,
        telefono_juridico,
        correo_juridico,
        tipo_procesal,
        procesal_condicion,
        tipo_persona,
        fallecido,
        fecha_registro,
        estado_registro
    )
SELECT
    per_id,
    nat_dni,
    UPPER(nat_apellido_paterno),
    UPPER(nat_apellido_materno),
    UPPER(nat_nombres),
    nat_telefono,
    nat_correo,
    jur_ruc,
    UPPER(jur_razon_social),
    jur_telefono,
    jur_correo,
    UPPER(tipo_procesal),
    UPPER(per_condicion),
    UPPER(tipo_persona),
    fallecido,
    created_at,
    CASE
        WHEN deleted_at IS NULL THEN 1
        ELSE 2
    END AS estado_registro
FROM
    sisge_15052025.persons;

#abogados
SELECT
    *
FROM
    sisge_15052025.lawyers;

SELECT
    *
FROM
    sisge_2.abogados;

INSERT INTO
    sisge_2.abogados(
        id,
        id_persona,
        expedientes_asignados,
        fecha_registro,
        estado_registro
    )
SELECT
    abo_id,
    per_id,
    abo_carga_laboral,
    created_at,
    CASE
        WHEN deleted_at IS NULL THEN 1
        ELSE 2
    END AS estado_registro
FROM
    sisge_15052025.lawyers;

#expedientes
SELECT
    *
FROM
    sisge_15052025.proceedings;

SELECT
    *
FROM
    sisge_2.expedientes;

INSERT INTO
    sisge_2.expedientes (
        id,
        id_pretension,
        id_materia,
        id_distrito_judicial,
        id_instancia,
        id_especialidad,
        id_juzgado,
        id_abogado,
        id_tipo_expediente,
        numero,
        carpeta_fiscal,
        sentencia,
        fecha_inicio,
        monto_pretension,
        estado_proceso,
        fecha_registro,
        estado_registro
    )
SELECT
    p.exp_id,
    NULLIF(p.exp_pretencion, 0),
    NULLIF(p.exp_materia, 0),
    NULLIF(p.exp_dis_judicial, 0),
    NULLIF(p.exp_instancia, 0),
    NULLIF(p.exp_especialidad, 0),
    NULLIF(p.exp_juzgado, 0),
    NULLIF(p.abo_id, 0),
    NULLIF(p.type_id, 0),
    UPPER(p.exp_numero),
    p.carpeta_fiscal,
    p.sentencia,
    p.exp_fecha_inicio,
    p.exp_monto_pretencion,
    p.exp_estado_proceso,
    p.created_at,
    CASE
        WHEN p.deleted_at IS NULL THEN 1
        ELSE 2
    END AS estado_registro
FROM
    sisge_15052025.proceedings p
WHERE
    EXISTS (
        SELECT
            1
        FROM
            sisge_2.materias m
        WHERE
            m.id = NULLIF(p.exp_materia, 0)
    )
    AND EXISTS (
        SELECT
            1
        FROM
            sisge_2.pretensiones pt
        WHERE
            pt.id = NULLIF(p.exp_pretencion, 0)
    )
    AND EXISTS (
        SELECT
            1
        FROM
            sisge_2.distritos_judiciales dj
        WHERE
            dj.id = NULLIF(p.exp_dis_judicial, 0)
    )
    AND EXISTS (
        SELECT
            1
        FROM
            sisge_2.instancias i
        WHERE
            i.id = NULLIF(p.exp_instancia, 0)
    )
    AND EXISTS (
        SELECT
            1
        FROM
            sisge_2.especialidades e
        WHERE
            e.id = NULLIF(p.exp_especialidad, 0)
    )
    AND EXISTS (
        SELECT
            1
        FROM
            sisge_2.juzgados j
        WHERE
            j.id = NULLIF(p.exp_juzgado, 0)
    )
    AND EXISTS (
        SELECT
            1
        FROM
            sisge_2.abogados a
        WHERE
            a.id = NULLIF(p.abo_id, 0)
    )
    AND EXISTS (
        SELECT
            1
        FROM
            sisge_2.tipos_expedientes t
        WHERE
            t.id = NULLIF(p.type_id, 0)
    );

INSERT INTO
    sisge_2.expedientes (
        id,
        id_pretension,
        id_materia,
        id_distrito_judicial,
        id_instancia,
        id_especialidad,
        id_juzgado,
        id_abogado,
        id_tipo_expediente,
        numero,
        carpeta_fiscal,
        sentencia,
        fecha_inicio,
        monto_pretension,
        estado_proceso,
        fecha_registro,
        estado_registro
    )
SELECT
    p.exp_id,
    p.exp_pretencion,
    CASE
        WHEN p.exp_materia = 0 THEN NULL
        ELSE p.exp_materia
    END AS id_materia,
    p.exp_dis_judicial,
    p.exp_instancia,
    CASE
        WHEN p.exp_especialidad = 0 THEN NULL
        ELSE p.exp_especialidad
    END AS id_especialidad,
    CASE
        WHEN p.exp_juzgado = 0 THEN NULL
        ELSE p.exp_juzgado
    END AS id_juzgado,
    p.abo_id,
    p.type_id,
    UPPER(p.exp_numero),
    p.carpeta_fiscal,
    p.sentencia,
    p.exp_fecha_inicio,
    p.exp_monto_pretencion,
    p.exp_estado_proceso,
    p.created_at,
    CASE
        WHEN p.deleted_at IS NULL THEN 1
        ELSE 2
    END AS estado_registro
FROM
    sisge_15052025.proceedings p;

#procesales
SELECT
    *
FROM
    sisge_15052025.procesals;

SELECT
    *
FROM
    sisge_2.procesales;

INSERT INTO
    sisge_2.procesales (
        id,
        id_persona,
        id_expediente,
        tipo_procesal,
        tipo_persona,
        condicion,
        fecha_registro,
        estado_registro
    )
SELECT
    p.proc_id,
    p.per_id,
    p.exp_id,
    p.tipo_procesal,
    p.tipo_persona,
    pr.per_condicion,
    p.created_at,
    CASE
        WHEN p.deleted_at IS NULL THEN 1
        ELSE 2
    END AS estado_registro
FROM
    sisge_15052025.procesals p
    LEFT JOIN sisge_15052025.persons pr ON pr.per_id = p.per_id;

#direcciones
SELECT
    *
FROM
    sisge_15052025.addresses;

SELECT
    *
FROM
    sisge_2.direcciones;

INSERT INTO
    sisge_2.direcciones (
        id,
        id_persona,
        id_distrito,
        id_provincia,
        id_departamento,
        calle_avenida,
        fecha_registro,
        estado_registro
    )
SELECT
    dir_id,
    per_id,
    NULLIF(dis_id, 0),
    NULLIF(pro_id, 0),
    NULLIF(dep_id, 0),
    dir_calle_av,
    created_at,
    CASE
        WHEN deleted_at IS NULL THEN 1
        ELSE 2
    END AS estado_registro
FROM
    sisge_15052025.addresses;

#montos de ejecucion
SELECT
    *
FROM
    sisge_15052025.execution_amounts;

SELECT
    *
FROM
    sisge_2.montos_ejecucion;

INSERT INTO
    sisge_2.montos_ejecucion(
        id,
        id_expediente,
        ejecucion_1,
        ejecucion_2,
        interes_1,
        interes_2,
        costos,
        monto_total_sentencia,
        saldo_total,
        fecha_registro,
        estado_registro
    )
SELECT
    ex_id,
    exp_id,
    NULLIF(ex_ejecucion_1, 0),
    NULLIF(ex_ejecucion_2, 0),
    NULLIF(ex_interes_1, 0),
    NULLIF(ex_interes_2, 0),
    NULLIF(ex_costos, 0),
    NULLIF(total_amount_sentence, 0),
    NULLIF(total_balance_payable, 0),
    created_at,
    CASE
        WHEN deleted_at IS NULL THEN 1
        ELSE 2
    END AS estado_registro
FROM
    sisge_15052025.execution_amounts;

#documentos_legales
SELECT
    *
FROM
    sisge_15052025.legal_documents;

SELECT
    *
FROM
    sisge_2.documentos_legales;

INSERT INTO
    sisge_2.documentos_legales(
        id,
        id_expediente,
        nombre,
        tipo,
        descripcion,
        ruta_archivo,
        fecha_registro,
        estado_registro
    )
SELECT
    doc_id,
    exp_id,
    UPPER(doc_nombre),
    UPPER(doc_tipo),
    UPPER(doc_desciprcion),
    doc_ruta_archivo,
    created_at,
    CASE
        WHEN deleted_at IS NULL THEN 1
        ELSE 2
    END AS estado_registro
FROM
    sisge_15052025.legal_documents;

#tramites
SELECT
    *
FROM
    sisge_15052025.trades;

SELECT
    *
FROM
    sisge_2.tramites;

INSERT INTO
    sisge_2.tramites(
        id,
        id_area,
        id_abogado,
        numero,
        expediente_externo,
        asunto,
        fecha_llegada,
        documento_recepcion,
        estado_legal,
        ubicacion,
        documento_pdf,
        nombre,
        anio,
        fecha_derivacion,
        fecha_registro,
        estado_registro
    )
SELECT
    tra_id,
    tra_are_id,
    tra_abo_id,
    tra_number,
    UPPER(tra_exp_ext),
    UPPER(tra_matter),
    -- Conversión segura para fecha_llegada
    CASE
        WHEN tra_arrival_date LIKE '__/__/____' THEN STR_TO_DATE(tra_arrival_date, '%d/%m/%Y')
        WHEN tra_arrival_date LIKE '____-__-__' THEN tra_arrival_date
        ELSE NULL
    END,
    UPPER(tra_doc_recep),
    UPPER(tra_state_law),
    UPPER(tra_ubication),
    UPPER(tra_pdf),
    UPPER(tra_name),
    anio,
    -- Conversión segura para fecha_derivacion
    CASE
        WHEN tra_der_date LIKE '__/__/____' THEN STR_TO_DATE(tra_der_date, '%d/%m/%Y')
        WHEN tra_der_date LIKE '____-__-__' THEN tra_der_date
        ELSE NULL
    END,
    created_at,
    CASE
        WHEN deleted_at IS NULL THEN 1
        ELSE 2
    END
FROM
    sisge_15052025.trades;