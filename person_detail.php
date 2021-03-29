<?php 

// connect database and controll connection
include('config/db_connect.php');

//delete person by id
if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM Customers WHERE id = $id_to_delete";

    if(mysqli_query($conn, $sql)){
        header('Location: persons.php');
    } else {
        echo 'query error: '. mysqli_error($conn);
    }

}

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

        // make sql
        $sql2 = "SELECT ROUND (sum(books.price), 2)  as depth
        FROM ((sale 
        INNER JOIN Customers ON sale.customer_id = Customers.id)
        INNER JOIN books ON sale.book_id = books.id)       
        WHERE sale.customer_id=$id;
        
        ";

        // Select * from people p, address a where  p.id = a.person_id and a.zip='97229';

        // get the query result
        $result2 = mysqli_query($conn, $sql2);
    
        // fetch result in array format
        $person2 = mysqli_fetch_assoc($result2);
        mysqli_free_result($result2);


                   // make sql
        $sql3 = "SELECT books.name, books.price
        FROM ((sale 
        INNER JOIN Customers ON sale.customer_id = Customers.id)
        INNER JOIN books ON sale.book_id = books.id)       
        WHERE sale.customer_id=$id;
        
        ";

        // Select * from people p, address a where  p.id = a.person_id and a.zip='97229';

        // get the query result
        $result3 = mysqli_query($conn, $sql3);
    
        // fetch result in array format
        $person3 = mysqli_fetch_all($result3, MYSQLI_ASSOC);
        
        mysqli_free_result($result3);
    
    mysqli_close($conn);

}


?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<div class="container center">
		<?php if($person): ?>
			<h4>ID: <?php echo htmlspecialchars($person['id']); ?></h4>
			<p>Name: <?php echo htmlspecialchars($person['name']); ?></p>
			<h5>Faculty: <?php echo htmlspecialchars($person['faculty']); ?></h5>
            <h5>Email: <?php echo htmlspecialchars($person['email']); ?></h5>
            <h3>Total Depth: <?php echo htmlspecialchars($person2['depth']); ?> €</h3>
            <br>

 

            <!-- UPDATE FORM -->
			
            <a class="brand-text" href="person_update.php?id=<?php echo $person['id'] ?>">
                <div class="btn z-depth-0">UPDATE</div>
            </a>

			<!-- DELETE FORM -->
			<form action="person_detail.php" method="POST">
				<input type="hidden" name="id_to_delete" value="<?php echo $person['id']; ?>">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
			</form>


            <table class="table">
                <tr>
                    <th>Book Name</th>
                    <th>Price</th>
                </tr>

                <?php foreach($person3 as $i): ?>

                    <tr>            
                    <td><?php echo htmlspecialchars($i['name']); ?> </td>
                    <td><?php echo htmlspecialchars($i['price']);  ?></td>
                    </tr>

                <?php endforeach; ?>

             </table> 
             <br>

		<?php else: ?>
			<h5>No such person exists.</h5>
		<?php endif ?>



	</div>

<?php include('templates/footer.php'); ?>

</html>