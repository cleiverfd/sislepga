DELIMITER $$

DROP PROCEDURE IF EXISTS sp_buscar_persona$$

CREATE PROCEDURE sp_buscar_persona(
    IN p_tipoPersona VARCHAR(20),
    IN p_documento VARCHAR(20)
)
BEGIN
    SELECT 
        id,
        dni,
        nombres,
        apellido_paterno,
        apellido_materno,
        ruc,
        razon_social,
        tipo_persona,
        tipo_procesal,
        condicion,
        id_distrito,
        id_provincia,
        id_departamento,
        calle_avenida
    FROM personas
     WHERE 
        estado_registro = 1
        AND (
            (p_tipoPersona = 'NATURAL' AND dni = p_documento) OR
            (p_tipoPersona = 'JURIDICA' AND ruc = p_documento)
        );
END$$

DELIMITER ;
