//----
//プロフィールとパスワードでほぼおなじ処理なので関数化して管理したほうがいいかも
//----
$(function() {
  /*
   * プロフィールモーダル
   */
  $('#userModal').on('click', '.modal-footer .btn-primary', function() {
    //$('#userModal').modal('hide');
    //alert('変更を保存をクリックしました。');
    $bool = confirm('更新してもよろしいですか？');
    if($bool){
      $.ajax({
        type: "POST",
        url: "/terminal/profile/",
        data: {
          "user_name": $('input#user_name').val(),
          "user_mail": $('input#user_mail').val()
        },
        //dataType: 'json',
        success: function(result){
          //console.log(result);

          //エラーメッセージ削除
          $("ul.parsley-errors-list").remove();

          //status : true or false
          if(!result.status){
            //エラーメッセージ削除
            $("ul.parsley-errors-list").remove();

            //名前
            if(result.errorMsg_name){
              console.log(result.errorMsg_name);
              // エラーが発生した入力項目を取得
              var $elem = $('input#user_name');
              // 入力項目の直前に、エラーメッセージを追加
              $elem.after('<ul class="parsley-errors-list filled" id="parsley-id-5"><li class="parsley-required">' + result.errorMsg_name +  '</li></ul>');
            }

            //メールアドレス
            if(result.errorMsg_mail){
              console.log(result.errorMsg_mail);
              // エラーが発生した入力項目を取得
              var $elem = $('input#user_mail');
              // 入力項目の直前に、エラーメッセージを追加
              $elem.after('<ul class="parsley-errors-list filled" id="parsley-id-5"><li class="parsley-required">' + result.errorMsg_mail +  '</li></ul>');
            }
          } else {
            // エラーが発生した入力項目を取得
            var $elem = $('div.user_name');
            // 入力項目の直前に、エラーメッセージを追加
            $elem.before('<ul class="parsley-errors-list filled" id="parsley-id-5"><li class="parsley-required">' + result.successMsg +  '</li></ul>');
          }
        },
      });
    }
  });

  /*
   * パスワードモーダル
   */
  $('#passwordModal').on('click', '.modal-footer .btn-primary', function() {
    //$('#userModal').modal('hide');
    //alert('変更を保存をクリックしました。');
    $bool = confirm('更新してもよろしいですか？');
    if($bool){
      $.ajax({
        type: "POST",
        url: "/terminal/password/",
        data: {
          "new_password": $('input#new_password').val(),
          "re_password": $('input#re_password').val()
        },
        //dataType: 'json',
        success: function(result){
          //console.log(result);

          //エラーメッセージ削除
          $("ul.parsley-errors-list").remove();

          //status : true or false
          if(!result.status){
            //エラーメッセージ削除
            $("ul.parsley-errors-list").remove();

            //名前
            if(result.errorMsg_new_password){
              console.log(result.errorMsg_new_password);
              // エラーが発生した入力項目を取得
              var $elem = $('input#new_password');
              // 入力項目の直前に、エラーメッセージを追加
              $elem.after('<ul class="parsley-errors-list filled" id="parsley-id-5"><li class="parsley-required">' + result.errorMsg_new_password +  '</li></ul>');
            }

            //メールアドレス
            if(result.errorMsg_re_password){
              console.log(result.errorMsg_re_password);
              // エラーが発生した入力項目を取得
              var $elem = $('input#re_password');
              // 入力項目の直前に、エラーメッセージを追加
              $elem.after('<ul class="parsley-errors-list filled" id="parsley-id-5"><li class="parsley-required">' + result.errorMsg_re_password +  '</li></ul>');
            }
          } else {
            // エラーが発生した入力項目を取得
            var $elem = $('div.new_password');
            // 入力項目の直前に、エラーメッセージを追加
            $elem.before('<ul class="parsley-errors-list filled" id="parsley-id-5"><li class="parsley-required">' + result.successMsg +  '</li></ul>');
          }

        },
      });
    }
  });

});
