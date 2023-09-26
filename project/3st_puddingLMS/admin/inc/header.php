<?php
  session_start(); 
  include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/admin/inc/dbcon.php';
?>

<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="apple-touch-icon" sizes="57x57" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/favicon-16x16.png">
    <link rel="manifest" href="/pudding-LMS-website/admin/images/pudding_favicon.ico/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <title><?php if(isset($title)){echo $title;} else { echo 'home';}; ?> - PUDDING</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- reset css -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"
      integrity="sha512-NmLkDIU1C/C88wi324HBc+S2kLhi08PN5GDeUVVVC/BVt/9Izdsc9SVeVfA1UZbY3sHUlDSyRXhCzHfr6hmPPw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    >
    <!-- normalize css -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
      integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    >

    <!--bootstrap css -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css"
      integrity="sha512-Z/def5z5u2aR89OuzYcxmDJ0Bnd5V1cKqBEbvLOiUNWdg9PQeXVvXLI90SE4QOHGlfLqUnDNVAYyZi8UwUTmWQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    >
    <!-- tabler-icons  -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"
    >

    <!-- jquery ui css -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/black-tie/jquery-ui.min.css"
      integrity="sha512-+Z63RrG0zPf5kR9rHp9NlTMM29nxf02r1tkbfwTRGaHir2Bsh4u8A79PiUKkJq5V5QdugkL+KPfISvl67adC+Q=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    >
    <!-- summernote css -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css"
      integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    >
    <!-- 스포카 -->
    <link
      href="//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSansNeo.css"
      rel="stylesheet"
      type="text/css"
    >

    <link rel="stylesheet" href="/pudding-LMS-website/admin/css/jqueryui/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="/pudding-LMS-website/admin/css/common.css">
    <link rel="stylesheet" href="/pudding-LMS-website/admin/<?php if(isset($css_route)){echo $css_route;} else { echo 'css/index.css';}; ?>">
        
    <!-- jquery js-->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
      integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <!-- chart js -->
    
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/admin/inc/admin_check.php';
  ?>


    </head>
  <body>
    <div class="wrap">
      <header>
        <div
          class="inner_header content_tt d-flex justify-content-between align-items-center flex-column"
        >
          <h1 class="adminlogo"><a href="/pudding-LMS-website/admin/index.php">로고</a></h1>
          <nav>
            <ul class="d-flex justify-content-between flex-column">
              <li>
                <a href="/pudding-LMS-website/admin/index.php" class="icon"
                  ><i class="ti ti-home"></i><span>대시보드</span></a
                >
              </li>
              <li>
                <a href="/pudding-LMS-website/admin/course/course_list.php" class="icon"
                  ><i class="ti ti-chalkboard"></i><span>강의 관리</span></a
                >
              </li>
              <li>
                <a href="/pudding-LMS-website/admin/sales/sales_list.php" class="icon"
                  ><i class="ti ti-coins"></i><span>매출 관리</span></a
                >
              </li>
              <li>
                <a href="/pudding-LMS-website/admin/coupon/coupon_list.php" class="icon"
                  ><i class="ti ti-ticket"></i><span>쿠폰 관리</span></a
                >
              </li>
              <li>
                <a href="/pudding-LMS-website/admin/review/review_list.php" class="icon"
                  ><i class="ti ti-brand-hipchat"></i
                  ><span>수강평 관리</span></a
                >
              </li>
              <li>
                <a href="/pudding-LMS-website/admin/notice/notice_list.php" class="icon"
                  ><i class="ti ti-clipboard-text"></i><span>공지사항</span></a
                >
              </li>
              <li>
                <a href="/pudding-LMS-website/admin/qna/qna_list.php" class="icon"
                  ><i class="ti ti-zoom-question"></i><span>Q&A</span></a
                >
              </li>
              <li>
                <a href="/pudding-LMS-website/admin/users/users_list.php" class="icon"
                  ><i class="ti ti-user-edit"></i><span>회원 관리</span></a
                >
              </li>
            </ul>
          </nav>
          <a href="/pudding-LMS-website/admin/logout.php" class="logout b_text02 btn btn-primary" style="line-height:45px">로그아웃</a>
        </div>
      </header>

      <div class="content_wrap">
        <div class="top_bar d-flex justify-content-end align-items-center">
          <div class="red_bell_wrap" title="Q&A로 이동">
            <a href="/pudding-LMS-website/admin/qna/qna_list.php">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="icon icon-tabler icon-tabler-bell-filled"
                width="58"
                height="58"
                viewBox="0 0 28 28"
                stroke-width="2"
                stroke="currentColor"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path
                  d="M14.235 19c.865 0 1.322 1.024 .745 1.668a3.992 3.992 0 0 1 -2.98 1.332a3.992 3.992 0 0 1 -2.98 -1.332c-.552 -.616 -.158 -1.579 .634 -1.661l.11 -.006h4.471z"
                  stroke-width="0"
                  fill="currentColor"
                ></path>
                <path
                  d="M12 2c1.358 0 2.506 .903 2.875 2.141l.046 .171l.008 .043a8.013 8.013 0 0 1 4.024 6.069l.028 .287l.019 .289v2.931l.021 .136a3 3 0 0 0 1.143 1.847l.167 .117l.162 .099c.86 .487 .56 1.766 -.377 1.864l-.116 .006h-16c-1.028 0 -1.387 -1.364 -.493 -1.87a3 3 0 0 0 1.472 -2.063l.021 -.143l.001 -2.97a8 8 0 0 1 3.821 -6.454l.248 -.146l.01 -.043a3.003 3.003 0 0 1 2.562 -2.29l.182 -.017l.176 -.004z"
                  stroke-width="0"
                  fill="currentColor"
                ></path>
              </svg>
            </a>
            <div class="red_bell d-flex justify-content-center align-items-center">0</div>
          </div>
          <div class="profile d-flex align-items-center">
            <img src="/pudding-LMS-website/admin/images/profile_img.png" alt="">
            <h2 class="b_text02 bold">프바오<span>admins</span></h2>
          </div>
        </div>
