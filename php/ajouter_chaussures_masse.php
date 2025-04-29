<?php
require_once 'db.php';

// Tableau des chaussures à ajouter
$chaussures = [
    [
        'nom' => 'Nike Air Max Dn',
        'description' => 'Découvre la technologie Air nouvelle génération. La Air Max Dn intègre l’unité Dynamic Air (composée de quatre cylindres) qui te propulse à chaque pas, pour une sensation de fluidité incroyable. Résultat ? Un look futuriste hyper confortable, à porter de jour comme de nuit. Et des sensations irréelles.',
        'prix' => 169.99,
        'prix_promo' => 149.99,
        'genre' => 'Homme',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/df1534a7-d188-45d1-91d5-8fb38963cafb/AIR+MAX+DN.png',
        'tailles' => [40, 41, 42, 43, 44, 45, 46]
    ],
    [
        'nom' => 'Nike Air Max Plus III',
        'description' => 'La Nike Air Max Plus III associe la technologie Tuned Air ultra-confortable à une silhouette énergique rendue célèbre par ses prédécesseurs. La III revisite le look avec des détails en TPU fusionnés sur l’empeigne, tout en rendant hommage à l’emblématique dégradé de couleurs.',
        'prix' => 189.99,
        'prix_promo' => 0,
        'genre' => 'Homme',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/aqcdmfttkq4cuvv9nuwx/AIR+MAX+PLUS+III.png',
        'tailles' => [40, 41, 42, 43,45,45.5,46]
    ],
    [
        'nom' => 'Nike Air Force 1 Flyknit 2.0',
        'description' => 'Inspirée par la chaussure qui règne sur les terrains depuis 1982, la Nike Air Force 1 Flyknit 2.0 fait revivre la AF1 dans un modèle encore plus léger que jamais. Arborant la conception Flyknit avec les lignes AF1 classiques, elle rappelle le style basketball old school dans une version offrant davantage de légèreté.',
        'prix' => 119.99,
        'prix_promo' => 99.99,
        'genre' => 'Homme',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/n8n760mung63zqbiuatq/AIR+FORCE+1+FLYKNIT+2.0.png',
        'tailles' => [38.5, 39, 40, 40.5, 41, 42, 42.5, 43, 44]
    ],

    [
        'nom' => 'Nike Dunk Low Retro',
        'description' => 'Créée pour les parquets mais revisitée pour le quotidien, la Nike Dunk Low Retro est de retour avec des renforts épurés et ses couleurs d origine évoquant les équipes universitaires. Cette chaussure de basketball emblématique évoque les années 80 avec son empeigne en cuir premium stylée et incroyablement souple. Grâce à la technologie des chaussures modernes, le 21e siècle fait la part belle au confort.',
        'prix' => 119.99,
        'prix_promo' => 0,
        'genre' => 'Homme',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/b1bcbca4-e853-4df7-b329-5be3c61ee057/NIKE+DUNK+LOW+RETRO.png',
        'tailles' => [39, 40, 40.5, 41, 42, 42.5, 43, 44, 44.5]
    ],

    [
        'nom' => 'Nike Air Pegasus Wave',
        'description' => 'Voici la Pegasus Wave : une Air Pegasus au look edgy. Silhouette de chaussure de running culte. Design profond et structuré. Mélange de matières. Cette édition s inspire du début des années 2000. La semelle intermédiaire intègre un amorti Nike Air sur toute la longueur pour plus de confort. Dis bonjour à ta nouvelle paire préférée : tu ne pourras plus t en passer.',
        'prix' => 149.99,
        'prix_promo' => 0,
        'genre' => 'Homme',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/9798729c-7ad1-4386-aeb3-8f14f9f9eb81/NIKE+AIR+PEGASUS+WAVE.png',
        'tailles' => [39, 40, 40.5, 41, 42, 42.5, 43, 44, 44.5]
    ],




    [
        'nom' => 'Nike Shox TL',
        'description' => 'La Nike Shox TL repousse les limites de l amorti mécanique. Cette version revisitée du modèle iconique de 2003 intègre du mesh respirant sur l empeigne et la technologie Nike Shox sur toute la longueur. Résultat : une absorption optimale des chocs et un look sublimé.',
        'prix' => 169.99,
        'prix_promo' => 129.99,
        'genre' => 'Femme',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/wj5ju8ralfciojw5agrv/W+NIKE+SHOX+TL.png',
        'tailles' => [35, 36, 36.5, 37, 38, 38.5, 39, 40, 40.5]
    ],

    [
        'nom' => 'Nike Air Force 1 07 LX',
        'description' => 'Le charme continue d opérer avec la Nike Air Force 1 07 LX. Cette silhouette classique du basketball revisite ses éléments les plus célèbres : les renforts cousus, les détails audacieux et juste ce qu il faut d éclat pour vous faire briller.La chaîne dorée amovible avec pendentifs vous permet de personnaliser votre look avec style.',
        'prix' => 129.99,
        'prix_promo' => 0,
        'genre' => 'Femme',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/d8825c05-16f8-4d94-a2fc-3b61b8d4aa6d/WMNS+AIR+FORCE+1+%2707+LX.png',
        'tailles' => [35, 36, 36.5, 37, 38, 38.5, 39, 40, 40.5]
    ],

    [
        'nom' => 'Air Max TL 2.5 Metallic Silver',
        'description' => 'La Air Max TL 2.5 fait revivre un grand classique des années 90 avec les célèbres lignes ondulées des premiers modèles Air Max. Tissus respirants. Cuir synthétique lisse. Détails ultra-brillants. Cette version épurée intègre sous le pied un amorti Max Air pour plus de rebond à chaque pas. Le coloris argent métallisé donne l impression que la chaussure a été plongée dans un bain de chrome et sort tout droit de l espace. Remonte le temps et entre dans le futur.',
        'prix' => 179.99,
        'prix_promo' => 159.99,
        'genre' => 'Femme',
        'lien' => 'https://static.nike.com/a/images/w_1280,q_auto,f_auto/19a8e755-f29b-4c3d-8a6c-ebb875ea37b3/date-de-sortie-de-la-air-max-tl%C2%A02-5-%C2%AB%C2%A0metallic-silver%C2%A0%C2%BB-hm8818-001.jpg',
        'tailles' => [35, 36, 36.5, 37, 38, 38.5, 39, 40, 40.5]
    ],

    [
        'nom' => 'Nike Air Max Plus',
        'description' => 'Portez la Nike Air Max Plus au quotidien et profitez de l expérience Tuned Air, qui offre une stabilité optimale et un amorti exceptionnel. Elle rend hommage au style subversif de la silhouette OG en s appropriant ses couleurs dégradées et ses rayons ondulés en TPU.',
        'prix' => 189.99,
        'prix_promo' => 0,
        'genre' => 'Femme',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/i1-c17624b6-0617-4217-93e1-0524c6f9d4f1/WMNS+NIKE+AIR+MAX+PLUS.png',
        'tailles' => [35, 36, 36.5, 37, 38, 38.5, 39, 40, 40.5]
    ],

    [
        'nom' => 'Air Jordan 4 Aluminum',
        'description' => 'Nouveau look tout en élégance pour cette AJ4 phare de 1989 : cuir blanc premium, éléments moulés gris et fleurs amovibles en chenille.',
        'prix' => 209.99,
        'prix_promo' => 0,
        'genre' => 'Femme',
        'lien' => 'https://static.nike.com/a/images/w_1280,q_auto,f_auto/b1818011-c410-4ae3-9045-5a71085e1506/date-de-sortie-de-la-air-jordan%C2%A04-%C2%AB%C2%A0aluminum%C2%A0%C2%BB-pour-femme-hv0823-100.jpg',
        'tailles' => [35, 36, 36.5, 37, 38, 38.5, 39, 40, 40.5]
    ],




    [
        'nom' => 'Nike P-6000',
        'description' => 'Inspirée des sneakers Pegasus rétro, la Nike P-6000 fait entrer le style running du début des années 2000 dans la modernité. Née pour être performante, cette chaussure assure une foulée amortie et dynamique. Les lignes sportives et les tissus respirants garantissent un mélange parfait entre style attrayant et confort en toute légèreté.',
        'prix' => 84.99,
        'prix_promo' => 0,
        'genre' => 'Enfant',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/520ca952-1d18-4648-9190-1812c5ef4a4f/NIKE+P-6000+%28GS%29.png',
        'tailles' => [28, 29, 30, 31.5, 32, 33, 33.5, 34, 35, 37, 38.5]
    ],

    [
        'nom' => 'Nike Air Max Plus',
        'description' => 'Ces sneakers confortables te donneront un aperçu de la légendaire technologie Tuned Air. Cage culte en forme de flamme. Queue de baleine près de la voûte plantaire. Cette Air Max Plus affiche un style haut en couleur qui ne passera pas inaperçu quand tu joueras.',
        'prix' => 139.99,
        'prix_promo' => 115.99,
        'genre' => 'Enfant',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/6672f6e4-b93e-469f-84f8-eff1d34f34f9/NIKE+AIR+MAX+PLUS+GS.png',
        'tailles' => [28, 29, 30, 31.5, 32, 33, 33.5, 34, 35, 37, 38.5]
    ],

    [
        'nom' => 'Nike Dunk Low',
        'description' => 'Conçue pour le basket mais adoptée par les fans de skate, la Nike Dunk Low a contribué à définir la culture sneakers. Maintenant, cette icône du milieu des années 80 est parfaite pour compléter ta garde-robe. Avec son rembourrage à la cheville et son adhérence en caoutchouc résistant, c est une valeur sûre, pour apprendre à faire du skate ou pour aller à l école.',
        'prix' => 94.99,
        'prix_promo' => 66.49,
        'genre' => 'Enfant',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/f2a9595e-d7b2-4b43-a146-f4b8a9d0bc70/NIKE+DUNK+LOW+%28GS%29.png',
        'tailles' => [28, 29, 30, 31.5, 32, 33, 33.5, 34, 35, 37, 38.5]
    ],

    [
        'nom' => 'Nike Air Max Dn',
        'description' => 'Découvre la technologie Air nouvelle génération. La Air Max Dn intègre l unité Dynamic Air (composée de quatre cylindres) qui te propulse à chaque pas, pour une sensation de fluidité incroyable. Résultat ? Un look futuriste hyper confortable, à porter de jour comme de nuit. Et des sensations irréelles.',
        'prix' => 134.99,
        'prix_promo' => 94.49,
        'genre' => 'Enfant',
        'lien' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/73ca1a1f-313a-4655-ab00-11d6055c267f/AIR+MAX+DN+%28PS%29.png',
        'tailles' => [28, 29, 30, 31.5, 32, 33, 33.5, 34, 35, 37, 38.5]
    ],
    // Ajoutez d'autres chaussures ici...
];

