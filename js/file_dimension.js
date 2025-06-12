/**
 * 
 * @param {*} event checking the upload image doesn't exceed the dimension limit
 */

function checkImageResolution(event) {
    var file = event.target.file[0];
    var img = new Image();

    img.onload = function() {
        var maxWidth = 350;
        var maxHeight = 200;

        if (img.width > maxWidth && img.height) {
            document.getElementById('error-message').textContent = "sorry! image resolution must be atleast 350 x 200.";
            event.target.value = "";
        } else {
            document.getElementById('error-message').textContent = "";
        }
    };
    img.src = URL.createObjectURL(file);
}