<h1>新規登録画面</h1>
<hr>
{{ form('terminal/signup', 'method': 'post') }}
	
	<div class="form-group">
		<label for="email">メールアドレス&nbsp;<span class="required-mark">必須</span></label>
		{{ email_field("email", "class": "form-control") }}
		{% if errorMsg['email'] is not empty %}

			<div class="alert alert-danger">
				<a class="close" data-dismiss="alert">×</a>
				{{ errorMsg['email'] }}
			</div>
			
		{% endif %}
	</div>
	
	<div class="form-group">
		<label for="password">パスワード&nbsp;<span class="required-mark">必須</span></label>
		{{ password_field("password", "class": "form-control", "maxlength": 20) }}
		{% if errorMsg['password'] is not empty %}
			
			<div class="alert alert-danger">
				<a class="close" data-dismiss="alert">×</a>
				{{ errorMsg['password'] }}
			</div>
			
		{% endif %}
	</div>
	
	<div class="form-group">
		<label for="name">氏名&nbsp;<span class="required-mark">必須</span></label>
		{{ text_field("name", "class": "form-control", "maxlength": 20) }}
		{% if errorMsg['name'] is not empty %}
			
			<div class="alert alert-danger">
				<a class="close" data-dismiss="alert">×</a>
				{{ errorMsg['name'] }}
			</div>
			
		{% endif %}	
	</div>	
	
	{{ submit_button('新規登録', "class": "btn btn-primary btn-lg btn-block") }}
{{ end_form() }}
