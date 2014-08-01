window.onload = function() {
	$(".helix-index-item").click(function() {
		console.log($(this).attr("data"));
		$.post( './card.php', { 'data' : $(this).attr("data") }, function() {
    		window.location.href = './card.php';
		});
	});

	$(".helix-index-get-started").click(function() {
		window.location.href = './add.html';
	});
}
function goTo(url){
    window.location.href=url;
}
