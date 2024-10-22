-- Insérer des utilisateurs
INSERT INTO "Utilisateur" ("id", "nom", "prenom", "email", "mot_de_passe", "date_enregistrement")
VALUES (gen_random_uuid(), 'Dupont', 'Jean', 'jean.dupont@example.com', 'password123', NOW()),
       (gen_random_uuid(), 'Martin', 'Marie', 'marie.martin@example.com', 'securepass', NOW()),
       (gen_random_uuid(), 'Lefevre', 'Luc', 'luc.lefevre@example.com', 'hashme', NOW());