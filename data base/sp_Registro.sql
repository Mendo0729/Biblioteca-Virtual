DELIMITER //

CREATE PROCEDURE RegistrarUsuario(
    IN  i_nombre     VARCHAR(100),
    IN  i_email      VARCHAR(100),
    IN  i_password   VARCHAR(255),
    IN  i_rol        VARCHAR(50),
    OUT o_retorno    INT
)
BEGIN
    DECLARE w_rol_id INT;
    DECLARE w_rowcount INT;

    SET o_retorno = 9999;

    -- Obtener el ID del rol basado en el nombre
    SELECT id INTO w_rol_id FROM ROL WHERE nombre = i_rol LIMIT 1;

    -- Verificar si el correo ya existe
    SELECT COUNT(*) INTO w_rowcount
    FROM USUARIOS
    WHERE email = i_email;

    IF w_rowcount > 0 THEN
        SET o_retorno = 1504; -- Correo ya registrado
    ELSE
        -- Insertar nuevo usuario
        INSERT INTO USUARIOS (nombre, email, password, rol_id)
        VALUES (i_nombre, i_email, i_password, w_rol_id);

        SET o_retorno = 1503; -- Registro exitoso
    END IF;
END //

DELIMITER ;

CALL RegistrarUsuario(
    'Abdiel Mendoza',                   -- Nombre del usuario
    'abdielmendoza2906@gmail.com',       -- Email del usuario
    MD5('123456789'),     -- Contraseña cifrada
    'Administrador',           -- Nombre del rol
    @resultado                 -- Variable de salida para el resultado
);

-- Para ver el resultado del procedimiento
SELECT @resultado AS 'Resultado';

