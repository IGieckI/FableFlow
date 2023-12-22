function showRadioBox() {
    var radioBox = document.getElementById("radio-box");
    radioBox.style.display = "block";
}

function removeNewlines(textarea) {
    textarea.value = textarea.value.replace(/(\r\n|\n|\r)/gm, "");
}

function checkForTitleLength(textarea) {
    if (textarea.value.length === parseInt(textarea.getAttribute('maxlength'), 10)) {
        // Show a popup (you can replace this with your own popup logic)
        alert("Title can't be more than 20 characters!");
    }
}

function deleteOption(icon) {
    // Get the parent <li> element
    var listItem = icon.parentNode;
    
    // Remove the entire list item
    listItem.parentNode.removeChild(listItem);
}

// Show delete icons on mouseover
document.getElementById('options-list').addEventListener('mouseover', function(event) {
    if (event.target.tagName === 'LI') {
        var deleteIcon = event.target.querySelector('.delete-icon');
        if (deleteIcon) {
            deleteIcon.style.display = 'inline-block';
        }
    }
});

// Hide delete icons on mouseout
document.getElementById('options-list').addEventListener('mouseout', function(event) {
    if (event.target.tagName === 'LI') {
        var deleteIcon = event.target.querySelector('.delete-icon');
        if (deleteIcon) {
            deleteIcon.style.display = 'none';
        }
    }
});