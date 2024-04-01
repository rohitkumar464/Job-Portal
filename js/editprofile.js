// $(document).ready(function(){
//     $('#country').on('change', function(){
//         var iso2 = $(this).val();
    
//         if(iso2){
//             $.ajax({
//                 type:'POST',
//                 url:'..//../model/getAjaxData.php',
//                 data:'iso2_val='+iso2,
//                 success:function(html){
//                     $('#state').html(html);
//                     $('#city').html('<option value="">Select state first</option>'); 
//                 }
//             }); 
//         }else{
//             $('#state').html('<option value="">Select country first</option>');
//             $('#city').html('<option value="">Select state first</option>'); 
//         }
//     });
    
//     $('#state').on('change', function(){
//         var countryIdVal = $('#country').val();
//         var iso2ID = $(this).val();
//         if(iso2ID){
//             $.ajax({
//                 type:'POST',
//                 url:'..//../model/getAjaxData.php',
//                 data:'state_iso2='+iso2ID+'&sel_country_id='+countryIdVal,
//                 success:function(html){
//                     $('#city').html(html);
//                 }
//             }); 
//         }else{
//             $('#city').html('<option value="">Select state first</option>'); 
//         }
//     });
// });


//registration file
const fullnameEl = document.querySelector('#fullname');
const usernameEl = document.querySelector('#uname');
const emailEl = document.querySelector('#uemail');
const passwordEl = document.querySelector('#password');
const confirmPasswordEl = document.querySelector('#confirm-password');

const form = document.querySelector('#signup');

const checkFullname = () => {

    let valid = false;

    const min = 3,
        max = 25;

    const fullname = fullnameEl.value.trim();

    if (!isRequired(fullname)) {
        showError(fullnameEl, 'Fullname cannot be blank.');
    } else if (!isBetween(fullname.length, min, max)) {
        showError(fullnameEl, `Fullname must be between ${min} and ${max} characters.`)
    } else {
        showSuccess(fullnameEl);
        valid = true;
    }
    return valid;
};
const checkUsername = () => {

    let valid = false;

    const min = 3,
        max = 25;

    const username = usernameEl.value.trim();

    if (!isRequired(username)) {
        showError(usernameEl, 'Username cannot be blank.');
    } else if (!isBetween(username.length, min, max)) {
        showError(usernameEl, `Username must be between ${min} and ${max} characters.`)
    } else {
        showSuccess(usernameEl);
        valid = true;
    }
    return valid;
};


const checkEmail = () => {
    let valid = false;
    const email = emailEl.value.trim();
    if (!isRequired(email)) {
        showError(emailEl, 'Email cannot be blank.');
    } else if (!isEmailValid(email)) {
        showError(emailEl, 'Email is not valid.')
    } else {
        showSuccess(emailEl);
        valid = true;
    }
    return valid;
};

const checkPassword = () => {
    let valid = false;


    const password = passwordEl.value.trim();

    if (!isRequired(password)) {
        showError(passwordEl, 'Password cannot be blank.');
    } else if (!isPasswordSecure(password)) {
        showError(passwordEl, 'Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)');
    } else {
        showSuccess(passwordEl);
        valid = true;
    }

    return valid;
};

const checkConfirmPassword = () => {
    let valid = false;
    // check confirm password
    const confirmPassword = confirmPasswordEl.value.trim();
    const password = passwordEl.value.trim();

    if (!isRequired(confirmPassword)) {
        showError(confirmPasswordEl, 'Please enter the password again');
    } else if (password !== confirmPassword) {
        showError(confirmPasswordEl, 'The password does not match');
    } else {
        showSuccess(confirmPasswordEl);
        valid = true;
    }

    return valid;
};

const isEmailValid = (email) => {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};

const isPasswordSecure = (password) => {
    const re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    return re.test(password);
};

const isRequired = value => value === '' ? false : true;
const isBetween = (length, min, max) => length < min || length > max ? false : true;


const showError = (input, message) => {
    // get the form-field element
    const formField = input.parentElement;
    // add the error class
    formField.classList.remove('success');
    formField.classList.add('error');

    // show the error message
    const error = formField.querySelector('small');
    error.textContent = message;
};

const showSuccess = (input) => {
    // get the form-field element
    const formField = input.parentElement;

    // remove the error class
    formField.classList.remove('error');
    formField.classList.add('success');

    // hide the error message
    const error = formField.querySelector('small');
    error.textContent = '';
}
const debounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        // cancel the previous timer
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        // setup a new timer
        timeoutId = setTimeout(() => {
            fn.apply(null, args)
        }, delay);
    };
};

form.addEventListener('input', debounce(function (e) {
    switch (e.target.id) {
        case 'fullname':
            checkFullname();
            break;
        case 'uname':
            checkUsername();
            break;
        case 'uemail':
            checkEmail();
            break;
        case 'password':
            checkPassword();
            break;
        case 'confirm-password':
            checkConfirmPassword();
            break;
    }
}));
function fun(){
    location.reload(true);
}
jQuery('#phone').keyup(function () { 
        this.value = this.value.replace(/[^0-9+\.-]/g, '');
    });


    // for Captcha
let captcha;
function generate() {

	// Clear old input
	document.getElementById("submit").value = "";

	// Access the element to store
	// the generated captcha
	captcha = document.getElementById("image_captcha");
	let uniquechar = "";

	const randomchar =
"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	// Generate captcha for length of
	// 5 with random character
	for (let i = 1; i < 6; i++) {
		uniquechar += randomchar.charAt(
			Math.random() * randomchar.length)
	}

	// Store generated input
	captcha.innerHTML = uniquechar;
}

function printmsg() {
	const usr_input = document
		.getElementById("submit").value;

	// Check whether the input is equal
	// to generated captcha or not
	if (usr_input != captcha.innerHTML) {
		//let s = document.getElementById("key")
		//	.innerHTML = "Matched";
		//generate();
        let s = document.getElementById("key").innerHTML = "Invalid Captcha";
	    generate();
	}
	// else {
	// 	// let s = document.getElementById("key")
	// 	// 	.innerHTML = "Invalid Captcha";
	// 	// generate();
	// }
}