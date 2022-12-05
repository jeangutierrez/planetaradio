<?
$file = 'info.dat';      
$data = file_get_contents($file);   
$info = explode(PHP_EOL, $data);
if(!isset($_COOKIE['view'])) { 
  setcookie('view', 1, time() + (60*60*24*7), "/");
} else {
  setcookie('view', $_COOKIE['view'] + 1, time() + (60*60*24*7), "/");
} 
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Language" content="es">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="HandheldFriendly" content="True"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1" />
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta name="theme-color" content="#1d1d1d">
<title><?= !empty($info[0]) ? $info[0]." ".$info[1]." en Vivo" : "" ?></title>
<link rel="icon" href="images/icons/favicon.ico" type="image/x-icon">
<link rel="manifest" href="manifest.json">
<link rel="stylesheet" href="css/styles.css" type="text/css">
<script src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/modernizr.js"></script>
<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="js/jcarousel.js"></script>
<link rel="stylesheet" href="css/jcarousel.css" type="text/css">
<script type="text/javascript" src="js/jquery.parallax.js"></script>
<script type="text/javascript" src="js/jparallax.js"></script>
<link rel="stylesheet" href="css/parallax.css" type="text/css">
<script type="text/javascript" src="js/jplayer.js"></script>
<link rel="stylesheet" href="css/jplayer.css" type="text/css">
<script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
<div class="spinner"></div>
<div class="w3-display-container w3-content" id="splash">
  <div class="bg1"></div>
  <div class="pattern"></div>
  <div class="px1"></div>
  <div id="parallax">
<?
$file = 'frases.dat';      
$data = file_get_contents($file);   
$lines = explode(PHP_EOL, $data);  
$lines = array_slice($lines, 0, 7);
$i = 1;
foreach ($lines as &$line) {
  $i = $i++;
  $line = str_replace("\r", "", $line);
  echo "    <div class=\"cloud".$i++." parallax-viewport\"><div class=\"cloud_img".($i-1)." parallax-layer\">".$line."</div></div>\r";
}
?>  </div>
   <div class="splash">
    <div class="jcarousel">
      <ul>
<?
                              
if (file_exists($_SERVER['DOCUMENT_ROOT']."/splash/")) {
  $image = scandir("splash/");
  if (isset($image[2])) { ?>
<? 
    $images = array_diff(scandir("splash/"), array('.', '..'));
    $count = 0;
    foreach ($images as $image) {
      $count++;      
      $image = str_replace("\n","",$image); ?>
        <li><img src="splash/<?= $image ?>"></li> 
<?  }
?>
<?
    for($i=1;$i<$count+1;$i++) {
?>
<?  }
?>
<?   
  }
} ?>
      </ul>
    </div>
    <a href="#" class="jcarousel-control-prev"></a>
    <a href="#" class="jcarousel-control-next"></a>
  </div>
  <div class="main">
    <div class="hl1"></div>
    <div class="hl2"></div>
    <header>
      <div class="logo_wrapper"></div>
      <span class="over">
        <div class="mediPlayer">
          <audio preload="none" src="<?= $info[5] ?>" type="audio/mpeg"></audio>
        </div>
        <script>
        $(document).ready(function () {
          $('.mediPlayer').mediaPlayer();
        });
        </script>
      </span>
    </header>
    <div class="frequency"><?= $info[1] ?></div>
  </div>
</div>
<footer>
<div class="copyright"><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JWVVHFGUU84A8" target="_blank"><img src="images/icons/paypal.png" style="background: #ffc439;padding: 8px 32px;border-radius: 3px;"></a></div>
<? if(empty($info[8]) && empty($info[9]) && empty($info[10]) && empty($info[11]) && empty($info[12])){ echo ""; } else { ?>
<ul class="icons">
<li class="add-button"><a><img src="images/icons/android.png" style="width:108px;"></a></li><style>.add-button{cursor:pointer;}</style>
<?= !empty($info[9]) ? "  <li><a href=\"https://www.instagram.com/".$info[9]."\" target=\"_blank\"><img src=\"images/icons/instagram.png\"></a></li>\n" : "" ?>
<?= !empty($info[10]) ? "  <li><a href=\"https://www.facebook.com/".$info[10]."\" target=\"_blank\"><img src=\"images/icons/facebook.png\"></a></li>\n" : "" ?>
<?= !empty($info[11]) ? "  <li><a href=\"https://twitter.com/".$info[11]."\" target=\"_blank\"><img src=\"images/icons/twitter.png\"></a></li>\n" : "" ?>
<?= !empty($info[12]) ? "  <li><a href=\"https://www.youtube.com/user/".$info[12]."\" target=\"_blank\"><img src=\"images/icons/youtube.png\"></a></li>\n" : "" ?>
<?= !empty($info[8]) ? "  <li style=\"width: ".((isset($_COOKIE['view']) && $_COOKIE['view'] >= 1) ? "32" : "60")."px;\"><div id=\"WhatsApp\"></div></li>\n" : "" ?>
</ul>

</footer>
<? if(!empty($info[8])) { ?>
<script type="text/javascript" src="js/wapp.js"></script>
<link rel="stylesheet" href="css/wapp.css">
<script type="text/javascript">
  $(function () {
    $('#WhatsApp').floatingWhatsApp({
      phone: '<?= $info[7] ?>',
      popupMessage: '<?= $info[8] ?>',
      placeholder: 'Escriba su mensaje... ',
      headerTitle: '<b><?= $info[0] ?></b>',
<? if(isset($_COOKIE['view']) && $_COOKIE['view'] >= 1) { ?>
      size: '32px',
      showPopup: false,
      autoOpenTimeout: 0,
<? } ?>
    });
  });
</script>
<? } } ?>
<script type="text/javascript" src="index.js"></script>
</body>
</html>