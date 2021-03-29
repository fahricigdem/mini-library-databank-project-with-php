<?php 

// connect database and controll connection
include('config/db_connect.php');

//delete book by id
if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM sale WHERE id = $id_to_delete";

    if(mysqli_query($conn, $sql)){
        header('Location: sales.php');
    } else {
        echo 'query error: '. mysqli_error($conn);
    }

}

// check GET request id param
if(isset($_GET['id'])){
    
    // escape sql chars
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // make sql
    $sql = "SELECT s.id, b.name as book_name, b.price, c.name as customer_name, s.saled_at
    FROM books b, Customers c, sale s 
    WHERE b.id=s.book_id and c.id=s.customer_id and s.id=$id";

    // get the query result
    $result = mysqli_query($conn, $sql);

    // fetch result in array format
    $sale = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);

}


?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<div class="container center">
		<?php if($sale): ?>
			<h4>Sale ID: <?php echo htmlspecialchars($sale['id']); ?></h4>
            <p>Customer Name: <?php echo htmlspecialchars($sale['customer_name']); ?></p>
            <p>Saled Book's Name: <?php echo htmlspecialchars($sale['book_name']); ?></p>
			<p>Book Price: <?php echo htmlspecialchars($sale['price']); ?></p>
			<p>Saled at: <?php echo date(htmlspecialchars($sale['saled_at'])); ?></p>
            
            <br>

            <!-- UPDATE FORM -->
			
            <!-- <a class="brand-text" href="sale_update.php?id=<?php echo $book['id'] ?>">
                <div class="btn z-depth-0">UPDATE</div>
            </a> -->

			<!-- DELETE FORM -->
			<form action="sale_detail.php" method="POST">
				<input type="hidden" name="id_to_delete" value="<?php echo $sale['id']; ?>">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
			</form>

		<?php else: ?>
			<h5>No such book exists.</h5>
		<?php endif ?>
	</div>

<?php include('templates/footer.php'); ?>

</html>