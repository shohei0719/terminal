<script type="text/javascript">
function check() {
	return confirm('更新してもよろしいですか？');
}
</script>

<h1>端末一覧</h1>
<hr/>
<div class="row">

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

						{# ユーザ情報を表示 #}
						<a class="1btn" href="/members/profile/541"><img src={{ image_path }} height="120" width="160" class="1thumbnail"></a>

						<div class="caption">
							<h4><a class="1btn" href=""><i class="fa fa-mobile" aria-hidden="true"></i>&nbsp;{{ terminal.name }}</a></h4>
							<p>
								<span class="label label-primary black-background">{{ terminal.maker_name }}</span>
								<span class="label label-primary black-background">{{ terminal.carrier_name }}</span><br>
								<span class="label label-primary black-background">{{ terminal.os_name }}</span>
								<span class="label label-primary black-background">Version&nbsp;{{ terminal.version_name }}</span><br/>
								<span class="label label-primary black-background">{{ terminal.organization_name }}</span><br/>
								<br>

								{{ form('terminal/index/edit?id=' ~ terminal.id ~ '/', 'method': 'post', 'onsubmit': "return check();") }}
								<div class="form-group">
									<select class="form-control input-sm" name="rental_flg" id="rental_flg">
										<option value="0" {% if terminal.rental_flg == 0 %}selected{% endif %}>貸出可</option>
										<option value="1" {% if terminal.rental_flg == 1 %}selected{% endif %}>貸出中</option>
									</select>
								</div>
								<div class="form-group">
									<label for="comment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Comment:</label>
									<textarea class="form-control input-sm" rows="2" id="comment" name="comment">{{ terminal.comment }}</textarea>
								</div>

								{{ submit_button('編集', "class": "btn btn-primary btn-xs btn-block") }}
								{{ end_form() }}
							</p>
						</div>
					</div>
				</div>
			{% endif %}
		{% endfor %}
		{% break %}
	{% endfor %}

</div>
{% if page.total_pages != 1 %}
	{{ link_to('', '最初') }}
	{{ link_to('?page=' ~ page.before, '前へ') }}
	{{ link_to('#', page.current ~ '/' ~ page.total_pages) }}
	{{ link_to('?page=' ~ page.next, '次へ') }}
	{{ link_to('?page=' ~ page.last, '最後') }}
{% endif %}
