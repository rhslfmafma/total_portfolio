<?php
$title = "공지사항";
$css_route = "notice/css/notice.css";
$js_route = "notice/js/notice.js";

include_once $_SERVER['DOCUMENT_ROOT'] . '/pudding-LMS-website/admin/inc/header.php';

$search_where = '';

$search_keyword = $_GET['keyword']??'';
$sales_page='';

if(isset($_GET['keyword'])) {
  //제목과 내용에 키워드가 포함된 상품 조회
  $keyword = $_GET['keyword'];
  $search_where = " and (nt_title like '%{$keyword}%' or 
  nt_content like '%{$keyword}%')";

  $sqlaa = "SELECT COUNT(*) as count FROM notice WHERE (nt_title like '%{$keyword}%' or nt_content like '%{$keyword}%')";
  $result = $mysqli->query($sqlaa);
  while ($rs = $result->fetch_object()) {
    $rscaa[] = $rs;
  }
  $sales_page = $rscaa[0]->count;
}


$sql = "SELECT * from notice where 1=1";
$order = " order by ntid desc";

if(!isset($pagerwhere)){
  $pagerwhere = ' 1=1';
}

$pagenationTarget = 'notice';
$pageContentcount = 10; 
include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/admin/inc/pager.php';
$limit = " limit $startLimit, $pageCount"; 

$sqlrc = $sql.$search_where.$order.$limit; 



$result = $mysqli -> query($sqlrc);
while($rs = $result -> fetch_object()){
  $rsc[] = $rs;

} 
?>
<section>
    <h2 class="main_tt">공지사항</h2>
    <div class="notice_top shadow_box border d-flex justify-content-between">
      <form class="notice_top_left d-flex align-items-center" action="#" method="get">
      <input type="text" class="input form-control" id="searchInput" placeholder="제목 + 내용 검색" aria-label="Search"
         name="keyword">
        <button class="btn btn-dark" id="searchInput2">검색</button>              
      </form>
      <div class="d-flex align-items-center">
        <a class="btn btn-dark" href="notice_create.php">게시물 등록</a>              
      </div>
    </div>     
    <table class="notice_body table shadow_box border">
      <colgroup>  
      <col class="col2">
      <col class="col3">
        <col class="col4">
        <col class="col5">
      </colgroup>
        <thead class="thead-dark">
          <tr>
          <th scope="col" class="no_mp ">
              <span>제목</span>
            </th>
            <th scope="col" class="no_mp ">
              <span>일자</span>
            </th>
            <th scope="col" class="no_mp ">
              <span>조회수</span>
            </th>
            <th scope="col" class="no_mp ">
              <span>편집</span>
            </th>
          </tr>
        </thead>
        <tbody>          
          <?php
            if(isset($rsc)){
              foreach($rsc as $item){            
            ?>
            <tr data-prt="<?=$item -> ntid;?>" class="prt">
            <td class="no_mp title">
              <a href="notice_view.php?ntid=<?=$item -> ntid;?>">
                <?= $item -> nt_title; ?>
              </a>
            </td>
            <td class="no_mp">
              <?= date('Y-m-d', strtotime($item -> nt_regdate)) ;?>
            </td>
            <td class="no_mp">
            <?= $item -> nt_read_cnt;?>
            </td>
            <td>
              <div class="icon_group">
                <a href="notice_update.php?ntid=<?=$item -> ntid;?>"><i class="ti ti-edit pen_icon"></i></a>
                <a href="#"><i class="ti ti-trash bin_icon del_btn"></i></a>
              </div>
            </td>
          </tr>                 
          <?php
          }
        } else {
          ?>
            <tr><td colspan="5">검색 결과가 없습니다</td></tr>
          <?php
        } ?>
        </tbody>
      </table>
 <nav aria-label="Page navigation example" class="d-flex justify-content-center pager">
      <ul class="pagination coupon_pager">
        <?php
          if($pageNumber>1 && $block_num > 1 ){
            $prev = ($block_num - 2) * $block_ct + 1;
            echo "<li class=\"page-item\"><a href=\"?pageNumber=$prev\" class=\"page-link\" aria-label=\"Previous\"><span aria-hidden=\"true\">&lsaquo;</span></a></li>";
          } else{
            echo "<li class=\"page-item disabled\"><a href=\"\" class=\"page-link\" aria-label=\"Previous\"><span aria-hidden=\"true\">&lsaquo;</span></a></li>";
          }


          for($i=$block_start;$i<=$block_end;$i++){
            if($pageNumber == $i){
                echo "<li class=\"page-item active\"><a href=\"?keyword=$search_keyword&pageNumber=$i\" class=\"page-link\" data-page=\"$i\">$i</a></li>";
            }else{
                echo "<li class=\"page-item\"><a href=\"?keyword=$search_keyword&pageNumber=$i\" class=\"page-link\" data-page=\"$i\">$i</a></li>";
            }
          }


          if($pageNumber<$total_page && $block_num < $total_block){
            $next = $block_num * $block_ct + 1;
            echo "<li class=\"page-item\"><a href=\"?pageNumber=$next\" class=\"page-link\" aria-label=\"Next\"><span aria-hidden=\"true\">&rsaquo;</span></a></li>";
          } else{
            echo "<li class=\"page-item disabled\"><a href=\"?pageNumber=$total_page\" class=\"page-link\" aria-label=\"Next\"><span aria-hidden=\"true\">&rsaquo;</span></a></li>";

          }
        ?>
      </ul>
    </nav>
  </section>  
</div>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pudding-LMS-website/admin/inc/footer.php';
?>