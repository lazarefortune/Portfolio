<?php
require '../vendor/autoload.php';
use App\Models\Database;

session_start();
$errors = array();
$formRow = array();


$db = new Database();
$dbHandle = $db->getDbHandle();

// forgot password form
if ( isset( $_POST['forgot'] ) ) {
    $email = $_POST['email'];
    $formRow['email'] = $email;

    // Check if email is empty
    if ( empty( $email ) ) {
        $errors[] = "Email is required";
    }
    // Check if email is valid
    if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
        $errors[] = "Email is not valid";
    }
    // Check if email exist in database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($dbHandle, $sql);
    $user = mysqli_fetch_assoc($result);
    if ( !$user ) {
        $errors[] = "Email does not exist";
    }
    // Send email if no error
    if ( count( $errors ) == 0 ) {
        // Generate token
        $token = bin2hex( openssl_random_pseudo_bytes(16) );
        // Send mail
        $to = $email;
        $subject = "Password Reset";
        $message = "
        <html>
        <head>
        <title>Password Reset</title>
        </head>
        <body>
        <p>Hi,</p>
        <p>You have requested a password reset. Please click the link below to reset your password.</p>
        <p><a href=". $_SERVER["HTTP_HOST"] . "/admin/reset.php?token=" .$token.">Reset Password</a></p>
        <p>If you did not request a password reset, please ignore this email.</p>
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // More headers
        $headers .= 'From: Service Lazare Fortune <service@lazarefortune.com>' . "\r\n";
        mail( $to, $subject, $message, $headers );



        // Save in reset table
        $sql = "INSERT INTO reset (userId, token, createdAt, expireAt) VALUES ('$user[id]', '$token', NOW(), DATE_ADD(NOW(), INTERVAL 1 HOUR))";
        mysqli_query($dbHandle, $sql);

        // Success message
        echo "<script>alert('Please check your email to reset your password.');</script>";
        //header( "Location: login.php" );
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
<!-- forgot password form -->
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto mt-5">
            <!-- form card login -->
            <div class="card rounded-0">
                <div class="card-header">
                    <h3 class="mb-0">Mot de passe oublié ? 🥵</h3>
                    <p class="text-dark">Pas de panique! Nous allons régler ça 😉</p>
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
                    <!-- forgot password form -->
                    <form action="forgot.php" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg rounded-0" id="email" required value="<?php if ( !empty( $formRow['email'] ) ) { echo $formRow['email']; } ?>">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="forgot" class="btn btn-primary btn-block">Réinitialiser</button>
                        </div>
                        <div class="text-center">
                            <a class="small" href="login.php">Vous avez déjà un compte ? Connectez-vous</a>
                        </div>
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