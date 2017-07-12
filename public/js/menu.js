$(document).ready(function(){
/***********************************************************/
	$("#menu li").click(function(){
		$(this).children(":hidden").slideToggle();
	}, function(){
		$(this).parent().find("ul").slideToggle();
	});
/***********************************************************/
	$("#genPin").click(function(){
        $("#confirmBox").animate({
            top: '10px'
        }, 1000);
    });
/***********************************************************/
    $('#info').click(function(){
		var $acct = $('#acctno').val();
		$.post('includes/ajax.php',
			{acct_no:$acct}, 
			function(data){
				$('#acctname').val(data);
			});
	});
});