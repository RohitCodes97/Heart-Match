const signUpForm = document.getElementById('sign_up');

const signInForm = document.getElementById('sign_in');

const signUpBtn = document.getElementById('signupBtn');

const signInBtn = document.getElementById('signinBtn');


signUpBtn.addEventListener('click', function(e){
    e.preventDefault();
    signUpForm.style.display = "block";
    signInForm.style.display = "none";
});


signInBtn.addEventListener('click', function(e){
    e.preventDefault();
    signUpForm.style.display = 'none';
    signInForm.style.display = 'block';
});


