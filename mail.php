<?php
include_once 'Database.php';

if( isset( $_POST['sendMail'] ) ){
    // Get data from form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $createdAt = (new DateTime())->format('Y-m-d H:i:s');
    $headers = 'From: '.$email."\r\n".
        'Reply-To: '.$email."\r\n" .
        'X-Mailer: PHP/' . phpversion();
    // Connexion to database
    //var_dump($name, $email, $subject, $message, $createdAt);
    $db = new Database();
    $dbHandle = $db->getDbHandle();
    $dbFound = $db->getDbFound();

    // Insert data in database
    $sql = "INSERT INTO `mails` (`name`, `email`, `subject`, `message`, `createdAt`) VALUES ('$name', '$email', '$subject', '$message', '$createdAt')";
    $result = mysqli_query($dbHandle, $sql);

    // Send mail

    // Message format
    $message = "
    <html>
        <head>
            <title>$subject</title>
        </head>
        <body>
            <p> Bonjour, vous avez recu un message de $name, 
                possédant l'email suivant : $email.
                Le contenu du message est le suivant :
            </p>
            <p>$message</p>
        </body>
    </html>
    ";

    // Send mail
    $result = mail( 'lazarefortune@gmail.com',
                    $subject,
                    $message,
                    $headers
    );

    if( $result ){
        echo '<p>Votre message a bien été envoyé.</p>';
    }
    else{
        echo '<p>Une erreur est survenue.</p>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="assets/images/favicons/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="assets/images/favicons/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="assets/images/favicons/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="assets/images/favicons/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/favicons/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="assets/images/favicons/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="assets/images/favicons/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="assets/images/favicons/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="assets/images/favicons/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/apple-touch-icon-180x180.png" />
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 bg-white p-3 border rounded mt-5">
                <h1 class="text-center">Formulaire de contact</h1>
                <!-- Show email send message and error else -->
                <?php if( isset( $_POST['sendMail'] ) ){ ?>
                    <div class="alert alert-success" role="alert">
                        Votre message a bien été envoyé.
                    </div>
                <?php } else if( isset( $_POST['sendMail'] ) && !$result ){ ?>
                    <div class="alert alert-danger" role="alert">
                        Une erreur est survenue.
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info" role="alert">
                        Veuillez remplir le formulaire ci-dessous.
                    </div>
                <?php } ?>
                <!-- End of email send message -->
                <form action="mail.php" method="post">
                    <div class="form-group my-2">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Votre nom" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Votre email" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="subject">Sujet</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Votre sujet" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2" name="sendMail">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


