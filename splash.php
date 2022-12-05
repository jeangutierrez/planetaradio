<?

namespace Verot\Upload;

error_reporting(E_ALL);

// we first include the upload class, as we will need it here to deal with the uploaded file
include('lib/upload.php');

session_start();

if (!isset($_SESSION['admin'])) {

  header("Location: admin.php");

} else {


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv=content-type content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1" />
<head>
    <title>Configuración</title>

    <style>
        * {
          padding: 0;
          margin: 0;
        }
        p.result {
          width: 100%;
          margin: 15px 0px 25px 0px;
          padding: 15px;
          clear: right;
        }
        p.result img {
          background: #cccccc;
        }
        fieldset {
          width: 50%;
          margin: 15px auto 25px auto;
          padding: 0 15px 15px;
        }
        @media (max-width: 480px) {
          fieldset {
            width: 80%;
          }
        }
        legend {
          font-weight: bold;
        }
        fieldset p {
          font-style: italic;
          padding-top: 15px;
        }
        input[type=text] {
          width: calc(100% - 17px);
          padding: 8px;
        }
        .button {
          text-align: right;
        }
        .button input {
          font-weight: bold;
          padding: 8px;
        }
    </style>
</head>

<body>
    <fieldset>
        <legend>Logo de la Emisora</legend>
<?php

if (isset($_POST['action']) && $_POST['action'] == 'image') {

      // set variables
    $dir_dest = ("images");

    $log = '';
    if (file_exists($dir_dest."/logo.png")){ unlink($dir_dest."/logo.png"); }
    // ---------- IMAGE UPLOAD ----------

    // we create an instance of the class, giving as argument the PHP object
    // corresponding to the file field from the form
    // All the uploads are accessible from the PHP object $_FILES
    $handle = new Upload($_FILES['my_field']);

    // then we check if the file has been uploaded properly
    // in its *temporary* location in the server (often, it is /tmp)
    if ($handle->uploaded) {

        // yes, the file is on the server
        // below are some example settings which can be used if the uploaded file is an image.
        $handle->file_new_name_body   = 'logo';
        $handle->image_resize            = true;
        $handle->image_ratio_x           = true;
        $handle->image_y                 = 60;
        $handle->image_convert         = 'png';

        // now, we start the upload 'process'. That is, to copy the uploaded file
        // from its temporary location to the wanted location
        // It could be something like $handle->process('/home/www/my_uploads/');
        $handle->process($dir_dest);

        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !
            echo '<p class="result">';
            echo '  <b>Archivo cargado exitosamente!</b><br />';
            echo '  <img src="'.$dir_dest.'/' . $handle->file_dst_name . '" /><br />';
            $info = getimagesize($handle->file_dst_pathname);
            echo '  Archivo: <a href="'.$dir_dest.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a> ';
            echo '   (' . $info['mime'] . ' - ' . $info[0] . ' x ' . $info[1] .' -  ' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
            echo '</p>';
        } else {
            // one error occured
            echo '<p class="result">';
            echo '  <b>El archivo no subido a la ubicación deseada</b><br />';
            echo '  Error: ' . $handle->error . '';
            echo '</p>';
        }

        $handle-> clean();

    } else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file
        echo '<p class="result">';
        echo '  <b>El archivo no subio al servidor</b><br />';
        echo '  Error: ' . $handle->error . '';
        echo '</p>';
    }

    $log .= $handle->log . '<br />';

} else {
?>
        <p>El logo debe ser de 60px de alto, máximo 240px de ancho, fondo transparente</p>
<?
}
?>
        <form enctype="multipart/form-data" method="post">
            <p><input type="file" name="my_field" value="" /></p>
            <p class="button"><input type="hidden" name="action" value="image" />
            <input type="submit" name="Submit" value="Subir imagen" /></p>
        </form>
    </fieldset>
    <fieldset>
        <legend>Icono</legend>
<?php

