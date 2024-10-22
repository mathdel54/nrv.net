-- Insérer des artistes
INSERT INTO "artiste" ("id", "nom", "spectacle_id")
VALUES (gen_random_uuid(), 'John Doe Quartet', 'aaaa1111-aaaa-1111-aaaa-111111111111'),
       (gen_random_uuid(), 'The Rockers', 'bbbb2222-bbbb-2222-bbbb-222222222222'),
       (gen_random_uuid(), 'Orchestre National', 'cccc3333-cccc-3333-cccc-333333333333');
