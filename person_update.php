<?php

// connect database and controll connection
include('config/db_connect.php');

// check GET request id param
if(isset($_GET['id'])){
    
    // escape sql chars
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // make sql
    $sql = "SELECT * FROM Customers WHERE id = $id";

    // get the query result
    $result = mysqli_query($conn, $sql);

    // fetch result in array format
    $person = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);

}

// initialize the variables
$id = $person['id'];
$name = $person['name'];
$email = $person['email'];
$faculty = $person['faculty'];
$errors = array('name' => '', 'email' => '', 'faculty' => '');

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

    // update the info of the person
	if(array_filter($errors)){
			//echo 'errors in form';
            $id = $_POST['id'];
	} else {
			// escape sql chars
            $id = $_POST['id'];
            $email = mysqli_real_escape_string($conn, $_POST['email']);
			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$faculty = mysqli_real_escape_string($conn, $_POST['faculty']);

            $sql = "UPDATE `Customers` SET 
            `email` = '$email', 
            `name` = '$name',
            `faculty` = '$faculty'  
            where `id`=".$id ;

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
<html lang="en">

<?php include('templates/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">Update a Person</h4>
    <form class="white" action="person_update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name) ?>">
        <div class="red-text"><?php echo $errors['name']; ?></div>
        <label>Email</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>
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