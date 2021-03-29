<?php

// connect database and controll connection
include('config/db_connect.php');

// initialize the variables
$name = $faculty = $email = '';
$errors = array('name' => '', 'faculty' => '', 'email' => '');

// form validation
if(isset($_POST['submit'])){

    // check email
    if(empty($_POST['email'])){
        $errors['email'] = 'An email is required <br />';
    } else{
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'unvalid email <br>';
        }
    }
    

    // check name
    if(empty($_POST['name'])){
        $errors['name'] = 'A name is required <br />';
    } else{
        $name = $_POST['name'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
            $errors['name'] = 'Unvalid Title : only letters and spaces are allowed <br>';
        }
    }

    // check faculty
    if(empty($_POST['faculty'])){
        $errors['faculty'] = 'At least one ingredient is required <br />';
    } else{
        $faculty = $_POST['faculty'];
        if(!preg_match('/^[1-5]+$/', $faculty)){
            $errors['faculty'] = 'Faculty must be between 1-5';
        }}
    
    // submit the info into database
	if(array_filter($errors)){
			//echo errors in form';
	} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$faculty = mysqli_real_escape_string($conn, $_POST['faculty']);

			// create sql
			$sql = "INSERT INTO Customers(name,email,faculty) VALUES('$name','$email','$faculty')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: persons.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
	}

} // end POST check

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">Add a Person</h4>
    <form class="white" action="add_person.php" method="POST">
        <label>Email</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name) ?>">
        <div class="red-text"><?php echo $errors['name']; ?></div>
        <label>Faculty</label>
        <input type="text" name="faculty" value="<?php echo htmlspecialchars($faculty) ?>" placeholder="1-5">
        <div class="red-text"><?php echo $errors['faculty']; ?></div>
        <div class="center">
            <input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include('templates/footer.php'); ?>

</html>
