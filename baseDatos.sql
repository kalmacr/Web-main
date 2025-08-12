
/* ------------------------------------------------------------------ */
/* 1) Base de datos                                                   */
/* ------------------------------------------------------------------ */
CREATE DATABASE IF NOT EXISTS reciclaje
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE reciclaje;

/* ------------------------------------------------------------------ */
/* 2) Tablas catálogo                                                 */
/* ------------------------------------------------------------------ */
CREATE TABLE tipo_material (
    id_tipo          INT          NOT NULL AUTO_INCREMENT,
    nombre           VARCHAR(50)  NOT NULL UNIQUE,
    PRIMARY KEY(id_tipo)
);

/* ------------------------------------------------------------------ */
CREATE TABLE materiales (
    id_material      INT          NOT NULL AUTO_INCREMENT,
    nombre           VARCHAR(100) NOT NULL,
    id_tipo          INT          NOT NULL,
    puntos_asignados INT          NOT NULL,
    PRIMARY KEY(id_material),
    CONSTRAINT fk_material_tipo
        FOREIGN KEY (id_tipo)
        REFERENCES tipo_material(id_tipo)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

/* ------------------------------------------------------------------ */
CREATE TABLE recompensa (
    id_recompensa    INT          NOT NULL AUTO_INCREMENT,
    nombre           VARCHAR(100) NOT NULL,
    descripcion      TEXT,
    puntos_asignados INT          NOT NULL,   --  puntos necesarios
    imagen_url	varchar(255),
    PRIMARY KEY(id_recompensa)
);

/* ------------------------------------------------------------------ */
/* 3) Tabla de usuarios                                               */
/* ------------------------------------------------------------------ */
CREATE TABLE usuarios (
    id_usuario  INT          NOT NULL AUTO_INCREMENT,
    nombre       VARCHAR(100) NOT NULL,
    correo       VARCHAR(120) NOT NULL UNIQUE,
    contraseña   VARCHAR(255) NOT NULL,       -- guarda HASH, nunca texto plano
    puntos       INT          NOT NULL DEFAULT 0,
    tipo_usuario VARCHAR(20)  NOT NULL DEFAULT 'normal',
    PRIMARY KEY(id_usuario)
);

/* ------------------------------------------------------------------ */
/* 4) Registro de materiales reciclados                               */
/* ------------------------------------------------------------------ */
CREATE TABLE registro_materiales (
    id_registro  INT           NOT NULL AUTO_INCREMENT,
    usuario_id   INT           NOT NULL,
    material_id  INT           NOT NULL,
    cantidad     DECIMAL(10,2) NOT NULL,
    fecha        DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id_registro),
    CONSTRAINT fk_registro_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE,
    CONSTRAINT fk_registro_material
        FOREIGN KEY (material_id)
        REFERENCES materiales(id_material)
        ON DELETE RESTRICT
);

/* ------------------------------------------------------------------ */
/* 5) Canjes de recompensas                                           */
/* ------------------------------------------------------------------ */
CREATE TABLE canjes (
    id_canje      INT       NOT NULL AUTO_INCREMENT,
    id_usuario   INT       NOT NULL,
    id_recompensa INT       NOT NULL,
    fecha         DATETIME  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id_canje),
    CONSTRAINT fk_canje_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios (id_usuario)
        ON DELETE CASCADE,
    CONSTRAINT fk_canje_recompensa
        FOREIGN KEY (id_recompensa)
        REFERENCES recompensa(id_recompensa)
        ON DELETE RESTRICT
);

/* ------------------------------------------------------------------ */
/* 6) Ubicaciones y detalle de direcciones                            */
/* ------------------------------------------------------------------ */
CREATE TABLE detalle_direccion (
    id_direccion INT          NOT NULL AUTO_INCREMENT,
    provincia    VARCHAR(60)  NOT NULL,
    canton       VARCHAR(60)  NOT NULL,
    distrito     VARCHAR(60)  NOT NULL,
    PRIMARY KEY(id_direccion)
);

CREATE TABLE ubicaciones (
    id_ubicacion INT          NOT NULL AUTO_INCREMENT,
    nombre       VARCHAR(100) NOT NULL,
    direccion    INT,
    direccion_axacta VARCHAR(100),
    telefono VARCHAR(15),
    PRIMARY KEY(id_ubicacion),
    CONSTRAINT fk_ubicacion_dir
        FOREIGN KEY (direccion)
        REFERENCES detalle_direccion(id_direccion)
        ON DELETE SET NULL
);

/* ------------------------------------------------------------------ */
/* 7) FAQ                                                             */
/* ------------------------------------------------------------------ */
CREATE TABLE faq (
    id_faq   INT  NOT NULL AUTO_INCREMENT,
    pregunta TEXT NOT NULL,
    respuesta TEXT NOT NULL,
    PRIMARY KEY(id_faq)
);

/* ------------------------------------------------------------------ */
/* 8) Índices auxiliares (rendimiento de búsquedas frecuentes)        */
/* ------------------------------------------------------------------ */
CREATE INDEX idx_registro_usuario_fecha  ON registro_materiales (id_usuario , fecha);
CREATE INDEX idx_registro_material_fecha ON registro_materiales (material_id, fecha);
CREATE INDEX idx_canjes_usuario_fecha    ON canjes             (id_usuario, fecha);

--Insert de las tablas 
INSERT INTO tipo_material (nombre) VALUES 
('Plástico'),
('Metal'),
('Papel'),
('Vidrio');

INSERT INTO materiales (nombre, id_tipo, puntos_asignados) VALUES
('Botella PET', 1, 5),
('Lata de aluminio', 2, 7),
('Periódico viejo', 3, 3),
('Frasco de vidrio', 4, 4);


--

INSERT INTO detalle_direccion (provincia, canton, distrito) VALUES
('San José', 'Escazú', 'San Rafael'),
('Alajuela', 'Alajuela', 'Carrizal');

-- Usa LAST_INSERT_ID() para asociar correctamente
INSERT INTO ubicaciones (nombre, direccion, direccion_axacta, telefono) VALUES
('Sede Central Escazú', 1, 'Frente al parque central', '+506 8888-8888'),
('Sede Carrizal', 2, '300 metros norte del colegio técnico', '+506 8777-4321');

INSERT INTO faq (pregunta, respuesta) VALUES
('¿Cómo obtengo puntos?', 'Reciclando materiales en las sedes registradas.'),
('¿Qué puedo canjear con mis puntos?', 'Recompensas como botellas ecológicas, descuentos y entradas a eventos.');


INSERT INTO recompensa (nombre, descripcion, puntos_asignados, imagen_url) VALUES
('Botella ecológica', 'Botella reutilizable para agua (750ml).', 100, 'https://ejemplo.com/imagenes/botella.png'),
('Descuento del 15%', 'Canjea este cupón para obtener un 15% de descuento en tiendas asociadas.', 150, 'https://ejemplo.com/imagenes/descuento.png'),
('Camisa reciclada', 'Camiseta hecha con materiales reciclados. Talla única.', 200, 'https://ejemplo.com/imagenes/camisa.png'),
('Entrada a cine', 'Una entrada válida para cines nacionales.', 250, 'https://ejemplo.com/imagenes/cine.png'),
('Tarjeta de regalo ₡5000', 'Para usar en supermercados o tiendas de conveniencia.', 300, 'https://ejemplo.com/imagenes/tarjeta.png');


INSERT INTO canjes (id_usuario, id_recompensa) VALUES (1, 3);
