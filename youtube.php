<?php 

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_YouTubeService.php';
session_start();
if(isset($_GET['word'])) {
  $word = $_GET['word'];
} elseif(isset($_SESSION['word'])) {
  $word = $_SESSION['word'];
}
if(isset($_GET['id'])) {
  $movie_id = $_GET['id'];
} elseif($_SESSION['id']) {
  $movie_id = $_SESSION['id'];
}

$OAUTH2_CLIENT_ID = 'balmy-vehicle-170209';
$OAUTH2_CLIENT_SECRET = 'AIzaSyDC9T1IHx1di8UAc79U_eGE1xCdVW8AzS8';
$client = new Google_Client();
$client->setDeveloperKey($OAUTH2_CLIENT_SECRET);
$youtube = new Google_YouTubeService($client); 

try {
  // 検索ワードから動画を表示
  if(isset($word)) {
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
      'q' => $word,
      'maxResults' => 20,
    ));
    $searchResItem = $searchResponse['items'];
  }

  if(isset($movie_id)){
    // IDから情報検索
    $videoResponse = $youtube->videos->listVideos('snippet', array(
        'id' => $movie_id 
    ));
    $videoItem = $videoResponse["items"][0];
    $videoId = $videoItem['id'];
    $videoTitle = $videoItem['snippet']['title'];

    $source = '<div class="youtube" data-video="http://www.youtube.com/embed/'.$videoId.'?autoplay=1"><img src="http://img.youtube.com/vi/'.$videoId.'/hqdefault.jpg" alt="'.$videoTitle.'" /></div>'.PHP_EOL.'<p><strong>'.$videoTitle.'</strong></p>';
    $source_str = htmlspecialchars($source, ENT_QUOTES);
  }
} catch (Google_Service_Exception $e) {
  $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
    htmlspecialchars($e->getMessage()));
} catch (Google_Exception $e) {
  $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
    htmlspecialchars($e->getMessage()));
}
$_SESSION['word'] = $word;
$_SESSION['id'] = $movie_id;

?>

<?php require_once './common/header.php'; ?>
<div class="clear-code">
  <a href="./youtube.php">初期化する</a>
</div>
<div class="youtube-get-code">
  <div class="search-youtube">
    <h3>検索からコードを生成する</h3>
    <form action="youtube.php" method="get" accept-charset="utf-8">
      <input type="text" name="word" <?php if(isset($word)) echo 'value="'.$word.'"'; ?>>
      <button type="submit">検索する</button>
    </form>
  </div>
  <div class="search-result">
    <?php if(isset($word)): ?>
    <?php foreach($searchResItem as $value): ?>
      <?php if($value['id']['kind'] !== 'youtube#channel' ): ?>
    <div class="result-item clearfix">
      <div class="result-item-img">
        <img src="<?php echo $value['snippet']['thumbnails']['default']['url']; ?>" alt="">
      </div>
      <div class="result-item-text resulet-youtube">
        <p><a href="https://www.youtube.com/watch?v=<?php echo $value['id']['videoId']; ?>" target="_blank"><?php echo $value['snippet']['title']; ?></a></p>
        <p><?php echo $value['snippet']['channelTitle']; ?></p>
        <p></p>
        <form action="youtube.php#get-code" method="get" accept-charset="utf-8">
          <button type="submit" name="id" value="<?php echo $value['id']['videoId']; ?>">get this code</button>
        </form>
      </div>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <div class="youtube-id">
    <h3>IDを指定してコードを生成する</h3>
    <form action="youtube.php#get-code" method="get" accept-charset="utf-8">
      <input type="text" name="id">
      <button type="submit">コードを取得する</button>
    </form>
  </div>
</div>
<div class="get-code" id="get-code">
    <div class="pre">
      <?php echo $source; ?>
    </div>
    <textarea name=""><?php echo $source_str; ?></textarea>
  </div>
<div class="clear-code">
  <a href="./youtube.php">初期化する</a>
</div>
<?php require_once './common/footer.php'; ?>