if (isset($_POST['action']) && $_POST['action'] == 'app') {

      // set variables
    $dir_dest = ("images/icons");

    $log = '';
    if (file_exists($dir_dest."/favicon.ico")){ unlink($dir_dest."/favicon.ico"); }
    if (file_exists($dir_dest."/homescreen192.png")){ unlink($dir_dest."/homescreen192.png"); }
    // ---------- IMAGE UPLOAD ----------

    // we create an instance of the class, giving as argument the PHP object
    // corresponding to the file field from the form
    // All the uploads are accessible from the PHP object $_FILES
    $handle = new Upload($_FILES['my_field']);

    // then we check if the file has been uploaded properly
    // in its *temporary* location in the server (often, it is /tmp)
    if ($handle->uploaded) {

        // we now process the image a first time, with some other settings
        $handle->file_new_name_body   = 'favicon';
        $handle->image_resize          = true;
        $handle->image_ratio_crop      = true;
        $handle->image_y               = 48;
        $handle->image_x               = 48;
        $handle->image_convert         = 'ico';

        $handle->process($dir_dest);

        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !
            echo '<p class="result">';
            echo '  <b>File uploaded with success</b><br />';
            echo '  <img src="'.$dir_dest.'/' . $handle->file_dst_name . '" />';
            $info = getimagesize($handle->file_dst_pathname);
            echo '  File: <a href="'.$dir_dest.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a><br/>';
            echo '   (' . $info['mime'] . ' - ' . $info[0] . ' x ' . $info[1] .' -  ' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
            echo '</p>';
        } else {
            // one error occured
            echo '<p class="result">';
            echo '  <b>File not uploaded to the wanted location</b><br />';
            echo '  Error: ' . $handle->error . '';
            echo '</p>';
        }

        // we now process the image a seventh time, with some other settings
        $handle->file_new_name_body   = 'homescreen192';
        $handle->image_resize          = true;
        $handle->image_ratio_crop      = true;
        $handle->image_y               = 192;
        $handle->image_x               = 192;
        $handle->image_convert         = 'png';

        $handle->process($dir_dest);

        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !
            echo '<p class="result">';
            echo '  <b>File uploaded with success</b><br />';
            echo '  <img src="'.$dir_dest.'/' . $handle->file_dst_name . '" />';
            $info = getimagesize($handle->file_dst_pathname);
            echo '  File: <a href="'.$dir_dest.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a><br/>';
            echo '   (' . $info['mime'] . ' - ' . $info[0] . ' x ' . $info[1] .' -  ' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
            echo '</p>';
        } else {
            // one error occured
            echo '<p class="result">';
            echo '  <b>File not uploaded to the wanted location</b><br />';
            echo '  Error: ' . $handle->error . '';
            echo '</p>';
        }

        // we delete the temporary files
        $handle-> clean();


    } else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file
        echo '<p class="result">';
        echo '  <b>El archivo no subio al servidor</b><br />';
        echo '  Error: ' . $handle->error . '';
        echo '</p>';
    }

    $log .= $handle->log . '<br />';

} else {
?>
        <p>El ícono, debe ser de 192px x 192px</p>
<?
}
?>
        <form enctype="multipart/form-data" method="post">
            <p><input type="file" name="my_field" value="" /></p>
            <p class="button"><input type="hidden" name="action" value="app" />
            <input type="submit" name="Submit" value="Subir imagen" /></p>
        </form>
    </fieldset>
    <fieldset>
        <legend>Imagenes de la portada</legend>
<?php

if (isset($_POST['action']) && $_POST['action'] == 'multiple') {
  
      // set variables
    $dir_dest = ("splash");

    $log = '';
  
    $files = glob('splash/*'); // get all file names
    foreach($files as $file){ // iterate files
      if(is_file($file)) {
        unlink($file); // delete file
      }
    }

    // ---------- MULTIPLE UPLOADS ----------

    // as it is multiple uploads, we will parse the $_FILES array to reorganize it into $files
    $files = array();
    foreach ($_FILES['my_field'] as $k => $l) {
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files))
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
    }

    // now we can loop through $files, and feed each element to the class
    foreach ($files as $file) {

        // we instanciate the class for each element of $file
        $handle = new Upload($file);

        // then we check if the file has been uploaded properly
        // in its *temporary* location in the server (often, it is /tmp)
        if ($handle->uploaded) {
            $handle->file_new_name_body   = uniqid();
            $handle->image_resize          = true;
            $handle->image_ratio_crop      = true;
            $handle->image_y               = 567;
            $handle->image_x               = 567;
            $handle->image_convert         = 'jpg';
            $handle->jpeg_quality          = 80;
            // now, we start the upload 'process'. That is, to copy the uploaded file
            // from its temporary location to the wanted location
            // It could be something like $handle->process('/home/www/my_uploads/');
            $handle->process($dir_dest);

            // we check if everything went OK
            if ($handle->processed) {
                // everything was fine !
                echo '<p class="result">';
                echo '  <b>Archivo cargado exitosamente!</b><br />';
                echo '  Archivo: <a href="'.$dir_dest.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a>';
                echo '   (' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
                echo '</p>';
            } else {
                // one error occured
                echo '<p class="result">';
                echo '  <b>El archivo no subido a la ubicación deseada</b><br />';
                echo '  Error: ' . $handle->error . '';
                echo '</p>';
            }

        } else {
            // if we're here, the upload file failed for some reasons
            // i.e. the server didn't receive the file
            echo '<p class="result">';
            echo '  <b>El archivo no subio al servidor</b><br />';
            echo '  Error: ' . $handle->error . '';
            echo '</p>';
        }

        $log .= $handle->log . '<br />';
    }

} else {
?>
        <p>Seleccione todas las imagenes, se borraran las actuales al cargar las nuevas </p>
<?
}
?>
        <form enctype="multipart/form-data" method="post">
            <p><input type="file" name="my_field[]" value="" multiple="multiple"/></p>
            <p class="button"><input type="hidden" name="action" value="multiple" />
            <input type="submit" name="Submit" value="Subir imagenes" /></p>
        </form>
    </fieldset>
    <fieldset>
        <legend>Frases de fondo</legend>
