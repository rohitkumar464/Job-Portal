
const usernameEl = document.querySelector('#fullname');
const emailEl = document.querySelector('#email');
const locationEl = document.querySelector('#location');
const jobtitleEl = document.querySelector('#jobtitle');
// const confirmPasswordEl = document.querySelector('#confirm-password');

const form = document.querySelector('#signup');


const checkUsername = () => {

    let valid = false;

    const min = 3,
        max = 25;

    const username = usernameEl.value.trim();

    if (!isRequired(username)) {
        showError(usernameEl, 'Username cannot be blank.and space between');
    } else if (!isBetween(username.length, min, max)) {
        showError(usernameEl, `Username must be between ${min} and ${max} characters.`)
    } else {
        showSuccess(usernameEl);
        valid = true;
    }
    return valid;
};
const checkLocation = () => {

    let valid = false;

    const min = 3,
        max = 25;

    const location = locationEl.value.trim();

    if (!isRequired(location)) {
        showError(locationEl, 'Location cannot be blank.');
    } else if (!isBetween(location.length, min, max)) {
        showError(locationEl, `Location must be between ${min} and ${max} characters.`)
    } else {
        showSuccess(locationEl);
        valid = true;
    }
    return valid;
};
const checkJobtitle = () => {

    let valid = false;

    const min = 3,
        max = 50;

    const jobtitle = jobtitleEl.value.trim();

    if (!isRequired(jobtitle)) {
        showError(jobtitleEl, 'jobtitle cannot be blank.');
    } else if (!isBetween(jobtitle.length, min, max)) {
        showError(jobtitleEl, `jobtitle must be between ${min} and ${max} characters.`)
    } else {
        showSuccess(jobtitleEl);
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




const isEmailValid = (email) => {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
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
            checkUsername();
            break;
        case 'email':
            checkEmail();
            break;
        case 'location':
            checkLocation();
            break;
        case 'jobtitle':
            checkJobtitle();
            break;
    }
}));


// for Captcha
let captcha;
function generate() {

	// Clear old input
	document.getElementById("submit").value = "";

	// Access the element to store
	// the generated captcha
	captcha = document.getElementById("image");
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

// for toggle
//  document.getElementById("toggle").addEventListener("click",function(){
//     var url;
//     if(this.classList.contains("active")){
//         url="page2.html";

//     }
//     else{
//         url="page1.html";
//     }
//  });
// function myFunction() {
//     var x = document.getElementById("prijs-small");
//     if (x.innerHTML === "user") {
//       x.innerHTML = "€13";
//       window.location.href = 'templates/admin/index.html.twig';
//     } else {
//       x.innerHTML = "user";
//     }
//   };
  
//   function mailaanpassing() {
//     document.getElementById("aanvragen").href = "mailto:someone@someone.com";
//     return false;
//   };