try {
    $pdo->beginTransaction();

    foreach ($chaussures as $chaussure) {
        // Vérifier si le modèle existe déjà
        $stmt = $pdo->prepare("SELECT id_modele FROM modele WHERE nom = :nom");
        $stmt->execute(['nom' => $chaussure['nom']]);
        $existing_model = $stmt->fetch();

        if (!$existing_model) {
            // Insertion du modèle seulement s'il n'existe pas
            $sql = "INSERT INTO modele (nom, description, prix, prix_promo, genre, lien, meilleur_vente) 
                    VALUES (:nom, :description, :prix, :prix_promo, :genre, :lien, 0)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'nom' => $chaussure['nom'],
                'description' => $chaussure['description'],
                'prix' => $chaussure['prix'],
                'prix_promo' => $chaussure['prix_promo'],
                'genre' => $chaussure['genre'],
                'lien' => $chaussure['lien']
            ]);

            $id_modele = $pdo->lastInsertId();

            // Insertion des tailles pour le nouveau modèle
            foreach ($chaussure['tailles'] as $taille) {
                // Vérifier si la combinaison modèle-taille existe déjà
                $stmt = $pdo->prepare("SELECT 1 FROM produit WHERE id_modele = :id_modele AND id_taille = :id_taille");
                $stmt->execute([
                    'id_modele' => $id_modele,
                    'id_taille' => $taille
                ]);
                
                if (!$stmt->fetch()) {
                    $sql = "INSERT INTO produit (id_modele, id_taille) VALUES (:id_modele, :id_taille)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        'id_modele' => $id_modele,
                        'id_taille' => $taille
                    ]);
                }
            }
            echo "Ajout du modèle : " . $chaussure['nom'] . "<br>";
        } else {
            echo "Le modèle " . $chaussure['nom'] . " existe déjà<br>";
        }
    }

    $pdo->commit();
    echo "<br>Opération terminée avec succès !";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erreur lors de l'ajout des chaussures : " . $e->getMessage();
}
?>