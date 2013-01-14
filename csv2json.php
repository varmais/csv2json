<?php

function csvToArray($file, $delimiter) { 
  if (($handle = fopen($file, 'r')) !== FALSE) { 
    $i = 0; 
    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
      for ($j = 0; $j < count($lineArray); $j++) { 
        $arr[$i][$j] = $lineArray[$j]; 
      } 
      $i++; 
    } 
    fclose($handle); 
  } 
  return $arr; 
} 

if(isset($_POST['url'])) {
header('Content-type: application/json');
 
$feed = $_POST['url'];
$keys = array();
$newArray = array();
$data = csvToArray($feed, ',');
$count = count($data) - 1;
 
//eka rivi on otsikot
$labels = array_shift($data);  
 
foreach ($labels as $label) {
  $keys[] = $label;
}
 
//lisätään ID:t
$keys[] = 'id';
 
for ($i = 0; $i < $count; $i++) {
  $data[$i][] = $i;
}
 
//lisätään yhteen arrayhin
for ($j = 0; $j < $count; $j++) {
  $d = array_combine($keys, $data[$j]);
  $newArray[$j] = $d;
}

//tulostetaan JSON:iksi
echo json_encode($newArray);

} else {
?>

<!DOCTYPE html>
<html>
  <head>
    <title>CSV to JSON converter \o/</title>
  </head>
  <body>
    <form action="scrape.php" method="post">
    <input type="text" name="url" size="100" placeholder="Syötä url-osoite.." required />
    <input type="submit" name="submit" value="Käännä JSON:iksi" />
    </form>
  </body>
</html>

<?php
}
?>

