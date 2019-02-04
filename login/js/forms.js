function formhash(form, username, password) {
    var formfields = document.getElementById("login-form");
    var i;
    for (i = 0; i < formfields.length ;i++) {
        if (formfields.elements[i].value == ''){
            alert('You must provide all the requested details. Please try again');
            return false;
        }
    }

    // Create a new element input, this will be our hashed password field.
    // var p = document.createElement("input");

    // Add the new element to our form.
    // form.appendChild(p);
    // p.name = "p";
    // p.type = "hidden";
    // p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent.
    // password.value = "";

    // Finally submit the form.
    form.submit();
    return true;
}

function regformhash(form, firstname, lastname, username, email, password, conf) {
    // Check each field has a value
    // if (uid.value == ''         ||
    //     firstname.value == ''     ||
    //     lastname.value == ''     ||
    //     username.value == ''     ||
    //     email.value == ''     ||
    //     password.value == ''  ||
    //     conf.value == '') {
    //
    //     alert('You must provide all the requested details. Please try again');
    //     return false;
    // }
    var formerror = 0;


    // if (form.firstname.value == '') {
    //     formerror = 1;
    // }

    var formfields = document.getElementById("register-form");
    var i;
    for (i = 0; i < formfields.length ;i++) {
        if (formfields.elements[i].value == ''){
            alert('You must provide all the requested details. Please try again');
            return false;
        }
    }

    // var text = formfields.elements[1].value;
    // if (text == '') {
    //     formerror = 1;
    // }
    // alert(formerror);
    // if (formerror == '1'){
    //     alert('You must provide all the requested details. Please try again');
    //     return false;
    // }

    // alert('You must provide all the requested details. Please try again');
    // Check the username

    re = /^\w+$/;
    if(!re.test(form.username.value)) {
        alert("Username must contain only letters, numbers and underscores. Please try again");
        form.username.focus();
        return false;
    }

    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }

    // At least one number, one lowercase and one uppercase letter
    // At least six characters

    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }

    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }

    // Create a new element input, this will be our hashed password field.
    var p = document.createElement("input");

    // Add the new element to our form.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent.
    password.value = "";
    conf.value = "";

    // Finally submit the form.
    form.submit();
    return true;
}

$('#login-form-link').click(function(e) {
    $("#login-form").delay(100).fadeIn(100);
    $("#register-form").fadeOut(100);
    $('#register-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
});

$('#register-form-link').click(function(e) {
    $("#register-form").delay(100).fadeIn(100);
    $("#login-form").fadeOut(100);
    $('#login-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
});