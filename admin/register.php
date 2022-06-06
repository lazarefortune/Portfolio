<?php
require '../vendor/autoload.php';
use App\Models\Database;

session_start();
$errors = array();
$formRow = array();

// login
if ( isset( $_POST['btnRegister'] ) ){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    $formRow['name'] = $name;
    $formRow['email'] = $email;

    // Check if username or password is empty
    if ( empty( $password ) || empty( $email ) || empty( $name ) ) {
        // Detect the empty fields
        if ( empty( $password ) ) {
            $errors[] = "Password is required";
        }
        if ( empty( $passwordConfirm ) ) {
            $errors[] = "Password confirmation is required";
        }
        if ( empty( $email ) ) {
            $errors[] = "Email is required";
        }
        if ( empty( $name ) ) {
            $errors[] = "Name is required";
        }
    }else{
        // register user and check if not exist in database
        $db = new Database();
        $dbHandle = $db->getDbHandle();
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($dbHandle, $sql);
        $user = mysqli_fetch_assoc($result);
        if ( $user ) {
            if ( $user['email'] === $email ) {
                $errors[] = "Email already exists";
            }
        }
        // Check if password and password confirmation are the same
        if ( $password !== $passwordConfirm ) {
            $errors[] = "Password and password confirmation are not the same";
        }
        // Check if password is at least 6 characters
        if ( strlen( $password ) < 6 ) {
            $errors[] = "Password must be at least 6 characters";
        }
        // Check if email is valid
        if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            $errors[] = "Email is not valid";
        }
        // Check if name is valid
        if ( !preg_match( "/^[a-zA-Z ]*$/", $name ) ) {
            $errors[] = "Name is not valid";
        }
        // Register user if no error
        if ( count( $errors ) == 0 ) {
            $password = md5( $password );
            $createdAt = date( 'Y-m-d H:i:s' );
            $sql = "INSERT INTO users (name, password, email, createdAt) VALUES ('$name', '$password', '$email', '$createdAt')";
            $result = mysqli_query($dbHandle, $sql);
            if ( $result ) {
                //$_SESSION['username'] = $username;
                $_SESSION['messages'] = "Votre compte a bien été créé";
                header( 'location: login.php' );
            } else {
                $errors[] = "Something went wrong";
            }
        }
    }
}




?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="../assets/images/favicons/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="../assets/images/favicons/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="../assets/images/favicons/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="../assets/images/favicons/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/images/favicons/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="../assets/images/favicons/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="../assets/images/favicons/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="../assets/images/favicons/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="../assets/images/favicons/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicons/apple-touch-icon-180x180.png" />
    <title>Lazare Fortune</title>
    <!--
Reflux Template
https://templatemo.com/tm-531-reflux
-->
    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../assets/css/fontawesome.css" />
    <link rel="stylesheet" href="../assets/css/templatemo-style.css" />
    <link rel="stylesheet" href="../assets/css/owl.css" />
    <link rel="stylesheet" href="../assets/css/lightbox.css" />

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.11.0/devicon.min.css">
</head>

<body>
<!-- connexion form -->
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto mt-5">
            <!-- form card login -->
            <div class="card rounded-0">
                <div class="card-header">
                    <h3 class="mb-0">Inscription</h3>
                </div>
                <div class="card-body">
                    <!-- show errors -->
                    <?php
                    if ( count( $errors ) > 0 ) {
                        echo '<div class="alert alert-danger">';
                        foreach ( $errors as $error ) {
                            echo $error . '<br />';
                        }
                        echo '</div>';
                    }
                    ?>
                    <!-- check if session messages exist -->
                    <?php if ( isset( $_SESSION['messages'] ) ) { ?>
                        <div class="alert alert-success">
                            <?php
                            echo $_SESSION['messages'];
                            unset( $_SESSION['messages'] );
                            ?>
                        </div>
                    <?php } ?>
                    <form class="form" role="form" autocomplete="off" id="formLogin" method="POST" action="register.php">
                        <!-- name -->
                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input type="text" class="form-control form-control-lg rounded-0" name="name" id="name" required="" value="<?php if ( !empty( $formRow['name'] ) ) { echo $formRow['name']; } ?>">
                            <div class="invalid-feedback">Votre nom est obligatoire</div>
                        </div>
                        <!-- email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-lg rounded-0" name="email" id="email" required="" value="<?php if ( !empty( $formRow['email'] ) ) { echo $formRow['email']; } ?>">
                            <div class="invalid-feedback">Votre email est obligatoire</div>
                        </div>
                        <div class="form-group">
                            <label for="pwd1">Mot de passe</label>
                            <input type="password" class="form-control form-control-lg rounded-0" name="password" id="pwd1" required="" autocomplete="new-password">
                            <div class="invalid-feedback">Obligatoire</div>
                        </div>
                        <div class="form-group">
                            <label for="pwd2">Confirmer le mot de passe</label>
                            <input type="password" class="form-control form-control-lg rounded-0" name="passwordConfirm" id="pwd2" required="" autocomplete="new-password">
                            <div class="invalid-feedback">Obligatoire</div>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg float-right" id="btnRegister" name="btnRegister">S'inscrire</button>
                        <!-- forgot password -->
                        <div class="mt-4">
                            <a href="login.php">Se connecter</a>
                        </div>
                        <!--
                        <div>
                            <button type="submit" class="btn btn-success btn-lg float-right" id="btnLogin" name="btnLogin">Connexion</button>
                        </div>
                        -->
                    </form>
                </div>
                <!--/card-block-->
            </div>
        </div>
    </div>
</div>

</body>

</html>
</body>

</html>