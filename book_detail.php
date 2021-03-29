<?php 

// connect database and controll connection
include('config/db_connect.php');

//delete book by id
if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM books WHERE id = $id_to_delete";

    if(mysqli_query($conn, $sql)){
        header('Location: books.php');
    } else {
        echo 'query error: '. mysqli_error($conn);
    }

}

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


?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<div class="container center">
		<?php if($book): ?>
			<h4>ID: <?php echo htmlspecialchars($book['id']); ?></h4>
			<p>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
			<p>Added at: <?php echo date(htmlspecialchars($book['added_at'])); ?></p>
			<h5>Name: <?php echo htmlspecialchars($book['name']); ?></h5>
            <h5>Author: <?php echo htmlspecialchars($book['author']); ?></h5>
            <br>

            <!-- UPDATE FORM -->
			
            <a class="brand-text" href="book_update.php?id=<?php echo $book['id'] ?>">
                <div class="btn z-depth-0">UPDATE</div>
            </a>

			<!-- DELETE FORM -->
			<form action="book_detail.php" method="POST">
				<input type="hidden" name="id_to_delete" value="<?php echo $book['id']; ?>">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
			</form>

		<?php else: ?>
			<h5>No such book exists.</h5>
		<?php endif ?>
	</div>

<?php include('templates/footer.php'); ?>

</html>