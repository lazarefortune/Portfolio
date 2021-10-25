<?php
session_start(); 

function reArrayFiles(&$file_post) {

  $file_ary = array();
  $file_count = count($file_post['name']);
  $file_keys = array_keys($file_post);

  for ($i=0; $i<$file_count; $i++) {
      foreach ($file_keys as $key) {
          $file_ary[$i][$key] = $file_post[$key][$i];
      }
  }

  return $file_ary;
}


$messages = []; 
if (isset($_POST['uploadBtn']))
{
    if (isset($_FILES['uploadedFile']))
    {
      $files =  reArrayFiles($_FILES['uploadedFile']) ;
      foreach ( $files as $file) {

        // get details of the uploaded file
        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
     
        // sanitize file-name
        // $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
          $newFileName = $fileName ;
        // check if file has one of the following extensions
        $allowedfileExtensions = array( 'pdf', 'jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc' );
     
        // if (in_array($fileExtension, $allowedfileExtensions))
        // {
          // directory in which the uploaded file will be moved
          $uploadFileDir = './uploads/';
          $dest_path = $uploadFileDir . $newFileName;
          if (file_exists( $dest_path )) {
            $messages[] = [
              'class' => 'danger',
              'contenu' => 'Le fichier '.$file['name'].' existe déjà. Veuillez renommer votre fichier'
            ];
          } else {
            if(move_uploaded_file($fileTmpPath, $dest_path)) 
            {
              $messages[] = [
                'class' => 'success',
                'contenu' => 'File '. $file['name'] .' is successfully uploaded.',
              ];
            }
            else
            {
              $messages[] = [
                'class' => 'warning',
                'contenu' => 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.'
              ];
              
            }
          }
      }

    // }
    // else
    // {
    //   $error = 'danger';
    //   $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    // }
  }
  else
  {
    // $message[] = 'There is some error in the file upload. Please check the following error.<br>';
    $messages[] = [
      'class' => 'danger',
      'contenu' => 'Error sur le fichier '. $file["name"] . ' : ' . $file['error']
    ];
  }
}

$_SESSION['messages'] = $messages;
header("Location: index.php");
?>