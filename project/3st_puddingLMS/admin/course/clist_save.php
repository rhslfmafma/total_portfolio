<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/pudding-LMS-website/admin/inc/dbcon.php';


$cid = $_REQUEST['cid'];
$act = $_REQUEST['act'] ?? [];

foreach ($cid as $c) {
  $act[$c] = $act[$c] ?? 0;

  $query = "UPDATE courses SET act='{$act[$c]}' where cid=" . $c;

  $result = $mysqli->query($query) or die($mysqli->error);
}
if ($result) {
  echo "<script>
      alert('일괄 수정 되었습니다.');
      history.back();
    </script>";
} else {
  echo "<script>
      alert('일괄 수정 실패!');
      history.back();
    </script>";
}

?>