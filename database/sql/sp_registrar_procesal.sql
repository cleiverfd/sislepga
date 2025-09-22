DELIMITER $$

CREATE PROCEDURE sp_registrar_procesal(
    IN p_idExpediente INT,
    IN p_tipoPersona VARCHAR(100),
    IN p_tipoProcesal VARCHAR(100),
    IN p_condicion VARCHAR(100),
    IN p_dni VARCHAR(8),
    IN p_nombre VARCHAR(100),
    IN p_aPaterno VARCHAR(100),
    IN p_aMaterno VARCHAR(100),
    IN p_ruc VARCHAR(11),
    IN p_razonSocial VARCHAR(255),
    IN p_idDepartamento INT,
    IN p_idProvincia INT,
    IN p_idDistrito INT,
    IN p_calle VARCHAR(255),
    OUT Msj VARCHAR(255),
    OUT Msj2 VARCHAR(255)
)
BEGIN
    DECLARE v_idPersona INT DEFAULT NULL;

    -- Manejador de errores
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN
        SET Msj = '';
        SET Msj2 = CONCAT('ERROR AL REGISTRAR PROCESAL');
        ROLLBACK;
    END;

    START TRANSACTION;

    -- Buscar persona NATURAL por DNI
    IF p_tipoPersona = 'NATURAL' THEN
        SELECT id INTO v_idPersona 
        FROM personas 
        WHERE dni = p_dni AND estado_registro = 1 
        LIMIT 1;

        -- Si no existe, insertarla
        IF v_idPersona IS NULL THEN
            INSERT INTO personas (
                dni, apellido_paterno, apellido_materno, nombres,
                tipo_procesal, tipo_persona, condicion,
                id_departamento, id_provincia, id_distrito, direccion
            ) VALUES (
                p_dni, p_aPaterno, p_aMaterno, p_nombre,
                p_tipoProcesal, p_tipoPersona, p_condicion,
                p_idDepartamento, p_idProvincia, p_idDistrito, p_calle
            );

            SET v_idPersona = LAST_INSERT_ID();
        END IF;

    -- Buscar persona JURIDICA por RUC
    ELSEIF p_tipoPersona = 'JURIDICA' THEN
        SELECT id INTO v_idPersona 
        FROM personas 
        WHERE ruc = p_ruc AND estado_registro = 1 
        LIMIT 1;

        -- Si no existe, insertarla
        IF v_idPersona IS NULL THEN
            INSERT INTO personas (
                ruc, razon_social,
                tipo_procesal, tipo_persona, condicion,
                id_departamento, id_provincia, id_distrito, direccion
            ) VALUES (
                p_ruc, p_razonSocial,
                p_tipoProcesal, p_tipoPersona, p_condicion,
                p_idDepartamento, p_idProvincia, p_idDistrito, p_calle
            );

            SET v_idPersona = LAST_INSERT_ID();
        END IF;
    END IF;

    -- Insertar en tabla procesales
    INSERT INTO procesales (
        id_persona, id_expediente, tipo_procesal, tipo_persona, condicion
    ) VALUES (
        v_idPersona, p_idExpediente, p_tipoProcesal, p_tipoPersona, p_condicion
    );

    COMMIT;

    SET Msj = 'PROCESAL REGISTRADO CORRECTAMENTE';
    SET Msj2 = '';
END $$

DELIMITER ;
