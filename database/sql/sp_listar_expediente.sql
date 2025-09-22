DELIMITER $$

CREATE PROCEDURE sp_listar_expediente (
    IN p_idexpediente INT,
)
BEGIN
   SELECT 
        id, numero, carpeta_fiscal, contrato_referencia, fecha_inicio, id_pretension, id_materia, id_distrito_judicial, id_instancia, id_especialidad
        id_juzgado, id_fiscalia, id_abogado, id_estado_expediente, estado_expediente, id_tipo_expediente, monto_pretension, total_sentencia, saldo_total, fecha_registro,
        fecha_actualizacion
    FROM expedientes
    WHERE id = p_idexpediente
    AND estado_registro = 1
END $$

DELIMITER;