<?
if (isset($_POST['frases'])) {
$archivo = fopen("frases.dat", "w");
fwrite($archivo, $_POST['frases']);
fclose($archivo);
echo "<b>Frases cargadas</b>:<br>";
$file = 'frases.dat';      
$data = file_get_contents($file);   
$lines = explode(PHP_EOL, $data);  
$i = 1;
foreach ($lines as &$line) {
  $i = $i++;
  $line = str_replace("\r", "", $line);
  echo $i++.".- ".$line."<br>\r";
}
}
?>

        <p>Cada frase debe estar separada de un salto de línea (máximo 7 líneas)</p>
        <form enctype="multipart/form-data" method="post">
          <p><textarea name="frases" style="width:100%" rows="6">
<?
$file = fopen("frases.dat", "r");
while(!feof($file)) {
echo fgets($file);
}
fclose($file);


?></textarea></p>
  
          <p class="button"><input type="submit" name="Submit" value="Cargar frases" /></p>
        </form>
    </fieldset>
  <fieldset>
        <legend>Información de la Emisora</legend>
<?
if(isset($_POST['action']) && $_POST['action'] == 'info') {
  $data = $_POST['nombre']."\n".$_POST['frecuencia']."\n".$_POST['slogan']."\n".$_POST['direccion']."\n".$_POST['coordenadas']."\n".$_POST['stream']."\n".$_POST['email']."\n".$_POST['telefono']."\n".$_POST['whatsapp']."\n".$_POST['instagram']."\n".$_POST['facebook']."\n".$_POST['twitter']."\n".$_POST['youtube'];
  $filename = "info.dat";
  fopen($filename, 'w');
  file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);
}
$file = 'info.dat';      
$data = file_get_contents($file);   
$line = explode(PHP_EOL, $data);  
?>
        <p>Agregue la información de su emisora </p>
        <form enctype="multipart/form-data" method="post">
          <p><input type="text" name="nombre" placeholder="Nombre de la emisora" value="<?= $line[0] ?>"></p>
            <p><input type="text" name="frecuencia" placeholder="Frecuencia" value="<?= $line[1] ?>"></p>
            <p><input type="text" name="slogan" placeholder="Slogan" value="<?= $line[2] ?>"></p>
            <p><input type="text" name="direccion" placeholder="Dirección" value="<?= $line[3] ?>"></p>
            <p><input type="text" name="coordenadas" placeholder="Coordenadas: latitud,longitud" value="<?= $line[4] ?>"></p>
            <p><input type="text" name="stream" placeholder="Stream: URL de la señal" value="<?= $line[5] ?>"></p>
            <p><input type="text" name="email" placeholder="Correo Eléctronico" value="<?= $line[6] ?>"></p>
            <p><input type="text" name="telefono" placeholder="WhatsApp" value="<?= $line[7] ?>"></p>
            <p>Agregue un mensaje si desea chatear con sus oyentes, sino deje vacio</p>
            <p><input type="text" name="whatsapp" placeholder="Mensaje" value="<?= $line[8] ?>"></p>
        <br><legend>Botón de Redes sociales</legend>
        <p>Llene solo los que desee que aparezcan en la portada </p>
            <p><input type="text" name="instagram" placeholder="Usuario Instagram" value="<?= $line[9] ?>"></p>
            <p><input type="text" name="facebook" placeholder="Usuario Facebook" value="<?= $line[10] ?>"></p>
            <p><input type="text" name="twitter" placeholder="Usuario Twitter" value="<?= $line[11] ?>"></p>
            <p><input type="text" name="youtube" placeholder="Usuario Youtube" value="<?= $line[12] ?>"></p>
            <p class="button"><input type="hidden" name="action" value="info">
            <input type="submit" name="Submit" value="Enviar"></p>
        </form>
    </fieldset>
</body>
</html>
<? } ?>