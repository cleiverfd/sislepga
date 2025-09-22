DELIMITER $$

DROP PROCEDURE IF EXISTS sp_listar_audiencias$$

CREATE PROCEDURE sp_listar_audiencias (
    IN p_idExpediente INT
)
BEGIN
    SELECT
        ad.id,
        ad.id_expediente,
        ex.numero as numero_expediente,
        ad.id_persona,
        ad.persona,
        ad.fecha,
        ad.lugar,
        ad.enlace,
        ad.descripcion,
        ad.dias_faltantes,
        ad.fecha_registro
    FROM audiencias ad
    JOIN expedientes ex on ad.id_expediente = ex.id
    JOIN personas pe on ad.id_persona = pe.id
    WHERE ad.estado_registro = 1
    AND ad.id_expediente = p_idExpediente;
END $$

DELIMITER ;
