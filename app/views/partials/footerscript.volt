{{ javascript_include('terminal/js/jquery-1.12.0.min.js') }}
{{ javascript_include('terminal/js/bootstrap/bootstrap.min.js') }}
{{ javascript_include('terminal/js/bootstrap/utils.js') }}
{{ javascript_include('terminal/js/footerFixed.js') }}
{{ javascript_include('terminal/js/jquery.uploadThumbs.js') }}
<script>
$(function() {
// jQuery Upload Thumbs
$('form input:file').uploadThumbs({
  position : 0,      // 0:before, 1:after, 2:parent.prepend, 3:parent.append,
          // any: arbitrarily jquery selector
  imgbreak : true    // append <br> after thumbnail images
});
});
</script>
