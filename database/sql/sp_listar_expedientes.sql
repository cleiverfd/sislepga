DELIMITER $$

CREATE PROCEDURE sp_listar_expedientes (
    IN p_id_tipo_expediente INT,
    IN p_id_estado_expediente INT
)
BEGIN
    SELECT 
        ex.id, 
        ex.numero, 
        ex.fecha_inicio, 
        pe.descripcion AS pretension, 
        ex.estado_expediente,
        ex.fecha_registro
    FROM expedientes ex
    JOIN pretensiones pe ON ex.id_pretension = pe.id
    WHERE ex.estado_registro = 1
    AND (p_id_tipo_expediente IS NULL OR ex.id_tipo_expediente = p_id_tipo_expediente)
	AND (p_id_estado_expediente IS NULL OR ex.estado_expediente = p_id_estado_expediente);
END $$

DELIMITER ;
