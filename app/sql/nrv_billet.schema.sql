CREATE TABLE "billet"
(
    "id"             UUID PRIMARY KEY,
    "utilisateur_id" UUID,
    "tarif"          VARCHAR(255),
    "date_achat"     TIMESTAMP,
    "soiree_id"      UUID
);
