<?php
session_start();
require '../vendor/autoload.php';
use App\Models\Database;

session_start();
$errors = array();
$formRow = array();

$db = new Database();
// login
if ( isset( $_POST['btnLogin'] ) ){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['rememberMe']) && $_POST['rememberMe'];

    $formRow['email'] = $email;
    $formRow['rememberMe'] = $rememberMe;

    // Check if email or password is empty
    if ( empty( $email ) || empty( $password ) ) {
        $errors[] = "Email or password is empty";
    }else{
        // Check if email format is valid
        if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            $errors[] = "Email is not valid";
        }

        // Check if username exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query( $db->getDbHandle(), $sql );
        $user = mysqli_fetch_assoc( $result );
        if ( $user ) {
            // Check if password is correct with md5 encryption
            if ( md5($password) == $user['password'] ) {
                $_SESSION['email'] = $user['email'];
                $_SESSION['success'] = "You are now logged in";

                // Check if remember me is checked
                if ( $rememberMe ) {
                    // Set cookie for 1 week
                    setcookie( "email", $user['email'], time() + 60 * 60 * 24 * 7 );
                }

                header( "location: index.php" );
            } else {
                $errors[] = "Wrong email or password";
            }
        }else{
            $errors[] = "Wrong email or password";
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
                        <h3 class="mb-0">Rejoindre la Team 😎 </h3>
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
                        <form class="form" role="form" autocomplete="off" id="formLogin" novalidate="" method="POST" action="login.php">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control form-control-lg rounded-0" name="email" id="email" required="" value="<?php if ( !empty( $formRow['email'] ) ) { echo $formRow['email']; } ?>">
                                <div class="invalid-feedback">Obligatoire</div>
                            </div>
                            <div class="form-group">
                                <label for="pwd1">Mot de passe</label>
                                <input type="password" class="form-control form-control-lg rounded-0" name="password" id="pwd1" required="" autocomplete="new-password">
                                <div class="invalid-feedback">Obligatoire</div>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customControlInline" name="rememberMe" <?php if ( $formRow["rememberMe"] ) { echo 'checked'; } ?>>
                                <label class="custom-control-label" for="customControlInline">Se souvenir de moi</label>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg float-right" id="btnLogin" name="btnLogin">Connexion</button>
                            <!-- forgot password -->
                            <div class="mt-4">
                                <a href="forgot.php">Mot de passe oublié ?</a>
                            </div>
                            <div class="mt-4">
                                <a href="register.php">Créer un compte</a>
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