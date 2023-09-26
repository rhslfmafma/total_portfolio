<?php
$title="수강평 댓글 수정";
$css_route="review/css/review.css";
$js_route = "review/js/review.js";
include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/admin/inc/header.php';

$rid = $_GET['rid'];
$userid = $_GET['userid'];
$cid = $_GET  ['cid'];


$sql = "SELECT r.*, u.username, u.userimg, c.name FROM review r
        JOIN users u ON r.userid = u.userid
        JOIN courses c ON c.cid = r.cid
        WHERE r.rid = '{$rid}' AND r.userid = '{$userid}' AND r.cid = '{$cid}'";


$result = $mysqli->query($sql);
$card = $result->fetch_assoc();


$rsql = "SELECT * FROM review_reply where rid={$rid}";
$rresult = $mysqli->query($rsql);
$rp = $rresult->fetch_assoc();



?>


<section>
  <h2 class="main_tt dark title-mg">수강평 댓글 수정</h2>
    <div class="card_container shadow_box border" data-id="<?= $card["rid"]; ?>">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <img src="<?php
                if ($card["userimg"] == '') {
                  echo "/pudding-LMS-website/user/images/profile/default_profile.png";
                } else {
                  echo $card["userimg"];
                }
                ?>" class="userImg shodow_box" alt="프로필 이미지">
          <h5 class="b_text01 dark review_user"><?= $card["username"]; ?></h5>
          <h5 class="b_text01 dark review_name"><span>강의명: </span><?= $card["name"]; ?></h5>
        </div>
        <div class="rating" data-rate="<?= $card["rating"]; ?>">

        <?php
          for ($i = 1; $i <= 5; $i++) {
              if ($i <= $card["rating"]) {
                  echo '<i class="ti ti-star-filled"></i>';
              } else {
                  echo '<i class="ti ti-star-filled not_star"></i>';
              }
          }
          ?>
        </div>
      
      </div>
      <div class=" b_text02 review_content border">
  
        <p><?= $card["content"]; ?></p>
        <p><?= $card["regdate"]; ?></p>
      </div>

      <form class="b_text02 review_c_content border" action="review_reply_update_ok.php?rid=<?= $rp["rid"]; ?>" method="POST">
        <input type="hidden" name="cid" value="<?= $card["cid"]; ?>">
        <input type="hidden" name="userid" value="<?= $card["userid"]; ?>">
        <div class="d-flex align-items-center">
          <img src="../images/profile_img.png" class="userImg shodow_box" alt="프로필 이미지">
          <h5 class="b_text01 primary review_user">프바오</h5>

        </div>
        <div class="b_text02 reply_content border">
          
          <textarea name="reply_update" id="reply_update" rows="6"><?= $rp["r_content"]; ?></textarea>
        </div>
    
        <div class="d-flex flex-row justify-content-end reply_btn">
          <button  class="btn btn-primary b_text01 reply_done">수정 완료</button>
          <a href="review_reply_view.php?rid=<?= $rp["rid"]; ?>&userid=<?= $card["userid"]; ?>&cid=<?= $card["cid"]; ?>" class="btn btn-dark b_text01 reply">수정 취소</a>
        </div>
      </form>
    
    </div>
    
  </section>
</div>
</div>


<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/admin/inc/footer.php';
?>