<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
 
    $("#btn").click(function(){
 
        $.ajax({
            type: "POST",
            url: "/terminal/index/test/",
            data: {
                "page": 2
            },
            success: function(j_data){
 alert('a');
                console.log(j_data);
 
            }
        });
 
    });
 
});
</script>

<button id="btn">Click</button>