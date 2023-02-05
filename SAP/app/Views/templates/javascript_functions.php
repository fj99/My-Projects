<?php
?>
<script>
	function navActiveChanger(elementToActivate) {
		elementToActivate.className = "active";
	}

	function submitForm() {
		document.getElementById("search").submit();
	}

	function showOrHideElementRequestForm(className, idName, choice) {
		var element = document.getElementById(idName);
		var input = document.getElementById("file_input");
		if (choice == "single") {
			element.className = className;
			input.className = "hidden"
		}
		if (choice == "multi") {
			element.className = "hidden";
			input.className = "insert_decisions";
		}
	}
</script>