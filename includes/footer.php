  </div><br><br>

<div class="col-md-12 text-center">&copy; Copyright 2018-2020 Dragos's Boutique</div>

<!--Details Modal-->



<script>
jQuery(window).scroll(function(){
  var vscroll = jQuery(this).scrollTop();
jQuery('#logotext').css({
  "transform" : "translate(0px, "+vscroll/2+"px)"
});

var vscroll = jQuery(this).scrollTop();
jQuery('#back-flower').css({
"transform" : "translate("+vscroll/5+"px, -"+vscroll/12+"px)"
});

var vscroll = jQuery(this).scrollTop();
jQuery('#for-flower').css({
"transform" : "translate(0px, -"+vscroll/2+"px)"
});
});



function detailsmodal(id){
  var data = {"id" : id};
  jQuery.ajax({
    url : '/boutique/includes/detailsmodal.php', //is the url of the detailsmodal page....where the page is living
    method : "post",
    data : data,//is assigning the data from "var data" to data
    success : function(data){
      jQuery('body').append(data);//appending the 'data' to the body of the modal...basically the body in this case is the code from detailsmodal
      jQuery('#details-modal').modal('toggle');//is opening the modal(which has the id details-modal from details-modal page in top)using the modal function of bootstrap
    },
    error : function(){
      alert("Something went wrong!");
    },
  });
}
</script>
  </body>

</html>
