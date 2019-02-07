<?php

$conf = include_once('config.php');

// ---------------------------------------------------------------------------------------------------------

date_default_timezone_set('Europe/London');
$time = time();

// ---------------------------------------------------------------------------------------------------------

$labelErr = $copyErr = $colourErr = "";
$label = $copy = $colour = "";


$printer = $conf("printer");
$color_option = "";
$copy_option = "";
$print_options = "-o KCEcoprint=Off -o MediaType=Transparency -o ColorModel=cmyk -o copies=1";

if ($action = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING)) {

  if (empty($_POST["label"])) {
    $labelErr = "* label type is required";
  } else {
    $label = $_POST["label"];
  }
  
  if (empty($_POST["copy"])) {
    $copyErr = "* number of copies is required";
  } else {
    $copy = $_POST["copy"];
  }

  if (empty($_POST["colour"])) {
    $colourErr = "* colour type is required";
  } else {
    $colour = $_POST["colour"];
  }
 
  if ( !empty($label) && !empty($copy) && !empty($colour) ) {
     $label_print_type = $label;
     //$copy_option = $copy;
     $color_option = $colour;
     error_log("lpr -P" . $printer . $label_print_type .
     "-o KCEcoprint=Off -o MediaType=Transparency -o ColorModel=cmyk -o copies=1"
     );
     $get_info = "?label=$label&copies=$copy&colour=$colour&time=$time";
     header("Location: ".$_SERVER['PHP_SELF'].$get_info);
  }
  
}

?>

<!doctype html>

<html lang="en">
  <head>
    
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Shop Labels | OpenEnergyMonitor</title>
  
  </head>
  <body>
    
    <h2> Shop Labels | OpenEnergyMonitor </h2>
    
    <hr>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      
      
      <input type="radio" name="label" <?php if (isset($label) && $label == "emonpi.pdf") echo "checked";?> value="emonpi.pdf"> emonPi Box
      <br>
      <input type="radio" name="label" <?php if (isset($label) && $label == "Shield") echo "checked";?> value="Shield"> Shield
      <br>
      <input type="radio" name="label" <?php if (isset($label) && $label == "emonTx")   echo "checked";?> value="emonTx"> emonTx
      <br>
      <input type="radio" name="label" <?php if (isset($label) && $label == "emonTH")   echo "checked";?> value="emonTH"> emonTH
      <br>
      <input type="radio" name="label" <?php if (isset($label) && $label == "Re-Use")   echo "checked";?> value="Re-Use"> Re-Use
      <br>
      <input type="radio" name="label" <?php if (isset($label) && $label == "emonEVSE") echo "checked";?> value="emonEVSE">emonEVSE
    
      <br><br>
      
      Copies:
      
      <input type="radio" name="copy" <?php if ((isset($copy) && $copy == "1") || (empty($copy))) echo "checked";?> value="1">1
      <input type="radio" name="copy" <?php if (isset($copy) && $copy == "2") echo "checked";?> value="2">2
      <input type="radio" name="copy" <?php if (isset($copy) && $copy == "3") echo "checked";?> value="3">3
      <input type="radio" name="copy" <?php if (isset($copy) && $copy == "4") echo "checked";?> value="4">4
      <input type="radio" name="copy" <?php if (isset($copy) && $copy == "5") echo "checked";?> value="5">5
    
      <br><br>
      
      Colour:
      
      <input type="radio" name="colour" <?php if ((isset($colour) && $colour == "gray") || (empty($colour)))     echo "checked";?> value="gray">Black
      <input type="radio" name="colour" <?php if (isset($colour) && $colour == "cmyk") echo "checked";?> value="cmyk">Colour
      
      <br><br>
      
      <input type="submit" name="submit" value="Print (MP Tray)">
      
      <br><br>
      
      <span class="error"><?php echo $labelErr;?></span>
      <span class="error"><?php echo $copyErr;?></span>
      <span class="error"><?php echo $colourErr;?></span>
      
      <?php
        
        if($_GET){

          echo "Sent to printer:";
          echo("<br>");
          echo "Label: " . htmlspecialchars($_GET["label"]);
          echo("<br>");
          echo "No. of copies: " . htmlspecialchars($_GET["copies"]);
          echo("<br>");
          echo "Colour: " . htmlspecialchars($_GET["colour"]);
          echo("<br>");
          $time = htmlspecialchars($_GET["time"]);
          $time = (int)$time;
          echo (date("Y-m-d H:i:s", $time));

        }
        
      ?>
      
      
    </form>

  </body>
</html>
