// Function to display a message
function displayCartMessage(message) {
    var messageDiv = document.createElement('div');
    messageDiv.innerText = message;
    messageDiv.style.backgroundColor = '#d4edda';
    messageDiv.style.color = '#155724';
    messageDiv.style.padding = '10px';
    messageDiv.style.margin = '15px 0';
    messageDiv.style.borderRadius = '5px';
    messageDiv.style.border = '1px solid #c3e6cb';
    document.body.appendChild(messageDiv);

    // Hide the message after 3 seconds
    setTimeout(function() {
        messageDiv.style.display = 'none';
    }, 3000); // 3000 milliseconds = 3 seconds
}
