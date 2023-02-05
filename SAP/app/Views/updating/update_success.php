<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo base_url('assets/styles.css'); ?>" />
</head>

<body>
	<div class="container">
		<h3 style="color: black;">Successful Operation! Redirecting to User Update Page</h3>
	</div>

	<div style="display: none;">
		<form name="myForm" id="myForm" action="updateSearch" method="POST">
			<input type="text" name="id" value=<?php echo ($user[1]); ?>>
			<input type="submit" value="Submit" />
		</form>
	</div>

</body>

</html>

<script type="text/javascript">
	window.onload = function() {
		var auto = setTimeout(function() {
			autoRefresh();
		}, 1);

		function submitform() {
			alert('Changes have been made');
			document.forms["myForm"].submit();
		}

		function autoRefresh() {
			clearTimeout(auto);
			auto = setTimeout(function() {
				submitform();
				autoRefresh();
			}, 1);
		}
	}
</script>