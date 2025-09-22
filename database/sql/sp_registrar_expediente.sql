DELIMITER $$

CREATE PROCEDURE sp_registrar_expediente(
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
    OUT IdExpediente INT,
    OUT Msj VARCHAR(255),
    OUT Msj2 VARCHAR(255)
)
BEGIN

	DECLARE v_estadoExpediente VARCHAR(100);

    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN
        SET Msj = '';
        SET Msj2 = 'ERROR AL REGISTRAR EXPEDIENTE';
        SET IdExpediente = NULL;
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

    INSERT INTO expedientes (
        numero,
        carpeta_fiscal,
        contrato_referencia,
        fecha_inicio,
        id_pretension,
        monto_pretension,
        id_materia,
        id_distrito_judicial,
        id_instancia,
        id_fiscalia,
        id_especialidad,
        id_juzgado,
        id_tipo_expediente,
        id_estado_expediente,
        estado_expediente,
        total_sentencia,
        saldo_total
    ) VALUES (
        p_numero,
        p_carpeta,
        p_contrato,
        p_fechaInicio,
        p_idPretension,
        p_montoPretension,
        p_idMateria,
        p_idDJudicial,
        p_idInstancia,
        p_idFiscalia,
        p_idEspecialidad,
        p_idJuzgado,
        p_idTipo,
        p_idEstado,
        v_estadoExpediente,
        p_totalSentencia,
        p_saldoTotal
    );

    SET IdExpediente = LAST_INSERT_ID(); 

    COMMIT;

    SET Msj = 'EXPEDIENTE REGISTRADO CORRECTAMENTE';
    SET Msj2 = '';
END $$

DELIMITER ;
