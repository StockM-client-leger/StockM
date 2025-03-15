<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STOCK M</title>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../script/script.js" defer></script>
</head>

<body>

    <div id="mouse-light"></div>

  <div aria-disabled id="hidden-text">
    <h1>StockM Sneakers</h1>
    <h1>Sneakers StockM</h1>
    <h1>Air Jordan 4 Dunk Low</h1>
    <h1>Dunk Low Air Jordan 4</h1>
    <h1>Air Max Plus Dunk Low</h1>
    <h1>NB 1906R Air Max Plus</h1>
    <h1>Air Force One NB 1906R</h1>
  </div>


  <header>
        
    <nav>
        <div class="logo-container">
            <a href="../index.php"><img src="../image/stockm.jpg.webp" alt="logo STOCKM" id="logo"/></a>
        </div>

        <ul>
            <li><a href="homme.php">Homme</a></li>
            <li><a href="femme.php">Femme</a></li>
            <li><a href="enfant.php">Enfant</a></li>
        </ul>

        <ul>
            <li><a href="panier.php">Panier</a></li>
            <li><a href="connexion2.php">Connexion</a></li>
        </ul>
    </nav>
</header>


<main class="container">
    <section id="inscription-form">
        <h2>Inscription à StockM</h2>
        <form action="../php/inscription.php" method="post">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Entrez votre Nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Entrez votre Prénom" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Entrez votre mot de passe" required>
            </div>
            <button type="submit" class="btn">S'inscrire</button>
            <a href="connexion2.php" style="margin-top: 10px; display: block; color: #ecd90c !important;">Déjà inscrit ? Se connecter</a>
            
        </form>
    </section>
</main>

<footer class="footer">
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> STOCK M - Tous droits réservés</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = {
        nom: document.getElementById('nom'),
        prenom: document.getElementById('prenom'),
        email: document.getElementById('email'),
        password: document.getElementById('mot_de_passe')
    };

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validation nom et prénom
        if (inputs.nom.value.length < 2) {
            alert('Le nom doit contenir au moins 2 caractères');
            return;
        }

        if (inputs.prenom.value.length < 2) {
            alert('Le prénom doit contenir au moins 2 caractères');
            return;
        }

        // Validation email
        if (!isValidEmail(inputs.email.value)) {
            alert('Veuillez entrer une adresse email valide');
            return;
        }

        // Validation mot de passe
        const password = inputs.password.value;
        const hasMinLength = password.length >= 8;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        const hasNumber = /[0-9]/.test(password);

        let passwordErrors = [];
        
        if (!hasMinLength) passwordErrors.push("au moins 8 caractères");
        if (!hasUpperCase) passwordErrors.push("une majuscule");
        if (!hasSpecialChar) passwordErrors.push("un caractère spécial");
        if (!hasNumber) passwordErrors.push("un chiffre");

        if (passwordErrors.length > 0) {
            alert(`Le mot de passe doit contenir :\n- ${passwordErrors.join("\n- ")}`);
            return;
        }

        // Si tout est valide, soumettre le formulaire
        this.submit();
    });

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});
</script>

</body>
</html>