<h1>ログイン画面</h1>
<hr>
{{ form('/terminal/signin/', 'method': 'post') }}

	{% if errorMsg is not empty %}

		<div class="alert alert-danger">
			<a class="close" data-dismiss="alert">×</a>
			{{ errorMsg }}
		</div>

	{% endif %}

	<div class="form-group">
		<label for="mail">メールアドレス</label>
		{{ email_field("mail", "class": "form-control") }}
	</div>

	<div class="form-group">
		<label for="password">パスワード</label>
		{{ password_field("password", "class": "form-control", "maxlength": 20) }}
	</div>

	{{ submit_button('ログイン', "class": "btn btn-primary btn-lg btn-block") }}
{{ end_form() }}
