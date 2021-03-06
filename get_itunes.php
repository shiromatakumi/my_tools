<?php
require_once( 'get_itunes_json.php' );

if(isset($num)&&$num!=='no') {
  $source = '<a href="'.$trackViewUrl.'&app=itunes&at='.$affi_token.'" style="display:inline-block;overflow:hidden;background:url(//linkmaker.itunes.apple.com/assets/shared/badges/ja-jp/itunes-lrg.svg) no-repeat;width:110px;height:40px;background-size:contain;"><span style="display:none;">.</span></a>';
} elseif(isset($num)&&$num==='no') {
  $source = '&nbsp;';
}
if(isset($source)) {$source_str = htmlspecialchars($source, ENT_QUOTES);}

if(isset($num_album)&&$num_album!=='no') {
  $album_source = '<a href="'.$album_trackViewUrl.'?app=itunes&at='.$affi_token.'" style="display:inline-block;overflow:hidden;background:url(//linkmaker.itunes.apple.com/assets/shared/badges/ja-jp/itunes-lrg.svg) no-repeat;width:110px;height:40px;background-size:contain;"><span style="display:none;">.</span></a>';
} elseif(isset($num_album)&&$num_album==='no'){
  $album_source = '&nbsp;';
}

if(isset($source) && isset($album_source)) {
  $get_source = '<table class="dl-table"><tbody><tr><td class="dl-td" colspan="2">Download</td></tr><tr><td>Song</td><td>Album</td></tr><tr><td>'.$source.'</td><td>'.$album_source.'</td></tr></tbody></table>';

  $album_source_str = htmlspecialchars($get_source, ENT_QUOTES);
}

$index = 0;
$index_album = 0; 
?>
<?php require_once './common/header.php'; ?>
  <div class="clear-code">
    <a href="./get_itunes.php">初期化する</a>
  </div>
  
  <div class="result clearfix">
  <form action="get_itunes.php" method="GET">
    <div class="clearfix">
      <div class="result-song">
        <div class="search-box">
          <p>キーワードで検索する</p>
          <input type="text" name="word-song" value="<?php if(isset($word)) echo $word; ?>">
          <button type="submit">検索する</button>
        <!-- </form> -->
      </div>
      <h3>Song</h3>
        <div class="result-item clearfix no-choice">
          <div class="radio-button">
            <input type="radio" name="num" value="no"<?php if(isset($num) && $num==='no'|| !isset($num)) echo ' checked'; ?>>
          </div>
          <div class="result-item-text">
            <p>Songなし（Albumのみ）</p>
          </div>
        </div>
        <?php if(isset($result_item_all)): ?>
        <?php foreach($result_item_all as $value): ?>
        <div class="result-item clearfix">
          <div class="radio-button">
            <?php if(intval($num)===$index&&$num!=='no'): ?>
            <input type="radio" name="num" value="<?php echo $index; ?>" checked>
            <?php else: ?>
            <input type="radio" name="num" value="<?php echo $index; ?>">
            <?php endif; ?>
          </div>
          <div class="result-item-img">
            <p><img src="<?php echo $value["artworkUrl100"]; ?>" alt=""></p>
          </div>
          <div class="result-item-text">
            <p><?php echo $value["artistName"]; ?></p>
            <p><a href="<?php echo $value["trackViewUrl"]; ?>"><?php echo $value["trackName"]; ?></a></p>
            <p><a href="<?php echo $value["collectionViewUrl"]; ?>"><?php echo $value["collectionName"]; ?></a></p>
            <p><?php echo $value["primaryGenreName"]; ?></p>
            <?php $index++; ?>
          </div>
          </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="result-album">
        <div class="search-box">
          <p>キーワードで検索する</p>
          <input type="text" name="word-album" value="<?php if(isset($word_album)) echo $word_album; ?>">
          <button type="submit">検索する</button>
        </div>
        <h3>album</h3>
          <div class="result-item clearfix no-choice">
            <div class="radio-button">
              <input type="radio" name="num-album" value="no"<?php if(isset($num_album) && $num_album==='no'|| !isset($num_album)) echo ' checked'; ?>>
            </div>
            <div class="result-item-text">
              <p>Albumなし（Songのみ）</p>
            </div>
          </div>
          <?php if(isset($album_item_all)): ?>
        <?php foreach($album_item_all as $value): ?>
          <div class="result-item clearfix">
            <div class="radio-button">
              <?php if(intval($num_album)===$index_album&&$num_album!=='no'): ?>
              <input type="radio" name="num-album" value="<?php echo $index_album; ?>" checked>
              <?php else: ?>
              <input type="radio" name="num-album" value="<?php echo $index_album; ?>">
              <?php endif; ?>
            </div>
            <div class="result-item-img">
              <p><img src="<?php echo $value["artworkUrl100"]; ?>" alt=""></p>
            </div>
            <div class="result-item-text">
              <p><?php echo $value["artistName"]; ?></p>
              <p><a href="<?php echo $value["trackViewUrl"]; ?>"><?php echo $value["collectionName"]; ?></a></p>
              <p><a href="<?php echo $value["collectionViewUrl"]; ?>"><?php echo $value["collectionName"]; ?></a></p>
              <p><?php echo $value["primaryGenreName"]; ?></p>
              <?php $index_album++; ?>
            </div>
          </div>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>
      </div>
      <div class="submit-button">
        <button type="submit" name="word" value="<?php echo $word; ?>">Get Code</button>
      </div>
    </form>
  </div><!-- result -->
  <div class="get-code">
    <div class="pre">
      <?php if(isset($get_source)) echo $get_source; ?>
    </div>
    <textarea name=""><?php if(isset($album_source_str)) echo $album_source_str; ?></textarea>
  </div>
  <div class="clear-code">
    <a href="./get_itunes.php">初期化する</a>
  </div>
<?php require_once './common/footer.php'; ?>