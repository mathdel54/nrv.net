-- Insérer des billets
INSERT INTO "billet" ("id", "utilisateur_id", "tarif", "date_achat", "soiree_id")
VALUES
    (gen_random_uuid(), '11111111-2222-3333-4444-555555555555', 'normal', NOW(), 'aaaa1111-aaaa-1111-aaaa-111111111111'),
    (gen_random_uuid(), '22222222-3333-4444-5555-666666666666', 'reduit', NOW(), 'bbbb2222-bbbb-2222-bbbb-222222222222'),
    (gen_random_uuid(), '33333333-4444-5555-6666-777777777777', 'normal', NOW(), 'cccc3333-cccc-3333-cccc-333333333333');