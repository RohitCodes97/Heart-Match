<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
  @import url('https://fonts.googleapis.com/css2?family=Anton+SC&family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&display=swap');


  .container {
    text-align: center;
    margin-top: 5%;
    padding: 2rem;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
    margin-left: auto;
    margin-right: auto;
  }

  .form-title {
    font-family: 'anton sc', 'serif';
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
  }

  /* Input Group */
  .input-group {
    position: relative;
    margin-bottom: 1.5rem;
    /* padding-left: 1rem; */
  }

  .input-group i {
    position: absolute;
    top: 50%;
    right: 5%;
    transform: translateY(-50%);
    color: #7f8c8d;
  }

  .input-group input {
    width: 100%;
    padding: 1rem 0.5rem;
    font-size: 1rem;
    color: #333;
    background-color: #ecf0f1;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s ease;
  }

  input[type="text"]::placeholder{
    padding: 0 1em;
  }

  input[type="email"]::placeholder{
    padding: 0 1em;
  }

  input[type="password"]::placeholder{
    padding:0 1em;
  }


 
  /* Buttons */
  .btn {
    background-color: palevioletred;
    color: #fff;
    padding: 1rem 2rem;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
  }

  .btn:hover {
    background-color: #2980b9;
  }

  /* Links */
  .links {
    margin-top: 1rem;
    font-size: 1rem;
    color: pink;
  }

  .links p {
    margin: 0.5rem 0;
  }

  .links button {
    background-color: transparent;
    color: purple;
    border: none;
    cursor: pointer;
    text-decoration: underline;
  }

  .links button:hover {
    color: #2980b9;
  }

  /* Skip link */
  #skip_now {
    display: inline-block;
    margin-top: 1rem;
    color: #7f8c8d;
    text-decoration: none;
    font-size: 0.9rem;
  }

  #skip_now:hover {
    color: #3498db;
  }
</style>
</head>

<body>
    <div class="container" id="sign_up" style="display:none;">
      <h1 class="form-title">Register</h1>
      <form method="post" action="register.php">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="fName" id="fName" placeholder="First Name" required>
          
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lName" id="lName" placeholder="Last Name" required>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="abc@example.com" required>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
       <input type="submit" class="btn" value="Sign Up" name="signUp">
      </form>
      
      <div class="links">
        <p>Already Have Account ?</p>
        <button id="signinBtn">Sign In</button>
      </div>
    </div>

    <div class="container" id="sign_in">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="register.php">
          <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="abc@example.com" required>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
          </div>
          
         <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
       
        <div class="links">
          <p>Don't have account yet?</p>
          <button id="signupBtn">Sign Up</button>
        </div>
        <a href="../home.php" id="skip_now">Skip For Now</a>
      </div>
      <script src="script.js"></script>
</body>
</html>