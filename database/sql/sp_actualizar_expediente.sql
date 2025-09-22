DELIMITER $$

DROP PROCEDURE sp_actualizar_expediente;

CREATE PROCEDURE sp_actualizar_expediente(
    IN p_idExpediente INT,
    IN p_numero VARCHAR(255),
    IN p_carpeta VARCHAR(255),
    IN p_contrato VARCHAR(255),
    IN p_fechaInicio DATE,
    IN p_idPretension INT,
    IN p_montoPretension DECIMAL(18,2),
    IN p_idMateria INT,
    IN p_idDJudicial INT,
    IN p_idInstancia INT,
    IN p_idFiscalia INT,
    IN p_idEspecialidad INT,
    IN p_idJuzgado INT,
    IN p_idEstado INT,
    IN p_idTipo INT,
    IN p_totalSentencia DECIMAL(18,2),
    IN p_saldoTotal DECIMAL(18,2),
    OUT Msj VARCHAR(255),
    OUT Msj2 VARCHAR(255)
)
BEGIN
    DECLARE v_estadoExpediente VARCHAR(100);

    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN
        SET Msj = '';
        SET Msj2 = 'ERROR AL ACTUALIZAR EXPEDIENTE';
        ROLLBACK;
    END;

    BEGIN
        IF p_idEstado = 1 THEN
            SET v_estadoExpediente = 'EN TRAMITE';
        ELSEIF p_idEstado = 2 THEN
            SET v_estadoExpediente = 'EN EJECUCION';
        ELSEIF p_idEstado = 3 THEN
            SET v_estadoExpediente = 'ARCHIVADO';
        ELSE
            SET v_estadoExpediente = 'DESCONOCIDO';
        END IF;
    END;

    START TRANSACTION;

    UPDATE expedientes
    SET
        numero = p_numero,
        carpeta_fiscal = p_carpeta,
        contrato_referencia = p_contrato,
        fecha_inicio = p_fechaInicio,
        id_pretension = p_idPretension,
        monto_pretension = p_montoPretension,
        id_materia = p_idMateria,
        id_distrito_judicial = p_idDJudicial,
        id_instancia = p_idInstancia,
        id_fiscalia = p_idFiscalia,
        id_especialidad = p_idEspecialidad,
        id_juzgado = p_idJuzgado,
        id_tipo_expediente = p_idTipo,
        id_estado_expediente = p_idEstado,
        estado_expediente = v_estadoExpediente,
        total_sentencia = p_totalSentencia,
        saldo_total = p_saldoTotal
    WHERE id = p_idExpediente;

    COMMIT;

    SET Msj = 'EXPEDIENTE ACTUALIZADO CORRECTAMENTE';
    SET Msj2 = '';
END $$

DELIMITER ;
