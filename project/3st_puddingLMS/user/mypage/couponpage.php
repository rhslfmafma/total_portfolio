<?php
$title="마이페이지 - 쿠폰함";
$css_route="mypage/css/mypage.css";
$js_route = "mypage/js/mypage.js";
include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/user/inc/header.php';

$cps = [];

if(isset($_SESSION['UID'])){
    $userid = $_SESSION['UID'];
    $sql = "SELECT uc.*, cp.* FROM user_coupon uc 
    JOIN coupons cp ON uc.cpid = cp.cpid 
    WHERE uc.userid = '{$userid}' AND (uc.use_max_date > NOW() OR uc.use_max_date) AND uc.uc_status = 1
    ORDER BY uc.ucid DESC";
    $sc_where = "";

    $result = $mysqli->query($sql);
    
    if ($result) {
        while($rs = $result->fetch_object()){
            $cps[] = $rs;
        }
    } else {
        die("SQL 오류: " . $mysqli->error);
    }

    // 사용가능한 쿠폰수
    $couponCount = count($cps);

    // 만료임박 쿠폰
    $expirecps = [];
    $expirecpsdate = strtotime('+7 days');
    foreach ($cps as $cp) {
        $useMaxDatecp = strtotime($cp->use_max_date);
        if ($useMaxDatecp <= $expirecpsdate) {
            $expirecps[] = $cp;
        }
    }

    // 만료쿠폰 수
    $expirecouponcount = count($expirecps);

    $a = [];

    $filter_where = "";
    $cp_filter = $_GET['coupon_filter'] ?? '';

    if($cp_filter == '1'){
        // 모든 쿠폰 보여주기
        $a = $expirecps;
    } else {
        
        $a = $cps;
    }

} else {
    echo "<script>alert('로그인이 필요합니다.'); history.back();</script>";
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
      <h2 class="jua main_tt">쿠폰함</h2>
      <span class="coupon_sub"> * 구매시 쿠폰을 사용할 수 있습니다.</span>
      <form action="#" class="d-flex justify-content-between conpon_box coupon_filter">
        <div class="d-flex flex-column coupon_box_able radius_5">
            <div class="able d-flex">
                <i class="ti ti-circle-check"></i>
                <h6>사용가능한 쿠폰</h6>
            </div>
            <div class="able d-flex justify-content-end align-items-center">
              
                <label for="all" class="d-flex align-items-center c_count"><span><?= $couponCount ?></span> <span>개</span></label>
                <input type="radio" value="0" class="hidden" id="all" name="coupon_filter">
            </div>
        </div>

        <div class="d-flex flex-column coupon_box_able radius_5">
            <div class="able d-flex">
                <i class="ti ti-alarm"></i>
                <h6>만료임박 쿠폰</h6>
            </div>
            <div class="able d-flex justify-content-end align-items-center">

                <label for="end" class="d-flex align-items-center c_count"><span><?= $expirecouponcount ?></span> <span>개</span></label>
                <input type="radio" value="1" class="hidden" id="end" name="coupon_filter">
            </div>
        </div>
        <button  class="hidden">쿠폰</button>
      </form><!--coupon_filter-->
    </section>
    <section class="content_wrap_cp">
      <div class="coupons">
        <h2 class="hidden">쿠폰리스트</h2>
        <ul class="d-flex flex-wrap justify-content-between g-5">
        <?php
        if(isset($a) &&(count($a) > 0)){
          foreach($a as $cp){

        ?> 
        
        <li class="coupon shadow_box radius_5 white_bg d-flex">
            <img
              src="<?php echo $cp->cp_image ?>"
              alt=""
              class="radius_5"
            />
            <div class="text_box">
              <h3 class="b_text01"><?php echo $cp->cp_name ?></h3>
              <p>사용기한 : <?php echo date('Y-m-d', strtotime($cp->use_max_date)); ?></p>
              <p >최소사용금액 : <span class="number"> <?php echo $cp->cp_limit ?></span> 원</p>
              <?php
                if ($cp->cp_type === '정률') {
                    echo '<p>할인율 : ' . $cp->cp_ratio . '%</p>';
                }
                elseif ($cp->cp_type === '정액') {
                    echo '<p>할인액 : <span class="number">' . $cp->cp_price . '</span> 원</p>';
                }
                ?>
            </div>
          </li>

          <?php
              }
             }else{
              echo '<li><p>쿠폰이 없습니다.</p></li>';
             }
          ?>
         
        </ul>
      </div>
    </section>

    </div>
    </main>

  <script>
    $("form").change(function(){
      $(this).find('button').trigger("click");
    });
  </script>

    <?php

include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/user/inc/footer.php';
?>

