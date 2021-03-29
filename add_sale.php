<?php

// connect database and controll connection
include('config/db_connect.php');

// initialize the variables
$book_id = $customer_id = '';
$errors = array('book_id' => '', 'customer_id' => '', 'out_of_list' => '');

// form validation
if(isset($_POST['submit'])){

    // check book_id
    if(empty($_POST['book_id'])){
        $errors['book_id'] = 'At least one ingredient is required <br />';
    } else{
        $book_id = $_POST['book_id'];
        if(!preg_match('/^[0-9]+$/', $book_id)){
            $errors['book_id'] = 'book_id must be a number';
        }}

    // check customer_id
    if(empty($_POST['customer_id'])){
        $errors['customer_id'] = 'At least one ingredient is required <br />';
    } else{
        $customer_id = $_POST['customer_id'];
        if(!preg_match('/^[0-9]+$/', $customer_id)){
            $errors['customer_id'] = 'customer_id must be a number';
        }}
    
    // submit the info into database
	if(array_filter($errors)){
			//echo errors in form';
	} else {
			// escape sql chars
			$book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
			$customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);

			// create sql
			$sql = "INSERT INTO sale(book_id,customer_id) VALUES('$book_id','$customer_id')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: sales.php');
			} else {
                $errors['out_of_list'] = 'Customer ID and Book ID must be in the Lists';
                // echo 'query error: '. mysqli_error($conn);
			}
	}

} // end POST check

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">Add a Sale!</h4>
    <form class="white" action="add_sale.php" method="POST">
        <div class="red-text"><?php echo $errors['out_of_list']; ?></div>
      
        <label>Customer ID</label>
        <input type="text" name="customer_id" value="<?php echo htmlspecialchars($customer_id) ?>">
        <div class="red-text"><?php echo $errors['customer_id']; ?></div>

        <label>Book ID</label>
        <input type="text" name="book_id" value="<?php echo htmlspecialchars($book_id) ?>" >
        <div class="red-text"><?php echo $errors['book_id']; ?></div>  
        
        <div class="center">
            <input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include('templates/footer.php'); ?>

</html>
