DELIMITER $$

CREATE PROCEDURE sp_listar_usuarios ()
BEGIN
    SELECT * FROM usuarios
    WHERE estado_registro = 1
    AND rol <> 'ADMIN'
    ORDER BY id DESC
END $$

DELIMITER ;
