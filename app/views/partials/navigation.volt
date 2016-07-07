<nav class="navbar navbar-inverse navbar-static-top">
<div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#gnavi">
      <span class="sr-only">メニュー</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <a href="." class="navbar-brand header-logo-padding"><img src='/terminal/public/img/materials/logo.png' class="header-logo-size"></a>
  </div>

  <div id="gnavi" class="collapse navbar-collapse">

    <p class="navbar-text navbar-right">
    {% if auth_user_name is not empty %}
      <a class="brand" href="/terminal/edit?id={{ auth_user_id }}/">{{ auth_user_name }}</a>&nbsp;さん
      &nbsp;|&nbsp;
      <a class="brand" href="/terminal/signout/">ログアウト</a>
    {% endif %}
    </p>
  </div>

</div>
</nav>
