<?php
session_start();
$rest_api_key = "";       
$redirect_uri = "http://localhost/pudding-LMS-website/user/members/kakao_oauth.php";  // Redirect URI
$code = $_GET['code'];

include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/admin/inc/dbcon.php';


// 사용자 토큰 받기
$token_data = array(
    'grant_type' => 'authorization_code',
    'client_id' => $rest_api_key,
    'redirect_uri' => $redirect_uri,
    'code' => $code,
);

$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($token_data),
    ),
);

$context = stream_context_create($options);
$token_json = file_get_contents('https://kauth.kakao.com/oauth/token', false, $context);
$token_data = json_decode($token_json, true);

// var_dump($token_data);

// 토큰 발급 실패
if (!$token_data['access_token']) {
    die("카카오 로그인에 실패했습니다. 다시 시도해 주세요.");
}

// 사용자 정보 받기
$user_info_url = 'https://kapi.kakao.com/v2/user/me';
$user_info_options = array(
    'http' => array(
        'header' => "Authorization: Bearer {$token_data['access_token']}\r\n",
        'method' => 'POST',
    ),
);

$user_info_context = stream_context_create($user_info_options);
$user_info_json = file_get_contents($user_info_url, false, $user_info_context);
$user_info = json_decode($user_info_json, true);


// 카카오 API로부터 가져온 사용자 정보
$userid = $user_info['id'];
$username = $user_info['properties']['nickname'];
$userimg = $user_info['properties']['profile_image'];

// 사용자 정보가 이미 데이터베이스에 존재하는지 확인
$existing_user_query = "SELECT userid FROM users WHERE userid = '$userid'";
$existing_user_result = $mysqli->query($existing_user_query);

if ($existing_user_result->num_rows > 0) {
        $_SESSION['UID'] = $userid;
        $_SESSION['UNAME'] = $username;
        echo "<script>alert('로그인성공!');
         location.href = '/pudding-LMS-website/user/index.php';
            
            </script>";
    

} else {
    // 사용자 정보를 users 테이블에 저장
    $insert_query = "INSERT INTO users (userid, username, userimg) VALUES ('$userid', '$username','$userimg')";
    
    if ($mysqli->query($insert_query) === TRUE) {
    $_SESSION['UID'] = $userid;
    $_SESSION['UNAME'] = $username;
    echo "<script>alert('로그인성공!');
        location.href = '/pudding-LMS-website/user/index.php';
        
        </script>";



        
    } else {
        echo "오류: " . $insert_query . "<br>" . $mysqli->error;
    }
}




$mysqli->close();

?>