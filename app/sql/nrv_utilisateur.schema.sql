CREATE TABLE "utilisateur"
(
    "id"                  UUID PRIMARY KEY,
    "nom"                 VARCHAR(255),
    "prenom"              VARCHAR(255),
    "email"               VARCHAR(255) UNIQUE,
    "mot_de_passe"        VARCHAR(255),
    "date_enregistrement" TIMESTAMP
);
