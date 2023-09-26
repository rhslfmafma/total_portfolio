<?php
// session_start();
$title="마이페이지 - 내 강의실";
$css_route="mypage/css/mypage.css";
$js_route = "mypage/js/mypage.js";
  include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/user/inc/header.php';

  if(isset($_SESSION['UID'])) {
    $userid = $_SESSION['UID'];

    $sql = "SELECT * FROM users WHERE userid='{$userid}'";

    $result = $mysqli->query($sql);
    while ($rrow = $result->fetch_object()) {
      $user[] = $rrow;
    }

  //내강의실
  $useridlec = $rs->userid;
  $sqllec = "SELECT c.*, p.*
                FROM payments p 
                INNER JOIN courses c ON p.cid = c.cid 
                WHERE p.userid='{$useridlec}'";
  
    $resultlec = $mysqli->query($sqllec);
    while ($row = $resultlec->fetch_object()) {
      $courses[] = $row;
    }

  }else{
    echo "<script>alert('로그인이 필요합니다.');
    location.href = '/pudding-LMS-website/user/members/login.php';
    </script>";
  }
  




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
    <section class="content_wrap">
      <h2 class="hidden">내 프로필</h2>
      <?php
      if(isset($user)){
        foreach($user as $u){

          $currentDate= new DateTime();

          $regDate = new DateTime($u->regdate);
      
          //현재날짜 - 가입날짜
          $dateDiff = $currentDate->diff($regDate);
          $daysSinceRegistration = $dateDiff->days;
      
      ?>
      <h2 class="jua main_tt"><?php echo $u->username ?>님 안녕하세요!</h2>
      <div class="d-flex profile_box_wrap">
        <div class="d-flex profile_box radius_5">
          <img src="<?php 
          if($u->userimg == ''){
            echo "/pudding-LMS-website/user/images/profile/default_profile.png";
          }else{
            echo $u->userimg;
          }
          ?>" alt="프로필이미지">
          <div>
            <h6 class="b_text02"><?php echo $u->username ?></h6>
            <h6 class="b_text02"><?php echo $u->useremail ?></h6>
          </div>
          <a href="#"><i class="ti ti-settings"></i></a>
        </div>

        <div
          class="d-flex justify-content-center align-items-center pudding_box radius_5"
        >
          <h6 class="content_tt d-flex align-items-center">
            푸딩과 함께 <span><?php echo $daysSinceRegistration ?></span>일째 달리는 중!<i
              class="ti ti-flame"
            ></i>
          </h6>
        </div>
      </div>
      <?php    
        }
      }
      ?>
     
    </section>
    <section class="course_wrap">
      <h2 class="jua main_tt">내 강의실</h2>
      <ul>
        <?php
               if (!empty($courses)) {
        foreach($courses as $c){
        ?>
        <li class="course_list row shadow_box">
          <input type="hidden" name="cid[]" value="" />
          <div class="col-md-9 d-flex">
            <img
              src="<?php echo $c->thumbnail ?>"
              alt="강의 썸네일 이미지"
              class="border"
            />
            <div class="course_info">
              <div>
                <h3 class="course_list_title b_text01">
                  <a href=""><?php echo $c->name ?></a>
                  <span class="badge level_badge green_bg rounded-pill b-pd"
                    ><?php echo $c->level ?></span
                  >
                  <span class="badge rounded-pill blue_bg b-pd">
                    프론트엔드
                  </span>
                </h3>
                <p>
                <?php echo $c->content ?>
                </p>
              </div>
              <p class="duration">
                <i class="ti ti-calendar-event"></i><span>수강기간</span>
                <span>|</span><span><?php echo $c->due ?></span>
              </p>
            </div>
          </div>
          <div class="col-md-3 d-flex justify-content-end align-items-end">
            <a href="/pudding-LMS-website/user/mypage/mycourse.php?cid=<?php echo $c->cid ?>" class="btn btn-dark">강의보기</a>
            
          </div>
        </li>
        <?php
        }
        }else {
          echo '<li><p>강의실에 등록된 강의가 없습니다.</p></li>';
      }
    
        
        ?>
      
      </ul>
    </section>
    </div>
    </main>
    <?php

include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/user/inc/footer.php';
?>

