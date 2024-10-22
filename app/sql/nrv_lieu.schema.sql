CREATE TABLE "Lieu"
(
    "id"                UUID PRIMARY KEY,
    "nom"               VARCHAR(255),
    "adresse"           TEXT,
    "nb_places_assises" INT,
    "nb_places_debout"  INT
);