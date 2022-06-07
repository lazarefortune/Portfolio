<?php
require '../vendor/autoload.php';
use App\Models\Database;

// reset password form
$token = $_GET['token'];
$errors = array();
$showForm = false;
// Check if token is empty
if ( empty( $token ) ) {
    $errors[] = "Token is required";
}
// Check if token exist in database
$db = new Database();
$dbHandle = $db->getDbHandle();

$sql = "SELECT * FROM reset WHERE token = '$token'";
$result = mysqli_query($dbHandle, $sql);
$user = mysqli_fetch_assoc($result);

if ( !$user ) {
    $errors[] = "Token does not exist";
}else{
    // Check if token is expired
    $expire = $user['expireAt'];
    $now = date("Y-m-d H:i:s");
    if ( $now > $expire ) {
        $errors[] = "Token is expired";
    }
}
// Check if there is no error
if ( count( $errors ) == 0 ) {
    $showForm = true;
    if ( $_POST["resetPassword"] ) {
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];
        // Check if password and password confirmation are not empty
        if ( empty( $password ) || empty( $passwordConfirm ) ) {
            $errors[] = "Password and password confirmation are required";
        }else{
            // Check if password and password confirmation are the same
            if ( $password !== $passwordConfirm ) {
                $errors[] = "Password and password confirmation are not the same";
            }
            // Check if password is at least 6 characters
            if ( strlen( $password ) < 6 ) {
                $errors[] = "Password must be at least 6 characters";
            }
        }
        // Check if there is no error
        if ( count( $errors ) == 0 ) {
            $password = md5( $password );

            $sql = "UPDATE users SET password = '$password' WHERE id = '$user[userId]'";
            mysqli_query($dbHandle, $sql);

            $sql = "DELETE FROM reset WHERE token = '$token'";
            mysqli_query($dbHandle, $sql);

            $sql = "DELETE FROM reset WHERE userId = '$user[userId]'";
            mysqli_query($dbHandle, $sql);

            header( "location: login.php" );
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
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <?php if ( !$token ) : ?>
                    <div class="alert alert-danger bg-dark mt-5">
                        <p>Votre token de réinitialisation de mot de passe est invalide ou a expiré.</p>
                    </div>
                <?php else : ?>
                    <div class="card card-body mt-5">
                        <h3 class="text-center mb-4">On récupère votre compte ?</h3>
                        <?php if ( count( $errors ) > 0 ) : ?>
                            <div class="alert alert-danger bg-dark">
                                <?php foreach ( $errors as $error ) : ?>
                                    <p><?php echo $error; ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ( $showForm ) : ?>
                            <form action="reset.php?token=<?php echo $token; ?>" method="post">
                                <div class="form-group">
                                    <label for="password">Nouveau mot de passe</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Saisir un mot de passe" />
                                </div>
                                <div class="form-group">
                                    <label for="passwordConfirm">Confirmez votre mot de passe</label>
                                    <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control" placeholder="Saisir à nouveau le mot de passe" />
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="resetPassword" class="btn btn-primary btn-block" value="Réinitialiser" />
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
