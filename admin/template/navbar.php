<!-- navbar.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">
        <span class="navbar-brand mb-0 h1">
            <?php
            if ( $loggedIn ) {
                echo "Bonjour $username";
            } else {
                echo "Bienvenue";
            }
            ?>
        </span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Accueil</a>
            </li>
            <?php
            if ( $loggedIn ) {
                echo '<li class="nav-item">
                        <a class="nav-link" href="../logout.php">Déconnexion</a>
                    </li>';
            } else {
                echo '<li class="nav-item">
                        <a class="nav-link" href="login.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Inscription</a>
                    </li>';
            }
            ?>
        </ul>
    </div>
</nav>