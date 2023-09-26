<?php
  session_start();
  include_once $_SERVER['DOCUMENT_ROOT'].'/pudding-LMS-website/admin/inc/dbcon.php';



  $mysqli->autocommit(FALSE);//커밋이 안되도록 지정, 일단 바로 저장하지 못하도록
  try{
    
    $cate1 =  $_POST['cate1']??'' ;
    $cate2 =  $_POST['cate2']??'' ;
    $cate3 =  $_POST['cate3']??'' ;


  

    $query11 = "SELECT name FROM category WHERE cateid='".$cate1." '";
    $result11 = $mysqli->query($query11); //쿼리실행결과를 $result 할당
    $rs11 = $result11->fetch_object();
    $cate1 =  $rs11-> name;

    $query22 = "SELECT name FROM category WHERE cateid='".$cate2." '";
    $result22 = $mysqli->query($query22); //쿼리실행결과를 $result 할당
    $rs22 = $result22->fetch_object();
    $cate2 =  $rs22->name;

    $query33 = "SELECT name FROM category WHERE cateid='".$cate3." '";
    $result33 = $mysqli->query($query33); //쿼리실행결과를 $result 할당
    $rs33 = $result33->fetch_object();
    $cate3 =  $rs33->name;

    

    $cid=$_POST['cid'];
    $cate = $cate1.'/'.$cate2.'/'.$cate3;
 

    $name = $_POST['name'];
    $price_status = $_POST['price_status'];
    $price = $_POST['price']??0;
    $level = $_POST['level']??0;
    $due_status = $_POST['due_status'];
    $due = $_POST['due']??'무제한';
    $act = $_POST['act'];
    $content = rawurldecode($_POST['content']);
    $youtube_name = $_POST['youtube_name']?? '';

    if($_FILES['thumbnail']['name']){

        if($_FILES['thumbnail']['size']> 10240000){
          echo "<script>
            alert('10MB 이하만 첨부할 수 있습니다.');    
            history.back();      
          </script>";
          exit;
        }

        if(strpos($_FILES['thumbnail']['type'], 'image') === false){
          echo "<script>
            alert('이미지만 첨부할 수 있습니다.');    
            history.back();            
          </script>";
          exit;
        }

        $save_dir = $_SERVER['DOCUMENT_ROOT']."/pudding-LMS-website/admin/images/course/";
        $filename = $_FILES['thumbnail']['name']; 
        $ext = pathinfo($filename, PATHINFO_EXTENSION); 
        $newfilename = date("YmdHis").substr(rand(), 0,6);
        $thumbnail = $newfilename.".".$ext;

        if(move_uploaded_file($_FILES['thumbnail']['tmp_name'], $save_dir.$thumbnail)){  
          $thumbnail = "/pudding-LMS-website/admin/images/course/".$thumbnail;
        } else{
          echo "<script>
            alert('이미지등록 실패!');    
            history.back();            
          </script>";
        }
    }

    if(($_FILES['thumbnail']['name'])){

      $sql = "UPDATE courses
              SET cate='{$cate}',
                  name='{$name}', 
                  price='{$price}', 
                  price_status='{$price_status}', 
                  level='{$level}',
                  due='{$due}',
                  due_status='{$due_status}', 
                  act='{$act}', 
                  content='{$content}', 
                  thumbnail = '{$thumbnail}'
              WHERE cid = {$cid}";
      }else{
      $sql = "UPDATE courses
              SET cate='{$cate}',
                  name='{$name}', 
                  price='{$price}', 
                  price_status='{$price_status}', 
                  level='{$level}', 
                  due='{$due}',
                  due_status='{$due_status}', 
                  act='{$act}', 
                  content='{$content}'
              WHERE cid = {$cid} ";
  };

    $result = $mysqli->query($sql);

      if(isset($_FILES['youtube_thumb'])){


        $upload_youtube_thumb = [];


        for($i = 0;$i<count($_FILES['youtube_thumb']['name']) ; $i++){



            if($_FILES['youtube_thumb']['size'][$i]> 10240000){
              echo "<script>
                alert('10MB 이하만 첨부할 수 있습니다.');    
                //history.back();      
              </script>";
              exit;
            }
        
            if(strpos($_FILES['youtube_thumb']['type'][$i], 'image') === false){
              echo "<script>
                //alert('이미지만 첨부할 수 있습니다.');
                //history.back();            
              </script>";
              exit;
            }
        
            $save_dir = $_SERVER['DOCUMENT_ROOT']."/pudding-LMS-website/admin/images/course/";

            if(strlen($_FILES['youtube_thumb']['name'][$i])>0){

              $filename = $_FILES['youtube_thumb']['name'][$i]; 
              $ext = pathinfo($filename, PATHINFO_EXTENSION); 
              $newfilename = date("YmdHis").substr(rand(), 0,6); 
              $youtube_thumb = $newfilename.".".$ext; 
  
              if(move_uploaded_file($_FILES['youtube_thumb']['tmp_name'][$i], $save_dir.$youtube_thumb)){  
                $upload_youtube_thumb[] = "/pudding-LMS-website/admin/images/course/".$youtube_thumb;
              } else{
                echo "<script>
                 // alert('이미지등록 실패!');    
                  //history.back();            
                </script>";
              }
            }


   
          var_dump($_FILES['youtube_thumb']['name'][$i]);
          var_dump($upload_youtube_thumb);
        }
        
      }


      
      
      for($i = 0; $i<count($_FILES['youtube_thumb']); $i++){

        if(isset($_FILES['youtube_thumb']['name'][$i])){
          $sql1 = "UPDATE lecture
                  SET youtube_thumb = '{$upload_youtube_thumb[$i]}',
                      youtube_name = '{$youtube_name[$i]}',
                      youtube_url = '{$youtube_url[$i]}'
                  WHERE cid ={$cid}
                  AND l_idx = {$i}";
        }else{
          $sql1 = "UPDATE lecture
                  SET youtube_name = '{$youtube_name[$i]}',
                      youtube_url = '{$youtube_url[$i]}'  
                  WHERE cid ={$cid}
                  AND l_idx = {$i}";
        }
       
        
        $result2 = $mysqli-> query($sql1);
      }
      if (isset($_POST['delete_youtube'])) {
        $deleteYouTubeIndexes = $_POST['delete_youtube'];
        foreach ($deleteYouTubeIndexes as $deleteIdx) {
        $deleteSql = "DELETE FROM lecture WHERE cid = {$cid} AND l_idx = {$deleteIdx}";
        $deleteResult = $mysqli->query($deleteSql);
        }
      }

      $mysqli->commit();//디비에 커밋한다.

      echo "<script>
      alert('강의 수정 완료!');
      //location.href='course_list.php';</script>";
    }

    catch(Exception $e){
      $mysqli->rollback();//저장한 테이블이 있다면 롤백한다.
      echo "<script>
      alert('강의 수정 실패');
      //history.back();
      </script>";
      exit;
    }
?>