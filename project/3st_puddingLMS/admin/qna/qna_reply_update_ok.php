<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pudding-LMS-website/admin/inc/dbcon.php';

$comment_id = $_POST['comment_id'];
$comment = $_POST['comment'];

$sql = "UPDATE qna_comments SET comment = ? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('si', $comment, $comment_id);
$result = $stmt->execute();

if ($result) {
  echo 'success';
} else {
  echo 'fail';
}
?>