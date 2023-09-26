<?php
$title = "공지사항 게시물";
$css_route = "notice/css/notice.css";
$js_route = "notice/js/notice.js";
include_once $_SERVER['DOCUMENT_ROOT'] . '/pudding-LMS-website/admin/inc/header.php';

$ntid = $_GET['ntid'];

// $sql = "UPDATE notice SET nt_read_cnt = nt_read_cnt +1  WHERE ntid='{$ntid}'";
// $result = $mysqli -> query($sql);

$sql2 = "SELECT * FROM notice WHERE ntid='{$ntid}'";
$result2 = $mysqli->query($sql2);
$sqlarr = $result2 -> fetch_assoc();
// $hit = $sqlarr['nt_read_cnt'] +1 ;
?>
  <section>
          <div class="view_box">
            <h2 class="main_tt">공지사항</h2>
            <div class="notice_view_notice_body shadow_box border justify-content-between">
              <h5 class="main_stt thead_tt"> <?= $sqlarr['nt_title'];?></h5>
              <p class="notice_info d-flex justify-content-end align-items-center">
              <span class="b_text02">작성일</span>
                <span class="b_text02"> <?= $sqlarr['nt_regdate']?></span>
                <span class="b_text02">조회수</span>
                <span class="b_text02"> <?= $sqlarr['nt_read_cnt'] ?></span>
              </p>
            <div class="content">

              
              <?= $sqlarr['nt_content'] ?>
            </div>
          </div>   
          <div class="notice_view_btns d-flex justify-content-end prt" data-prt="<?= $sqlarr['ntid'] ?>">
            <a href="notice_update.php?ntid=<?= $ntid; ?>" class="btn_modify btn btn-primary">수정</a>
            <a href="#" class="btn_delete btn btn-danger del_btn">삭제</a>     
            <a href="notice_list.php" class="btn_cancel btn btn-dark">목록 보기</a>
          </div>
          </div>
        </section> 
        </div><!-- //content_wrap -->
</div><!-- //wrap -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/admin/inc/footer.php';
?>