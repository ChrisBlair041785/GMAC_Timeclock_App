function checked() {
    const password1 = document.getElementById('password1').value;
    const password2 = document.getElementById('password2').value;
    const message = document.getElementById('message');

    if (password1 === password2) {
        message.style.color = 'green';
        message.textContent = 'Passwords match';
        return true;
    }

    message.style.color = 'red';
    message.textContent = 'Passwords do not match';
    return false;
}