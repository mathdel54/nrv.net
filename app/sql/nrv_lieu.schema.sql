CREATE TABLE "lieu"
(
    "id"                UUID PRIMARY KEY,
    "nom"               VARCHAR(255),
    "adresse"           TEXT,
    "nb_places_assises" INT,
    "nb_places_debout"  INT
);

CREATE TABLE "image_lieu"
(
    "id"      UUID PRIMARY KEY,
    "lien"    VARCHAR(255),
    "lieu_id" UUID
);

ALTER TABLE "image_lieu"
    ADD FOREIGN KEY ("lieu_id") REFERENCES "lieu" ("id");
