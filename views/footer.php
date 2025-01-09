	<script type="text/javascript">
        function replaceWithTextArea(input){
            const text = document.createElement('textarea');
            text.setAttribute('name', input.getAttribute('name'));
            text.setAttribute('id', input.getAttribute('id'));
            text.setAttribute('class', input.getAttribute('class'));
            text.value = input.value;
            input.parentNode.replaceChild(text, input);
            return text;
        }
		document.addEventListener("DOMContentLoaded", function() {
			let ifield = document.getElementById('url');
			if (ifield) {ifield.addEventListener("input", e => {
                if (e.target.value.indexOf(" ") > 0) {
                    const text = replaceWithTextArea(e.target);
                    text.value = text.value.replaceAll(" ","\n");
                    text.focus();
                }
            })}
            ifield = ifield || document.getElementById('password');
			if (ifield) {ifield.focus();}
            
		});
	</script>

</body></html>
