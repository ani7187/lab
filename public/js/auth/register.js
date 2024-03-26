//phone validation
document.getElementById('telefon').addEventListener('input', function (e) {
    debugger;
    var telefonInput = e.target.value.trim();
    var telefonError = document.getElementById('telefon-error');

    var isValid = /^\+374\d{8}$/.test(telefonInput);

    if (!isValid) {
        telefonError.textContent = 'Telephone number must be in the format +374XXXXXXXX';
    } else {
        telefonError.textContent = '';
    }
});

//pass validation
document.getElementById('password').addEventListener('input', function (e) {
    var passwordInput = e.target.value.trim();
    var passwordError = document.getElementById('password-error');

    var isValid = passwordInput.length >= 8; // Example: Minimum length of 8 characters

    if (!isValid) {
        passwordError.textContent = 'Password must be at least 8 characters long';
    } else {
        passwordError.textContent = '';
    }
});

//password strong
var passType = "Weak";
document.getElementById('password').addEventListener('input', function (e) {
    var passwordInput = e.target.value.trim();
    var passwordStrength = document.getElementById('password-strength');

    var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{11,}$/;
    var mediumRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;

    if (strongRegex.test(passwordInput)) {
        passType = 'Strong';
        passwordStrength.textContent = 'Strong';
        passwordStrength.style.color = 'green';
    } else if (mediumRegex.test(passwordInput)) {
        passType = 'Medium';
        passwordStrength.textContent = 'Medium';
        passwordStrength.style.color = 'orange';
    } else {
        passwordStrength.textContent = 'Weak';
        passwordStrength.style.color = 'red';
    }
});

//gen strong pass
document.getElementById('generate-password').addEventListener('click', function () {
    document.getElementById('generated-password').innerHTML = generateStrongPassword();
    debugger
});

function generateStrongPassword() {
    var length = 11;
    var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{11,}$/;
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@$!%*?&";
    var password = "";
    for (var i = 0; i < length; i++) {
        var charIndex = Math.floor(Math.random() * charset.length);
        password += charset.charAt(charIndex);
    }
    if (!strongRegex.test(password)) {
        generateStrongPassword()
    }

    return password;
}


//email validation
function validateEmail(email) {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
}

const emailInput = document.getElementById('email');
console.log('a');
const emailError = document.getElementById('emailError');
emailInput.addEventListener('input', function() {
    debugger
    const email = this.value;
    if (!validateEmail(email)) {
        emailError.textContent = 'Invalid email address';
    } else {
        emailError.textContent = ''
    }
});

document.getElementById('registrationForm').addEventListener('submit', function (e) {
    if (!checkPassword()) {
        e.preventDefault();
    }
    if (passType !== 'Strong') {
        e.preventDefault();
        alert('Password must be strong.');
    }
});

function checkPassword() {
    var password = document.getElementById('password');
    var password_confirmation = document.getElementById('password_confirmation');
    var message = document.getElementById('message');

    if (password.value === password_confirmation.value) {
        return true;
    } else {
        message.innerHTML = 'Passwords do not match';
        message.style.color = 'red';
    }
    return false;
}
