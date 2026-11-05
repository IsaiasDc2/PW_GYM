USE forja_gym;

-- CREATE: tablas maestras
INSERT INTO roles (nombre) VALUES ('admin'), ('instructor'), ('usuario');

INSERT INTO sedes (nombre, direccion, horario_semana, horario_sabado) VALUES
    ('Forja Centro', 'Av. Principal 100', '06:00 - 23:00', '08:00 - 20:00'),
    ('Forja Norte', 'Calle Norte 200', '06:00 - 23:00', '08:00 - 20:00'),
    ('Forja Sur', 'Calle Sur 300', '06:00 - 23:00', '08:00 - 20:00');

INSERT INTO planes (nombre, descripcion, precio_mensual) VALUES
    ('Básico', 'Sala de pesas, vestuarios, app y 1 clase por semana', 18900.00),
    ('Pro', 'Clases ilimitadas, 1 sesión PT por mes, nutrición y 3 sedes', 29900.00),
    ('Elite', '4 sesiones PT por mes, plan nutricional y wearables', 44900.00);

INSERT INTO categorias_clase (nombre) VALUES
    ('Funcional'), ('CrossFit'), ('Spinning'), ('Yoga'), ('Boxing'), ('Pilates');

-- CREATE: usuarios, clases, suscripciones y reservas (tabla principal y detalle)
INSERT INTO usuarios (nombre, apellido, email, password, telefono, rol_id, sede_id) VALUES
    ('Lucía', 'Gómez', 'lucia@forjagym.com.ar', '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ01234', '1155550001', 2, 1),
    ('Diego', 'Torres', 'diego@forjagym.com.ar', '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ01234', '1155550002', 2, 2),
    ('Isaías', 'Socio', 'socio1@mail.com', '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ01234', '1155550003', 3, 1),
    ('Marta', 'Pérez', 'socio2@mail.com', '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ01234', NULL, 3, 2);

INSERT INTO clases (nombre, categoria_id, instructor_id, sede_id, dia_semana, hora, cupo) VALUES
    ('Funcional AM', 1, 1, 1, 'Lunes', '09:00:00', 20),
    ('WOD CrossFit', 2, 2, 2, 'Miércoles', '19:00:00', 15),
    ('Yoga Flow', 4, 1, 1, 'Viernes', '08:00:00', 18);

INSERT INTO suscripciones (usuario_id, plan_id, fecha_inicio) VALUES
    (3, 2, '2026-09-01'),
    (4, 1, '2026-09-05');

INSERT INTO reservas (usuario_id, clase_id, fecha) VALUES
    (3, 1, '2026-10-26'),
    (3, 3, '2026-10-30'),
    (4, 2, '2026-10-28');

-- READ: WHERE + ORDER BY
SELECT id, nombre, dia_semana, hora, cupo
FROM clases
WHERE dia_semana IN ('Lunes', 'Viernes')
ORDER BY hora ASC;

-- READ: INNER JOIN (clase, categoría, instructor y sede)
SELECT c.nombre AS clase,
       cat.nombre AS categoria,
       CONCAT(u.nombre, ' ', u.apellido) AS instructor,
       s.nombre AS sede,
       c.dia_semana,
       c.hora
FROM clases c
INNER JOIN categorias_clase cat ON cat.id = c.categoria_id
INNER JOIN usuarios u ON u.id = c.instructor_id
INNER JOIN sedes s ON s.id = c.sede_id
ORDER BY c.dia_semana, c.hora;

-- READ: INNER JOIN (reservas de cada socio)
SELECT CONCAT(u.nombre, ' ', u.apellido) AS socio, c.nombre AS clase, r.fecha, r.estado
FROM reservas r
INNER JOIN usuarios u ON u.id = r.usuario_id
INNER JOIN clases c ON c.id = r.clase_id
WHERE r.estado = 'confirmada'
ORDER BY r.fecha;

-- UPDATE
UPDATE planes SET precio_mensual = 31900.00 WHERE nombre = 'Pro';

UPDATE reservas SET estado = 'cancelada' WHERE usuario_id = 4 AND clase_id = 2;

-- DELETE
DELETE FROM reservas WHERE usuario_id = 4 AND clase_id = 2 AND estado = 'cancelada';
