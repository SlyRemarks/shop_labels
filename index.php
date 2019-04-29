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
     exec("lpr -P" . " " . $printer . " " . $label . " " .
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
        
        <label class="label-option">
          <input type="radio" name="label"
            <?php if (isset($label) && $label == $emonpi) echo "checked";?>
            value=<?php echo $emonpi ?>> emonPi Box <a href="emonpi.pdf"><small>(view)</small></a>
        </label>
        <label class="label-option">
          <input type="radio" name="label"
            <?php if (isset($label) && $label == $shield) echo "checked";?>
            value=<?php echo $shield ?>> Shield <a href="shield.pdf"><small>(view)</small></a>
        </label>
        <label class="label-option">
          <input type="radio" name="label"
            <?php if (isset($label) && $label == $emontx) echo "checked";?>
            value=<?php echo $emontx ?>> emonTx <a href="emontx.pdf"><small>(view)</small></a>
        </label>
        <label class="label-option">
          <input type="radio" name="label"
            <?php if (isset($label) && $label == $emonth) echo "checked";?>
            value=<?php echo $emonth ?>> emonTH <a href="emonth.pdf"><small>(view)</small></a>
        </label>
        <label class="label-option">
          <input type="radio" name="label"
            <?php if (isset($label) && $label == $reuse) echo "checked";?>
            value=<?php echo $reuse ?>> Re-Use <a href="reuse.pdf"><small>(view)</small></a>
        </label>
        <label class="label-option">
          <input type="radio" name="label"
            <?php if (isset($label) && $label == $emonevse) echo "checked";?>
            value=<?php echo $emonevse ?>> emonEVSE <a href="emonevse.pdf"><small>(view)</small></a>
        </label>
        
        <br><br>
        
        <div class="copies_box">
          <span class="type_desc">Copies:</span>
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
  
        <span class="type_desc">Colour:</span>
        
        <label>
          <input type="radio" name="colour"
            <?php if ((isset($colour) && $colour == "gray") || (empty($colour)))
            echo "checked";?> value="gray">Black
        </label>
        <label>
          <input type="radio" name="colour"
            <?php if (isset($colour) && $colour == "cmyk")
            echo "checked";?> value="cmyk">Colour
        </label>
        
        <br><br>
        
        <input type="submit" name="submit" value="Print (MP Tray)">
        
        <br><br>
        
        <span class="error"><?php echo $labelErr;?></span>
        <span class="error"><?php echo $copyErr;?></span>
        <span class="error"><?php echo $colourErr;?></span>
        
        <?php
          
          if ($_GET)
          {
            echo "<div class='outputbox'>";
            echo "Sent to printer:";
            echo("<br><br>");
            echo "<i>Label: </i>" . htmlspecialchars($_GET["label"]);
            echo("<br>");
            echo("<i>No. of copies: </i>" . htmlspecialchars($_GET["copies"]));
            echo("<br>");
            
            if (htmlspecialchars($_GET["colour"]) == "cmyk") {
              echo("<i>Colour: </i>Colour");
            }
            
            else {
              echo("<i>Colour: </i>Black");
            }
            
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
