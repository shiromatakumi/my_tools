<?php
//　共通設定
if(isset($_GET['num'])) $num = $_GET['num'];  // チェックされた番号
if(isset($_GET['word-song'])) $word = $_GET['word-song'];  // シングル検索語

$affi_token = '1010laZh';
$option = [
        CURLOPT_RETURNTRANSFER => true, //文字列として返す
        CURLOPT_TIMEOUT        => 3, // タイムアウト時間
    ];
$jsonArray = [];
// song
// 検索ワード
if(isset($word)) {
  $search_item = rawurlencode($word);
  $response = curl_init('https://itunes.apple.com/search?term='.$search_item.'&media=music&entity=song&country=jp&lang_ja_jp&limit=5');
  curl_setopt_array($response, $option);

  $json    = curl_exec($response);
    $info    = curl_getinfo($response);
    $errorNo = curl_errno($response);


  // OK以外はエラーなので空白配列を返す
    if ($errorNo !== CURLE_OK) {
        // 詳しくエラーハンドリングしたい場合はerrorNoで確認
        // タイムアウトの場合はCURLE_OPERATION_TIMEDOUT
        // return;
    }

    // 200以外のステータスコードは失敗とみなし空配列を返す
    if ($info['http_code'] !== 200) {
        // return;
    }

    // 文字列から変換
    $jsonArray = json_decode($json, true);

}

var_dump($jsonArray);


$index = 0;
?>
<?php require_once './common/header.php'; ?>
  <div class="clear-code">
    <a href="./test.php">初期化する</a>
  </div>
  
  <div class="result clearfix">
  <form action="test.php" method="GET">
    <div class="clearfix">
      <div class="result-song">
        <div class="search-box">
          <p>キーワードで検索する</p>
          <input type="text" name="word-song" value="<?php if(isset($word)) echo $word; ?>">
          <button type="submit">検索する</button>
        <!-- </form> -->
      </div>
    </form>
  </div>