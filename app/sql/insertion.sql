-- Adminer 4.8.1 PostgreSQL 16.4 (Debian 16.4-1.pgdg120+1) dump

DROP TABLE IF EXISTS "artiste";
CREATE TABLE "public"."artiste" (
    "id" uuid NOT NULL,
    "nom" character varying(50),
    CONSTRAINT "artiste_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "artiste" ("id", "nom") VALUES
('40bd2432-5670-480c-a2ed-716fa7e7165d',	'John Doe Quartet'),
('ac508fd3-885f-4530-96e7-576585604d22',	'The Rockers'),
('1adf0f50-2744-4149-b65b-7044d79ead8d',	'Orchestre National');

DROP TABLE IF EXISTS "artiste_spectacle";
CREATE TABLE "public"."artiste_spectacle" (
    "id_artiste" uuid,
    "id_spectacle" uuid
) WITH (oids = false);

INSERT INTO "artiste_spectacle" ("id_artiste", "id_spectacle") VALUES
('40bd2432-5670-480c-a2ed-716fa7e7165d',	'44533365-fbba-4dd3-865b-1f8af96b3e57'),
('ac508fd3-885f-4530-96e7-576585604d22',	'acc717f5-ced0-4896-89a7-5cd5bca8d669'),
('1adf0f50-2744-4149-b65b-7044d79ead8d',	'd8804296-3d11-43c5-92eb-02a087cfb10f');

DROP TABLE IF EXISTS "billet";
CREATE TABLE "public"."billet" (
    "id" uuid NOT NULL,
    "utilisateur_id" uuid,
    "tarif" character varying(20),
    "date_achat" timestamp,
    "soiree_id" uuid,
    CONSTRAINT "billet_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "billet" ("id", "utilisateur_id", "tarif", "date_achat", "soiree_id") VALUES
('a74cc649-41b8-4fa8-b0e4-2e67148e6cbe',	'f7c1eba2-7a35-4ca6-9d8b-eaa9636f4070',	'normal',	'2024-10-22 09:59:47.592324',	'dc4722c7-7fb8-4a21-8b6d-0a567997d874'),
('33eec6eb-2e1c-4c32-9e80-ce22662a493d',	'a3cd8e39-9dec-4376-a9c8-53356985ba31',	'reduit',	'2024-10-22 09:59:47.592324',	'ee766414-2945-4c8b-9812-c232e14888c7'),
('4791422d-67f4-4966-9f13-32cf49c72e8d',	'a3cd8e39-9dec-4376-a9c8-53356985ba31',	'normal',	'2024-10-22 09:59:47.592324',	'ee766414-2945-4c8b-9812-c232e14888c7');

DROP TABLE IF EXISTS "image_lieu";
CREATE TABLE "public"."image_lieu" (
    "id" uuid NOT NULL,
    "lien" character varying(255),
    "lieu_id" uuid,
    CONSTRAINT "image_lieu_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "image_spectacle";
CREATE TABLE "public"."image_spectacle" (
    "id" uuid NOT NULL,
    "lien" character varying(255),
    "spectacle_id" uuid,
    CONSTRAINT "image_spectacle_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "lieu";
CREATE TABLE "public"."lieu" (
    "id" uuid NOT NULL,
    "nom" character varying(255),
    "adresse" text,
    "nb_places_assises" integer,
    "nb_places_debout" integer,
    CONSTRAINT "lieu_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "lieu" ("id", "nom", "adresse", "nb_places_assises", "nb_places_debout") VALUES
('fb17d7bf-2091-4dec-bd64-cf5dc5266acd',	'Théâtre des Arts',	'123 Rue de l Art, Paris',	300,	500),
('18ef7c86-dc18-4561-b355-2c7619973ad1',	'Palais des Congrès',	'45 Avenue de la Liberté, Lyon ',	1000,	2000),
('5277fb17-318b-4a72-b2c7-0bbff48f0aee',	'Salle des Fêtes',	'Place du Marché, Bordeaux ',	200,	300);

DROP TABLE IF EXISTS "soiree";
CREATE TABLE "public"."soiree" (
    "id" uuid NOT NULL,
    "nom" character varying(100),
    "thematique" character varying(100),
    "date_heure" timestamp,
    "lieu_id" uuid,
    "tarif_normal" numeric(10,2),
    "tarif_reduit" numeric(10,2),
    CONSTRAINT "soiree_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "soiree" ("id", "nom", "thematique", "date_heure", "lieu_id", "tarif_normal", "tarif_reduit") VALUES
('dc4722c7-7fb8-4a21-8b6d-0a567997d874',	'Soiree Rock',	'Rock',	'2024-10-28 20:00:00',	'5277fb17-318b-4a72-b2c7-0bbff48f0aee',	20.00,	12.00),
('ee766414-2945-4c8b-9812-c232e14888c7',	'Soiree Sympa',	'Jazz/Classique',	'2024-11-15 18:30:00',	'fb17d7bf-2091-4dec-bd64-cf5dc5266acd',	30.00,	23.00);

DROP TABLE IF EXISTS "spectacle";
CREATE TABLE "public"."spectacle" (
    "id" uuid NOT NULL,
    "titre" character varying(100),
    "description" text,
    "url_video" character varying(255),
    "horaire_previsionnel" timestamp,
    "soiree_id" uuid,
    "style" character varying(255),
    CONSTRAINT "spectacle_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "spectacle" ("id", "titre", "description", "url_video", "horaire_previsionnel", "soiree_id", "style") VALUES
('44533365-fbba-4dd3-865b-1f8af96b3e57',	'Jazz Band Live',	'Un concert jazz avec les meilleurs musiciens de la ville.',	'https://example.com/jazzband',	'2024-11-15 21:00:00',	'ee766414-2945-4c8b-9812-c232e14888c7',	'Jazz'),
('acc717f5-ced0-4896-89a7-5cd5bca8d669',	'Rock en scène',	'Un groupe de rock pour une soirée mémorable.',	'https://example.com/rockband',	'2024-10-28 20:00:00',	'dc4722c7-7fb8-4a21-8b6d-0a567997d874',	'Rock'),
('d8804296-3d11-43c5-92eb-02a087cfb10f',	'Orchestre Symphonique',	'Gala de musique classique avec un orchestre complet.',	'https://example.com/classique',	'2024-11-15 19:30:00',	'ee766414-2945-4c8b-9812-c232e14888c7',	'Classique');

DROP TABLE IF EXISTS "users";
CREATE TABLE "public"."users" (
    "id" uuid NOT NULL,
    "nom" character varying(500),
    "prenom" character varying(50),
    "email" character varying(255),
    "mot_de_passe" character varying(255),
    "role" CHARACTER INTEGER(2),
    "date_enregistrement" timestamp,
    CONSTRAINT "users_email_key" UNIQUE ("email"),
    CONSTRAINT "users_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "users" ("id", "nom", "prenom", "email", "mot_de_passe", "date_enregistrement") VALUES
('f7c1eba2-7a35-4ca6-9d8b-eaa9636f4070',	'Dupont',	'Jean',	'jean.dupont@example.com',	'password123',	'2024-10-22 09:36:27.221967'),
('a3cd8e39-9dec-4376-a9c8-53356985ba31',	'Martin',	'Marie',	'marie.martin@example.com',	'securepass',	'2024-10-22 09:36:27.221967'),
('1d74c1bf-453c-4417-be0a-5095734e886f',	'Lefevre',	'Luc',	'luc.lefevre@example.com',	'hashme',	'2024-10-22 09:36:27.221967');

ALTER TABLE ONLY "public"."artiste_spectacle" ADD CONSTRAINT "artiste_spectacle_id_artiste_fkey" FOREIGN KEY (id_artiste) REFERENCES artiste(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."artiste_spectacle" ADD CONSTRAINT "artiste_spectacle_id_spectacle_fkey" FOREIGN KEY (id_spectacle) REFERENCES spectacle(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."billet" ADD CONSTRAINT "billet_soiree_id_fkey" FOREIGN KEY (soiree_id) REFERENCES soiree(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."billet" ADD CONSTRAINT "billet_utilisateur_id_fkey" FOREIGN KEY (utilisateur_id) REFERENCES users(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."image_lieu" ADD CONSTRAINT "image_lieu_lieu_id_fkey" FOREIGN KEY (lieu_id) REFERENCES lieu(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."image_spectacle" ADD CONSTRAINT "image_spectacle_spectacle_id_fkey" FOREIGN KEY (spectacle_id) REFERENCES spectacle(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."soiree" ADD CONSTRAINT "soiree_lieu_id_fkey" FOREIGN KEY (lieu_id) REFERENCES lieu(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."spectacle" ADD CONSTRAINT "spectacle_soiree_id_fkey" FOREIGN KEY (soiree_id) REFERENCES soiree(id) NOT DEFERRABLE;

-- 2024-10-22 11:07:44.395733+00