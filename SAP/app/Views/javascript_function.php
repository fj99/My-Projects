<script>
	function showOrHideElement(className, idName){
		var element = document.getElementById(idName);
		if(element.className == "hidden"){
			element.className = className
		}
		else{
			element.className = "hidden"
		}
	}
</script>