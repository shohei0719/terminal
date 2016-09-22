<a class="hiddenanchor" id="signup"></a>
<a class="hiddenanchor" id="signin"></a>

<div class="login_wrapper">
  <div class="animate form login_form">
    <section class="login_content">
      {{ form('/terminal/signin/', 'method': 'post') }}
        <h1>Terminal MS</h1>

				{% if errorMsg is not empty %}
					<ul class="parsley-errors-list filled" id="parsley-id-5">
						<li class="parsley-required">{{ errorMsg }}</li>
					</ul>
				{% endif %}

        <div>
          {{ email_field("mail", "class": "form-control", "placeholder": "メールアドレス") }}
        </div>
        <div>
					{{ password_field("password", "class": "form-control", "placeholder": "パスワード", "maxlength": 20) }}
        </div>
        <div>
					{{ submit_button('ログイン', "class": "btn btn-default submit") }}
          <a class="reset_pass" href="/terminal/password/reissue/">パスワードを再発行</a>
        </div>

        <div class="clearfix"></div>

        <div class="separator"></div>

      {{ end_form() }}
    </section>
  </div>
</div>
