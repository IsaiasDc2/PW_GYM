DROP DATABASE IF EXISTS forja_gym;
CREATE DATABASE IF NOT EXISTS forja_gym CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE forja_gym;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE sedes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    direccion VARCHAR(120) NOT NULL,
    horario_semana VARCHAR(40) NOT NULL,
    horario_sabado VARCHAR(40) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE planes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL UNIQUE,
    descripcion VARCHAR(150) NOT NULL,
    precio_mensual DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categorias_clase (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL DEFAULT '',
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NULL,
    rol_id INT NOT NULL,
    sede_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuarios_rol FOREIGN KEY (rol_id) REFERENCES roles(id),
    CONSTRAINT fk_usuarios_sede FOREIGN KEY (sede_id) REFERENCES sedes(id)
) ENGINE=InnoDB;

CREATE TABLE clases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL,
    categoria_id INT NOT NULL,
    instructor_id INT NOT NULL,
    sede_id INT NOT NULL,
    dia_semana ENUM('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') NOT NULL,
    hora TIME NOT NULL,
    cupo INT NOT NULL DEFAULT 20,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_clases_categoria FOREIGN KEY (categoria_id) REFERENCES categorias_clase(id),
    CONSTRAINT fk_clases_instructor FOREIGN KEY (instructor_id) REFERENCES usuarios(id),
    CONSTRAINT fk_clases_sede FOREIGN KEY (sede_id) REFERENCES sedes(id)
) ENGINE=InnoDB;

CREATE TABLE suscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    plan_id INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    estado ENUM('activa','pausada','cancelada') NOT NULL DEFAULT 'activa',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_susc_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    CONSTRAINT fk_susc_plan FOREIGN KEY (plan_id) REFERENCES planes(id)
) ENGINE=InnoDB;

CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    clase_id INT NOT NULL,
    fecha DATE NOT NULL,
    estado ENUM('confirmada','cancelada','asistio') NOT NULL DEFAULT 'confirmada',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_reservas_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    CONSTRAINT fk_reservas_clase FOREIGN KEY (clase_id) REFERENCES clases(id) ON DELETE CASCADE,
    CONSTRAINT uq_reserva UNIQUE (usuario_id, clase_id, fecha)
) ENGINE=InnoDB;

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(120) NOT NULL,
    telefono VARCHAR(20) NULL,
    sede_id INT NOT NULL,
    mensaje TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_consultas_sede FOREIGN KEY (sede_id) REFERENCES sedes(id)
) ENGINE=InnoDB;

CREATE TABLE login_intentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(120) NOT NULL,
    ip VARCHAR(45) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE INDEX idx_login_intentos_email ON login_intentos(email, created_at);
CREATE INDEX idx_login_intentos_ip ON login_intentos(ip, created_at);
CREATE INDEX idx_usuarios_rol ON usuarios(rol_id);
CREATE INDEX idx_clases_categoria_dia ON clases(categoria_id, dia_semana);
CREATE INDEX idx_reservas_fecha ON reservas(fecha);
CREATE INDEX idx_suscripciones_estado ON suscripciones(estado);
