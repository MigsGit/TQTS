var handler = 'handler/handler.php';

$('#change_page').click(function(){ change_page('homepage.php'); });
$('#change_page2').click(function(){ change_page('sample2.php'); });

function change_page(page){
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: "action=encode&page="+page,
		url		: handler,
		success	: function(result){
			window.location.href = "index.php?param="+result;
		},error	: function(){
			alert('error handler');
		}
	});
}