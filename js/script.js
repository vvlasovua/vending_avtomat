$(function () {

  $('.buy-product').on('click', function () {
    let id = $(this).data('id');

    $.ajax({
      url: '/inc/buy_product.php',
      type: "POST",
      dataType: "json",
      data: {id: id},
      success : function (data) {
        console.log(data);
        if(data.code === 500) {
          $('#txt').html(data.msg).show();
          setTimeout(function(){
            $('#txt').hide();
          }, 2000);
          return false;
        }

        $('#display').html(data.money+" грн");
        if(data.money > 0){
          $('.take_money').show();
        }
        check_product_for_pay(data.money);
      },
      error : function (data) {
        console.log(data);
      }
    });

  });

  $(document).on('submit', '#form_money', function(e) {
    e.preventDefault();
    let form_data = $(this).serializeArray();
    console.log(form_data);
    $.ajax({
      url: '/inc/set_receiving_money.php',
      type: "POST",
      dataType: "json",
      data: form_data,
      success : function (data) {
        console.log(data.money);
        $('#display').html(data.money+" грн");
        if(data.money > 0){
          $('.take_money').show();
        }
        check_product_for_pay(data.money);
      },
      error : function (data) {
        console.log(data);
      }
    });

  });

  $('#take_money').click(function () {
    $.ajax({
      url: '/inc/take_money.php',
      type: "POST",
      dataType: "json",
      success : function (data) {
        console.log(data.money);
        $('#display').html(data.money+" грн");
        $('#txt').html(data.surrender).show();
        setTimeout(function(){
          $('#txt').hide();
        }, 2000);
        if(data.money === 0){
          $('.take_money').hide();
        }
        check_product_for_pay(data.money);
      },
      error : function (data) {
        console.log(data);
      }
    });
  });

});

function check_product_for_pay(money) {
  $(".buy-product").each(function() {
    let cost = $(this).data('cost');
    if(money >= cost){
      $(this).removeClass('btn-secondary');
      $(this).addClass('btn-success');
    }else{
      $(this).removeClass('btn-success');
      $(this).addClass('btn-secondary');
    }
  });
}