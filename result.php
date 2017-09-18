<?php 
$search_item = rawurlencode('maroon5');
$url = 'https://itunes.apple.com/search';
$response = file_get_contents('https://itunes.apple.com/search?term='.$search_item.'&media=music&entity=song&country=jp&lang_ja_jp&limit=10');
// $response = file_get_contents('https://itunes.apple.com/search?term=twitter&media=software&entity=software&country=jp&lang=ja_jp&limit=10');
$result = json_decode($response,true);
var_dump($result);
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Get My Code</title>
</head>
<body>
<div class="wrapper">
  
</div>
</body>
</html>