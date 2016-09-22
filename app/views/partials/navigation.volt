<div class="top_nav">
  <div class="nav_menu">
    <nav class="" role="navigation">

      <ul class="nav navbar-nav navbar-right">
        <div class="navbar-left">
          <a href="/terminal/" class="navbar-brand header-logo-padding"><img src="/terminal/public/img/materials/logo.png" class="header-logo-size"></a>
        </div>

        {% if auth_user_name is not empty %}
          <li class="">
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              {{ auth_user_name }}&nbsp;さん
            </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
              <li><a class="1btn" href="#userModal" data-toggle="modal"><i class="fa fa-user pull-right"></i>プロフィール</a></li>
              <li><a class="1btn" href="#passwordModal" data-toggle="modal"><i class="fa fa-key pull-right"></i>パスワード</a></li>
              <li><a href="/terminal/signout/"><i class="fa fa-sign-out pull-right"></i>ログアウト</a></li>
            </ul>
          </li>
        {% endif %}
      </ul>
    </nav>
  </div>
</div>
