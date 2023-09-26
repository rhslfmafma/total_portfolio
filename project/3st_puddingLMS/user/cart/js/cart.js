
let all_check = $('.all_check');
let select_del = $('.select_del');
let discount = 0;//쿠폰금액변수



cartInfo();

//결제정보
function cartInfo(){
  let cart_item = $('.cart_item_container .cart_item');
  let cart_item_checked = cart_item.find('input:checked');



  //모든 아이템이 체크가 되면 전체선택에 checked
  if(cart_item.length === cart_item_checked.length){
    all_check.find('input').prop('checked',true);
  } else{
    all_check.find('input').prop('checked',false);
  }

  //상품 전체 개수
  $('.all_count').text(cart_item.length);


  //선택 상품개수
  $('.cart_count,.select_count').text(cart_item_checked.length);
  
  //상품금액
  let total_price = 0;
  cart_item_checked.each(function(){
    let target_pr = $(this).parent().find('.price span').text().replace(',','');
    total_price+=Number(target_pr);
  });
  $('.cart_total_price').text(total_price);
  $('.cart_total_price').number(true);

  //전체금액 계산
  $('.cart_pay_price').text(total_price);
  $('.cart_pay_price').number(true);
  return total_price;

} //cartInfo function


function couponPrice(total_price){

  //쿠폰선택
    let target = $('.coupon_select').find('option:selected');
    let limit;
    // if(!target.hasClass('default')){
    //   limit = Number(target.attr('data-limit'));
    // } else {
      //   return;
      // }
        limit = Number(target.attr('data-limit'));
    console.log(target);
    console.log(limit);
    // limit = Number(target.attr('data-limit'));

    //쿠폰의 최소사용금액
    if(Number(total_price) > limit){
      let type = target.attr('data-type');
      //쿠폰타입
      if(type == '정액'){
        $('.cart_discount').text(target.attr('data-discount'));
        $('.discount_unit').text("원");
        discount = Number(target.attr('data-discount'));
      }
      if(type == '정률'){
        let perc = target.attr('data-discount');
        $('.cart_discount').text(perc/100*total_price);
        $('.discount_unit').text(`원(${perc}%)`);
        discount = perc/100*total_price;
      }
      $('.cart_discount').number(true);
    } else{
      alert('쿠폰 최소사용금액을 확인해주세요.');
      location.reload();
    }

    //총 결제금액(쿠폰선택 후)
    if(!discount == 0){
      $('.cart_pay_price').text(total_price-discount);
      $('.cart_pay_price').number(true);
    }
} //couponPrice function

function canUdel(target){
  if(target.length > 0){
    if(confirm('정말로 삭제하시겠습니까?')){
      // target.remove();
      let cartid = [];
      //target 여러개일 경우, carid를 배열에 담기
      target.each(function(){
        cartid.push($(this).attr('data-cartid'));
      });
      let data = {
        cartid : cartid
      }
      $.ajax({
        async : false, 
        type: 'post',     
        data: data, 
        url: "cart_del.php", 
        dataType: 'json', //결과 json 객체형식
        error: function(error){
          console.log('Error:', error);
        },
        success: function(return_data){
          // location.reload();
          target.remove();
          alert('삭제되었습니다.');
          let cnt = $('.cart_item_container .cart_item').length;
          if(cnt == 0){
            $('.cart_item_container').html(
              `<li class="no_cart_container">
                <img src="images/cart_2.png" alt="장바구니가 비어있어서 슬픈 푸딩 이미지" class="no_cart_img">
                <p class="content_stt">장바구니에 담긴 강의가 없습니다.</p>
                <a href="/pudding-LMS-website/user/index.php" class="btn btn-primary dark">홈으로이동</a>
              </li>`
            );
            $('.cart_btn span').text(cnt);
          } else{
            $('.cart_btn span').text(cnt);
          }
        }
      });//ajax
    } else{
      alert('삭제를 취소하였습니다.');
    }
  } else{
    alert('삭제할 상품을 선택해주세요');
  }
} //canUdel function


//쿠폰선택 시
$('.coupon_select').change(function(){
  couponPrice(cartInfo());
});

//아이템 체크박스 change
$('.cart_item_container').change(function(){
  cartInfo();
  couponPrice(cartInfo());
});


//전체선택 체크(전체선택) / 해제(전체해제)
all_check.change(function(){
  let cart_item = $('.cart_item_container .cart_item');
  //전체선택
  if($(this).find('input').prop('checked')){
    cart_item.find('input').prop('checked',true);
  } else{
    cart_item.find('input').prop('checked',false);
  }
  cartInfo();
});


//선택삭제 클릭 시 선택된 아이템 삭제
select_del.click(function(){
  let cart_item = $('.cart_item_container .cart_item');
  canUdel(cart_item.find('input:checked').parent());
  cartInfo();
});


//각 item 속 del_btn 클릭 시 해당 아이템 삭제
$('.del_btn').click(function(){
  canUdel($(this).parent());
  cartInfo();
});



//결제하기 클릭
$('.payment_form').submit(function(e){
  e.preventDefault();

  if($('.cart_item_container .cart_item').find('input:checked').length>0){

    let total_price = Number($('.cart_total_price').text().replace(',',''));
  
    let discount_price = Number($('.cart_pay_price').text().replace(',',''));
    console.log(discount_price);
  
    let select_item = $('.cart_item_container .cart_item').find('input:checked').parent();
    let cart_id = [];
    select_item.each(function(){
      cart_id.push(Number($(this).attr('data-cartid')));
    });
    console.log(cart_id);
  
    let userid = $(this).find('.userid').val();

    let cpid = $(this).find('.coupon_select').val();
    console.log('cpid'+cpid);
  
  
    let data = {
      total_price : total_price,
      discount_price : discount_price,
      cartid : cart_id,
      userid: userid,
      cpid: cpid
    }
  console.log(data);
    $.ajax({
      async : false, 
      type: 'post',     
      data: data, 
      url: "payment_insert.php", 
      dataType: 'json', //결과 json 객체형식
      error: function(error){
        console.log('Error:', error);
      },
      success: function(return_data){
        location.reload();
        // target.remove();
        // console.log(return_data);
        location.href = "/pudding-LMS-website/user/cart/cart_complete.php";
      }
    });//ajax
  } else{
    alert('상품을 선택해주세요');
  }

});
