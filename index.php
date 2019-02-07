<?php

// ---------------------------------------------------------------------------------------------------------
// include config...
// ---------------------------------------------------------------------------------------------------------

$conf = include_once('config.php');

// ---------------------------------------------------------------------------------------------------------
// set current time...
// ---------------------------------------------------------------------------------------------------------

date_default_timezone_set('Europe/London');
$time = time();

// ---------------------------------------------------------------------------------------------------------
// label locations...
// ---------------------------------------------------------------------------------------------------------

$emonbase = "emonbase.pdf";
$emonevse = "emonevse.pdf";
$emonpi   = "emonpi.pdf";
$emonth   = "emonth.pdf";
$emontx   = "emontx.pdf";
$reuse    = "reuse.pdf";
$shield   = "shield.pdf";

// ---------------------------------------------------------------------------------------------------------
// label print...
// ---------------------------------------------------------------------------------------------------------

$labelErr = $copyErr = $colourErr = "";
$label = $copy = $colour = "";


$printer = $conf["printer"];
$color_option = "";
$copy_option = "";

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
     exec("lpr -P" . " " . $printer . " " . $label_print_type . " " .
     "-o KCEcoprint=Off -o MediaType=Transparency -o ColorModel=$colour -o copies=$copy");
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
      <link rel="stylesheet" type="text/css" href="style.css">
  
  </head>
  <body>
    
    <h2 class="shop_heading"> Shop Labels | OpenEnergyMonitor </h2>
    
    <div class="label_form">
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      
      <input type="radio" name="label"
        <?php if (isset($label) && $label == $emonpi) echo "checked";?>
        value=<?php echo $emonpi ?>> emonPi Box
      <br>
      <input type="radio" name="label"
        <?php if (isset($label) && $label == $shield) echo "checked";?>
        value=<?php echo $shield ?>> Shield
      <br>
      <input type="radio" name="label"
        <?php if (isset($label) && $label == $emontx) echo "checked";?>
        value=<?php echo $emontx ?>> emonTx
      <br>
      <input type="radio" name="label"
        <?php if (isset($label) && $label == $emonth) echo "checked";?>
        value=<?php echo $emonth ?>> emonTH
      <br>
      <input type="radio" name="label"
        <?php if (isset($label) && $label == $reuse) echo "checked";?>
        value=<?php echo $reuse ?>> Re-Use
      <br>
      <input type="radio" name="label"
        <?php if (isset($label) && $label == $emonevse) echo "checked";?>
        value=<?php echo $emonevse ?>> emonEVSE
    
      <br><br>
      
      <div class="copies_box">
        Copies:
      </div>
      
      <div class="copies_box">
        <label>
          <input type="radio" name="copy"
          <?php if ((isset($copy) && $copy == "1") || (empty($copy))) echo "checked";?> value="1">1
        </label>
        <label>
          <input type="radio" name="copy"
          <?php if (isset($copy) && $copy == "2") echo "checked";?> value="2">2
        </label>
        <label>
          <input type="radio" name="copy"
          <?php if (isset($copy) && $copy == "3") echo "checked";?> value="3">3
        </label>
        <label>
          <input type="radio" name="copy"
          <?php if (isset($copy) && $copy == "4") echo "checked";?> value="4">4
        </label>
        <label>
          <input type="radio" name="copy"
          <?php if (isset($copy) && $copy == "5") echo "checked";?> value="5">5
        </label>
        <br>
        <label>
          <input type="radio" name="copy"
          <?php if (isset($copy) && $copy == "2") echo "checked";?> value="6">6
        </label>
        <label>
          <input type="radio" name="copy"
          <?php if (isset($copy) && $copy == "3") echo "checked";?> value="7">7
        </label>
        <label>
          <input type="radio" name="copy"
          <?php if (isset($copy) && $copy == "4") echo "checked";?> value="8">8
        </label>
        <label>
          <input type="radio" name="copy"
          <?php if (isset($copy) && $copy == "5") echo "checked";?> value="9">9
        </label>
        <label>
          <input type="radio" name="copy"
          <?php if (isset($copy) && $copy == "5") echo "checked";?> value="10">10
        </label>
      </div>
      
      <br><br><br>

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
        
        if($_GET)
        {
          echo "<div class='outputbox'>";
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
          echo "</div>";
        }
        
      ?>
      
      </div>
    
    </form>

  </body>
</html>
