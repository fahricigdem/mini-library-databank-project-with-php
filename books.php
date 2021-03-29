<?php

    // connect database and controll connection
    include('config/db_connect.php');

    // write query
    $sql = "SELECT *
            FROM books  
            ORDER BY added_at";

    // make query & get results
    $results = mysqli_query($conn,$sql);
    
    // fetching results as array
    $books = mysqli_fetch_all($results, MYSQLI_ASSOC);
    
    // free results memory
    mysqli_free_result($results);

    // close connection
    mysqli_close($conn);

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<h4 class="center grey-text">Books!</h4>

<div class="container">
<table class="table">
        <tr>
            <th>ID</th>
            <th>Book Name</th>
            <th>Book Author</th>
            <th>Price</th>
            <th></th>
        </tr>

        <?php foreach($books as $book): ?>

            <tr> 
            <td><?php echo htmlspecialchars($book['id']); ?> </td>           
            <td><?php echo htmlspecialchars($book['name']); ?> </td>
            <td><?php echo htmlspecialchars($book['author']);  ?></td>
            <td><?php echo htmlspecialchars($book['price']);  ?> € </td>
            <td>
            <div class="card-action right-align">         
                    <a href="book_detail.php?id=<?php echo $book['id'] ?>">
                        <span class="yellow badge blue">more info</span>
                    </a>
                </div>
            
            </td> 
            </tr>
            

        <?php endforeach; ?>

        </table>    
</div>

<?php include('templates/footer.php'); ?>

</html>


