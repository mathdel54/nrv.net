CREATE TABLE "spectacle"
(
    "id"                   UUID PRIMARY KEY,
    "titre"                VARCHAR(255),
    "description"          TEXT,
    "url_video"            VARCHAR(255),
    "horaire_previsionnel" TIME,
    "soiree_id"            UUID,
    "style"                VARCHAR(255)
);