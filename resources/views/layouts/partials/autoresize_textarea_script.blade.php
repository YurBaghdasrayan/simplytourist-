<script>
    const minHeight=180;
    // Dealing with Textarea Height
    function calcHeight(value) {
        let numberOfLineBreaks = (value.match(/\n/g) || []).length;
        // min-height + lines x line-height + padding + border
        let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
        return newHeight+44;
    }

    let textarea = document.querySelector(".resize-ta");
    if(calcHeight(textarea.value)>minHeight)
        textarea.style.height = calcHeight(textarea.value) + "px";
    else
        textarea.style.height = minHeight+"px";
    document.addEventListener('DOMContentLoaded', listenText, false);
    function listenText(){
        let textarea = document.querySelector(".resize-ta");
        textarea.addEventListener("keyup", () => {
            if(calcHeight(textarea.value)>minHeight)
                textarea.style.height = calcHeight(textarea.value) + "px";
            else
                textarea.style.height = minHeight+"px";
        });
    }


</script>
