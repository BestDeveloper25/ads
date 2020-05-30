<?php
// initializing variables
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'hedtella_417mark','43__17DonZy', 'hedtella_bluad');

// REGISTER USER
if (isset($_POST['reg_user']))
{
  // receive all input values from the form
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM emailmanagement WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user)
	{ // if user exists

    if ($user['email'] === $email)
		{
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO emailmanagement (email, password) 
  			  VALUES('$email', '$password')";
  	mysqli_query($db, $query);
  	header('location: signup_successful.php');
  }
}

?>