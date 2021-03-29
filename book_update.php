<?php

// connect database and controll connection
include('config/db_connect.php');

// check GET request id param
if(isset($_GET['id'])){
    
    // escape sql chars
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // make sql
    $sql = "SELECT * FROM books WHERE id = $id";

    // get the query result
    $result = mysqli_query($conn, $sql);

    // fetch result in array format
    $book = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);

}

// initialize the variables
$id = $book['id'];
$isbn = $book['isbn'];
$name = $book['name'];
$author = $book['author'];
$price = $book['price'];
$errors = array('name' => '', 'author' => '', 'isbn' => '', 'price' => '');

// form validation
if(isset($_POST['submit'])){

    // check isbn
    if(empty($_POST['isbn'])){
        $errors['isbn'] = 'An isbn is required <br />';
        
        
    } else{
        $isbn = $_POST['isbn'];
        if(!preg_match('/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/', $isbn)){
            $errors['isbn'] = 'unvalid isbn <br>';
            
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

    // check author
    if(empty($_POST['author'])){
        $errors['author'] = 'An author is required <br />';
        
    } else{
        $author = $_POST['author'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $author)){
            $errors['author'] = 'Unvalid Author <br>';
            
        }
    }

    // check price
    if(empty($_POST['price'])){
        $errors['price'] = 'A price is required <br />';
        
    } else{
        $price = $_POST['price'];
        if(!preg_match('/^[0-9]*\.?[0-9]{2}+$/', $price)){
            $errors['price'] = 'price is unvalid';
            
        }}

    // update the info of the book
	if(array_filter($errors)){
			//echo 'errors in form';
            $id=mysqli_real_escape_string($conn, $_POST['id']);
	} else {
			// escape sql chars
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$price = mysqli_real_escape_string($conn, $_POST['price']);
            $author = mysqli_real_escape_string($conn, $_POST['author']);

            $sql = "UPDATE `books` SET 
            `id` = '$id',
            `isbn` = '$isbn', 
            `name` = '$name',
            `author` = '$author', 
            `price` = '$price' 
            where `id`=".$id ;

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: books.php');
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
    <h4 class="center">Update a Book</h4>
    <form class="white" action="book_update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id) ?>">
        <label>isbn</label>
        <input type="text" name="isbn" value="<?php echo htmlspecialchars($isbn) ?>">
        <div class="red-text"><?php echo $errors['isbn']; ?></div>
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name) ?>">
        <div class="red-text"><?php echo $errors['name']; ?></div>
        <label>Author</label>
        <input type="text" name="author" value="<?php echo htmlspecialchars($author) ?>">
        <div class="red-text"><?php echo $errors['author']; ?></div>
        <label>Price</label>
        <input type="text" name="price" value="<?php echo htmlspecialchars($price) ?>" >
        <div class="red-text"><?php echo $errors['price']; ?></div>
        <div class="center">
            <input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
        </div>
        

    </form>
</section>
 
<?php include('templates/footer.php'); ?>

</html>