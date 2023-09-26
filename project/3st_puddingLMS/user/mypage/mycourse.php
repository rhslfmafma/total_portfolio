<?php
$title="마이페이지 - 내 수강평";
$css_route="mypage/css/mypage.css";
$js_route = "mypage/js/mypage.js";
  include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/user/inc/header.php';

 $cid = $_GET['cid'];
 
 $sql = "SELECT c.*, l.* FROM courses c 
          JOIN lecture l on l.cid = c.cid 
          WHERE l.cid ={$cid}";

$result = $mysqli->query($sql);
$rowcourse = $result->fetch_assoc();
 $rs = array();
while ($row = $result->fetch_object()) {
  $rs[] = $row;
}


$cateArray = explode('/', $rowcourse['cate']);


?>
<main class="d-flex">
    <aside class="mypage_wrap">
      <div class="">
        <h4 class="jua main_tt my_title">마이페이지</h4>
        <nav>
          <ul>
          <li class="content_stt link_tag mypage_tag"><a href="/pudding-LMS-website/user/mypage/mypage.php">내 강의실</a></li>
            <li class="content_stt mypage_tag"><a href="/pudding-LMS-website/user/mypage/buypage.php">구매내역</a></li>
            <li class="content_stt mypage_tag"><a href="/pudding-LMS-website/user/mypage/couponpage.php">쿠폰함</a></li>
            <li class="content_stt mypage_tag"><a href="/pudding-LMS-website/user/mypage/review_list.php">수강평</a></li>
          </ul>
        </nav>
      </div>
    </aside>
    <div class="section_wrap">
    <section class="content_wrap_course">
      <div class="d-flex justify-content-between align-items-center">
        <h2 class="jua pd_2">내강의실</h2>
        <a href="/pudding-LMS-website/user/mypage/mypage.php" class="btn btn-dark">목록가기</a>
      </div>
      <div class="viewSetion_1 shadow_box pd_2">
        <div class="d-flex gap-5">
          <div>
            <img src="<?php echo $rowcourse['thumbnail'] ?>" alt="" />
          </div>
          <div class="viewTitleWrap d-flex flex-column justify-content-between">
            <div>
              <div class="d-flex justify-content-between">
             
                <div>
                
                  <span class="badge rounded-pill blue_bg b-pd"><?php echo $cateArray[2] ?></span>
                  <span class="badge rounded-pill yellow_bg b-pd"><?php echo $rowcourse['level'] ?></span>
                </div>
                <div class="viewCate d-flex gap-2">
                  <p><?php echo $cateArray[0] ?></p>
                  <span>></span>
                  <p><?php echo $cateArray[1] ?></p>
                  <span>></span>
                  <p><?php echo $cateArray[2] ?></p>
                </div>
              </div>
              <p class="content_tt"><?php echo $rowcourse['name'] ?></p>
            </div>
            <div>
              <i class="ti ti-calendar-event"></i>
              <span>수강기간 <?php echo $rowcourse['due'] ?></span>
              <div><span class="main_stt number"><?php echo $rowcourse['price'] ?></span><span>원</span></div>
            </div>
          </div>
        </div>
        <div class="pd_3">
          <p class="content_stt fw-bold">강의소개</p>
          <p>
          <?php echo $rowcourse['content'] ?>
          </p>
        </div>
      </div>
      <div class="viewWrap_1">
        <h2 class="jua pd_2">강의목록</h2>
        <div class="viewSection2 shadow_box">
          <?php
          foreach($rs as $list){
            $progressText = ($list->progress == 0) ? '강의시작' : (($list->progress == 100) ? '강의완료' : '강의중');
          ?>
          <div
            class="viewList d-flex justify-content-between align-items-center"
          >
            <div class="d-flex align-items-center">
              <div class="viewImg">
                <img src="<?php echo $list->youtube_thumb ?>" alt="" />
              </div>
              <span><?php echo $list->youtube_name ?></span>
            </div>
            <div class="d-flex gap-5 align-items-center">
              <div class="d-flex gap-1">
                <span>진행률: </span>
                <span><?php echo $list->progress ?> %</span>
                <span>/</span>
                <span><?php echo $progressText; ?></span>
              </div>
              <a target="_blank" href="<?php echo $list->youtube_url ?>"><i class="fa-regular fa-circle-play"></i></a>
            </div>
          </div>

          <?php
          }
          ?>
       
         
        </div>
      </div>
    </section>
    </div>
    </main>
    <?php

include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/user/inc/footer.php';
?>

