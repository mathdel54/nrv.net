-- Insérer des spectacles
INSERT INTO "spectacle" ("id", "titre", "description", "url_video", "horaire_previsionnel", "soiree_id", "style")
VALUES (gen_random_uuid(), 'Jazz Band Live', 'Un concert jazz avec les meilleurs musiciens de la ville.',
        'https://example.com/jazzband', '20:30', 'aaaa1111-aaaa-1111-aaaa-111111111111', 'Jazz'),
       (gen_random_uuid(), 'Rock en scène', 'Un groupe de rock pour une soirée mémorable.',
        'https://example.com/rockband', '19:45', 'bbbb2222-bbbb-2222-bbbb-222222222222', 'Rock'),
       (gen_random_uuid(), 'Orchestre Symphonique', 'Gala de musique classique avec un orchestre complet.',
        'https://example.com/classique', '21:30', 'cccc3333-cccc-3333-cccc-333333333333', 'Classique');
