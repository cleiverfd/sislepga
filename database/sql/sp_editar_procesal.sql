DELIMITER $$

CREATE PROCEDURE sp_editar_procesal(
    IN p_idProcesal INT,
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

    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN
        SET Msj = '';
        SET Msj2 = CONCAT('ERROR AL REGISTRAR PROCESAL');
        ROLLBACK;
    END;

    START TRANSACTION;

    UPDATE personas SET 
        dni = p_dni,
        apellido_paterno = p_aPaterno,
        apellido_materno = p_aMaterno,
        nombres = p_nombre,
        ruc = p_ruc,
        razon_social = p_razonSocial,
        id_departamento = p_idDepartamento,
        id_provincia = p_idProvincia,
        id_distrito = p_idDistrito,
        direccion = p_calle
    WHERE id = p_idProcesal AND estado_registro = 1;

    SET Msj = 'PROCESAL ACTUALIZADO CORRECTAMENTE';
    SET Msj2 = '';
END $$

DELIMITER ;
