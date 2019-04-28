<?php

//　共通設定
if(isset($_GET['num'])) $num = $_GET['num'];  // チェックされた番号
if(isset($_GET['word-song'])) $word = $_GET['word-song'];  // シングル検索語
if(isset($_GET['num-album'])) $num_album = $_GET['num-album'];  // チェックされた番号（アルバム）
if(isset($_GET['word-album'])) $word_album = $_GET['word-album']; // アルバム検索後

$affi_token = '1010laZh';
$limit_num = '5';
$option = [
        CURLOPT_RETURNTRANSFER => true, //文字列として返す
        CURLOPT_TIMEOUT        => 20, // タイムアウト時間
      ];


// song
// 検索ワード
if(isset($word)) {
  $search_item = rawurlencode($word);
  $response = curl_init('https://itunes.apple.com/search?term='.$search_item.'&media=music&entity=song&country=jp&lang_ja_jp&limit='.$limit_num);
  curl_setopt_array($response, $option);
  $response    = curl_exec($response);
  $result = json_decode($response,true);
  $result_item_all = $result["results"];
}

if(isset($result_item_all) && isset($num) && $num !== 'no'){
  $result_item = $result_item_all[$num];
  $collectionId = $result_item["collectionId"];
  $trackId = $result_item["trackId"];
  $trackName = $result_item["trackName"];
  $trackViewUrl = $result_item["trackViewUrl"];
  $trackViewUrl = preg_replace('/https:\/\//','https://geo.',$trackViewUrl);
  $trackViewUrl = preg_replace('/(.)uo=(.*)/','',$trackViewUrl);  
}

// album
// 検索ワード
if(isset($word_album)) {
  
  $search_item_album = rawurlencode($word_album);
  $res_album = curl_init('https://itunes.apple.com/search?term='.$search_item_album.'&media=music&entity=album&country=jp&lang_ja_jp&limit='.$limit_num);
  curl_setopt_array($res_album, $option);
  $res_album    = curl_exec($res_album);
  $album = json_decode($res_album,true);
  $album_item_all = $album["results"];
}
// 
if(isset($album_item_all) && isset($num_album) && $num_album !== 'no'){
  $album_item = $album_item_all[$num_album];
  $album_trackName = $album_item["collectionName"];
  $album_trackViewUrl = $album_item["collectionViewUrl"];
  $album_trackViewUrl = preg_replace('/https:\/\//','https://geo.',$album_trackViewUrl);
  $album_trackViewUrl = preg_replace('/(.)uo=(.*)/','',$album_trackViewUrl);
  $album_track_num = $album_item["trackCount"];
}