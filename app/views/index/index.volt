<form action="/terminal/">
<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
  <div class="input-group">
	    <input type="text" name="search" class="form-control" placeholder="検索ワード" value={{search}}>
	    <span class="input-group-btn">
	      <button type="submit" class="btn btn-default" type="button">検索</button>
	    </span>
  </div>
</div>
</form>

<div class="col-md-12">
  <div class="x_panel">
    <div class="x_content">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
					{% if page.total_pages > 1 %}
						<ul class="pagination pagination-split">
							<li>{{ link_to('/terminal/?search=' ~ search, '最初') }}</li>
							<li>{{ link_to('/terminal/?page=' ~ page.before ~ '&search=' ~ search, '前へ') }}</li>
							<li class="not-allowed">{{ link_to("#", page.current ~ '/' ~ page.total_pages, 'class': 'disabled') }}</li>
							<li>{{ link_to('/terminal/?page=' ~ page.next ~ '&search=' ~ search, '次へ') }}</li>
							<li>{{ link_to('/terminal/?page=' ~ page.last ~ '&search=' ~ search, '最後') }}</li>
						</ul>
					{% elseif page.total_pages == 0 %}
						{{'検索結果 : 0件'}}
					{% endif %}
        </div>

        <div class="clearfix"></div>

				{% set cnt = 1 %}
				{% for terminals in page %}
					{% for terminal in terminals %}
						{% if terminal is not empty %}

							<div class="col-md-3 col-sm-6">
								<div class="thumbnail">
									{# イメージ画像を設定 #}
									{% if terminal.image is not empty %}
										{% set image_path = "/backend_app/public/img/images/" ~ terminal.image %}
									{% else %}
										{% set image_path = "/terminal/public/img/materials/no_image.png" %}
									{% endif %}

									{# 端末情報 #}
									<a class="1btn" href="#terminalModal{{cnt}}" data-toggle="modal"><img src={{ image_path }} height="120" width="160" class="1thumbnail"></a>

									<div class="form-group margin-left10">
										<h2><a href="#terminalModal{{cnt}}" data-toggle="modal">{{ terminal.name }}</a></h2>
										<span class="label label-primary black-background">{{ terminal.maker_name }}</span><br/>
										<span class="label label-primary black-background">{{ terminal.carrier_name }}</span><br/>
										<span class="label label-primary black-background">{{ terminal.os_name }}&nbsp;{{ terminal.version_name }}</span><br/>
										<span class="label label-primary black-background">{{ terminal.organization_name }}</span><br/>
									</div>

								{{ form('terminal/index/edit?id=' ~ terminal.terminal_id, 'method': 'post', 'onsubmit': "return check();") }}
									<div class="profile_details">
									<div class="profile_view">
										<div class="col-xs-12 bottom">
											<div class="col-xs-12">
												<div class="form-group">
													<label for="comment">Comment:</label>
													<textarea class="form-control input-sm" rows="2" id="comment" name="comment">{{ terminal.comment }}</textarea>
												</div>
											</div>

											<div class="col-xs-12 col-sm-6 emphasis">
												<div class="form-group">
													<select class="form-control input-sm" name="rental_flg" id="rental_flg">
														<option value="0" {% if terminal.rental_flg == 0 %}selected{% endif %}>貸出可</option>
														<option value="1" {% if terminal.rental_flg == 1 %}selected{% endif %}>貸出中{% if terminal.rental_flg == 1 %}【{{terminal.user_name}}】{% endif %}</option>
													</select>
												</div>
											</div>


												{% if terminal.rental_flg == 1 and terminal.rental_user !== auth_user_id %}
													<div class="col-xs-12 col-sm-6 emphasis not-allowed">
														<button type="submit" class="btn btn-success btn-sm btn-block" disabled="disabled">
															<i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;編集
														</button>
													</div>
												{% else %}
													<div class="col-xs-12 col-sm-6 emphasis">
														<button type="submit" class="btn btn-success btn-sm btn-block">
															<i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;編集
														</button>
													</div>
												{% endif %}
										</div>
										</div>
										</div>
								{{ end_form() }}
								</div>
							</div>

						{% endif %}
						{% set cnt += 1 %}
					{% endfor %}
					{% break %}
				{% endfor %}

      </div>
    </div>
  </div>
</div>

<!-- 端末情報モーダル_開始 -->
{% set cnt = 1 %}
{% for terminals in page %}
	{% for terminal in terminals %}
		{% if terminal is not empty %}
			<div class="modal" id="terminalModal{{cnt}}" tabindex="-1" role="dialog" aria-labelledby="terminalModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">
			          <span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
			        </button>
			        <h4 class="modal-title">{{terminal.name}}</h4>
			      </div><!-- /modal-header -->

						<div class="modal-body">
							<div class="form-group">
								<label for="id"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;電話番号</label>
								{{ text_field("class": "form-control input-sm", "value": terminal.tel, "disabled": "disabled") }}
							</div>
							<div class="form-group">
								<label for="id"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;メールアドレス</label>
								{{ text_field("class": "form-control input-sm", "value": terminal.mail, "disabled": "disabled") }}
							</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
			        {# <button type="button" class="btn btn-primary">変更を保存</button> #}
			      </div>
			    </div> <!-- /.modal-content -->
			  </div> <!-- /.modal-dialog -->
			</div> <!-- /.modal -->
		{% endif %}
		{% set cnt += 1 %}
	{% endfor %}
	{% break %}
{% endfor %}
<!-- 端末情報モーダル_終了 -->

<!-- ユーザ情報モーダル_開始 -->
<div class="modal" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
        </button>
        <h4 class="modal-title"><i class="fa fa-user"></i>&nbsp;プロフィール</h4>
      </div><!-- /modal-header -->

      <div class="modal-body">
        <div class="form-group user_name">
          <label for="name"><i class="fa fa-user"></i>&nbsp;名前</label>
          {{ text_field("user_name", "class": "form-control input-sm", "value": user_name) }}
        </div>
        <div class="form-group user_mail">
          <label for="mail"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;メールアドレス</label>
          {{ text_field("user_mail", "class": "form-control input-sm", "value": user_mail) }}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
        <button type="button" class="btn btn-primary">変更</button>
      </div>

    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->
<!-- ユーザ情報モーダル_終了 -->

<!-- パスワードモーダル_開始 -->
<div class="modal" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
        </button>
        <h4 class="modal-title"><i class="fa fa-key"></i>&nbsp;パスワード</h4>
      </div><!-- /modal-header -->

      <div class="modal-body">
        <div class="form-group new_password">
          <label for="new_password"><i class="fa fa-key" aria-hidden="true"></i>&nbsp;新しいパスワード</label>
          {{ password_field("new_password", "class": "form-control input-sm", "maxlength": 20, "value": new_password) }}
        </div>
        <div class="form-group re_password">
          <label for="re_password"><i class="fa fa-key" aria-hidden="true"></i>&nbsp;パスワード再入力</label>
          {{ password_field("re_password", "class": "form-control input-sm", "maxlength": 20, "value": re_password) }}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
        <button type="button" class="btn btn-primary">変更</button>
      </div>

    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->
<!-- パスワードモーダル_終了 -->
