<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/admin/inc/dbcon.php');

$rid = $_GET["rid"];
$userid=$_POST['userid'];
$cid=$_POST['cid'];



$content =$_POST["reply_update"];
$date = date("Y-m-d");
$sql = "UPDATE review_reply SET r_content='{$content}',r_regdate='{$date}' WHERE rid='{$rid}'";


if ($mysqli->query($sql) === TRUE) {
    echo "<script>
    alert('댓글쓰기 수정완료되었습니다.');
    location.href='/pudding-LMS-website/admin/review/review_reply_view.php?rid={$rid}&userid={$userid}&cid={$cid}';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>