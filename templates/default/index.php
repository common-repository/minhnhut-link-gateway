<?php
/* @var $this LinkGateRedirector */
?>
<link type="text/css" href="<?php $this->getCssPath(); ?>" rel="stylesheet" />
<div class="box">
	<h2><?php echo $this->title; ?></h2>
	<p><?php echo $this->description; ?> <strong><?php echo $this->url; ?></strong></p>
	
	<a id="back-link" href="<?php echo $this->back_url; ?>" title="Come back"><?php echo $this->back; ?></a> | <a id="go-link" href="<?php echo $this->url; ?>" title="go"><?php echo $this->go; ?> (<?php echo $this->redirect_time; ?>)</a>
	
	<script>
		var sec = <?php echo $this->redirect_time; ?>;
		var golink = document.getElementById('go-link');
		var timerId;
		function timer() {
			if (sec > 0) {
				sec--;
			} else {
				window.location.assign('<?php echo $this->url; ?>');
				clearInterval(timerId);
			}
			golink.innerText = "Go (" + sec + ")";
		}
		timerId = setInterval(function() {timer()}, 1000); // 1 second per time
		
	</script>
</div>