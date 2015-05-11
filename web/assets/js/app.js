$(document).ready(function(){
	$('#raty').raty({number: 5, scoreName: 'form[note]', path:chemin});

	function getRaty(){
		$('.ratyCommentaire').raty({
			path:chemin,
			score: function() {
				return $(this).attr('data-number');
			}, number: 5, readOnly: true 
		});
	}
	getRaty();
});