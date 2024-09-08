DROP PROCEDURE IF EXISTS LoguearUsuario;

DELIMITER //

CREATE PROCEDURE LoguearUsuario(
    IN  i_email      VARCHAR(100),
    OUT o_user_id    INT,
    OUT o_password_hash VARCHAR(255),
    OUT o_role_id    INT,
    OUT o_return_code INT
)
BEGIN
    DECLARE w_password_hash VARCHAR(255);
    DECLARE w_role_id INT;
    
    SET o_return_code = 9999;
    
    -- Obtener la contraseña y el rol del usuario
    SELECT password, rol_id INTO w_password_hash, w_role_id
    FROM USUARIOS
    WHERE email = i_email;
    
    IF w_password_hash IS NOT NULL THEN
        SET o_user_id = (SELECT id FROM USUARIOS WHERE email = i_email);
        SET o_password_hash = w_password_hash;
        SET o_role_id = w_role_id;
        SET o_return_code = 1503; -- Usuario encontrado
    ELSE
        SET o_return_code = 1505; -- Usuario no encontrado
    END IF;
END //

DELIMITER ;
