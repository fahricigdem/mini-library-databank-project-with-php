<?php

    // connect database and controll connection
    include('config/db_connect.php');

    // write query
    $sql = "SELECT s.id, b.name as book_name, b.price, c.name as customer_name, s.saled_at
            FROM books b, Customers c, sale s 
            WHERE b.id=s.book_id and c.id=s.customer_id";

    // make query & get results
    $results = mysqli_query($conn,$sql);
    
    // fetching results as array
    $sales = mysqli_fetch_all($results, MYSQLI_ASSOC);
    
    // free results memory
    mysqli_free_result($results);

    // close connection
    mysqli_close($conn);

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<div class="container">

<h4 class="center grey-text">Sales!</h4>

    <table class="table">
        <tr>
            <th>Sale ID</th>
            <th>Customer Name</th>
            <th>Book Name</th>
            <th>Price</th>
        </tr>

        <?php foreach($sales as $sale): ?>

            <tr>            
            <td><?php echo htmlspecialchars($sale['id']); ?> </td>
            <td><?php echo htmlspecialchars($sale['customer_name']);  ?></td>
            <td><?php echo htmlspecialchars($sale['book_name']); ?> </td>
            <td><?php echo htmlspecialchars($sale['price']);  ?></td>
            <td>
                <div class="card-action right-align">         
                    <a href="sale_detail.php?id=<?php echo $sale['id'] ?>">
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


