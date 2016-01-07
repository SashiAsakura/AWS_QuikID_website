<div class="thanksDown">Thank you for downloading!</div>
<script type='text/javascript'>
	var now = new Date();
	now.setFullYear(now.getFullYear() + 10); //expire in 10 years
	document.cookie = 'fp_usr=@@user@@;expires=' + now.toUTCString() + ';path=/';
	if (typeof $ != 'undefined'){
		$('#download-form').hide();
		$('#dusr').val('@@user@@');
		$('html, body').animate({ scrollTop: 0 }, 'slow');
	}
	if ('@@file@@' != ''){
		top.location.href ='@@file@@';
	}
	
</script>
