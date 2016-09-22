<!DOCTYPE html>
<html lang="jp">
    <head>
{{ partial("partials/headerscript") }}
    </head>

    <body class="nav-md">
      <div class="container body">
        <div class="main_container">
        {{ partial("partials/navigation") }}

        {{ partial("partials/content") }}

        {{ partial("partials/footer") }}
        </div><!-- main_container -->
      </div><!-- container body -->
    {{ partial("partials/footerscript") }}
    </body>
</html>
