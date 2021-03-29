<?php

    // connect database and controll connection
    include('config/db_connect.php');

    // write query
    $sql = "SELECT *
            FROM Customers c  
            ORDER BY c.name";

    // make query & get results
    $results = mysqli_query($conn,$sql);
    
    // fetching results as array
    $persons = mysqli_fetch_all($results, MYSQLI_ASSOC);
    
    // free results memory
    mysqli_free_result($results);

    // close connection
    mysqli_close($conn);

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<h4 class="center grey-text">Persons!</h4>

<div class="container">
<table class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Faculty</th>
            <th></th>
        </tr>

        <?php foreach($persons as $person): ?>

            <tr>
            <td><?php echo htmlspecialchars($person['id']); ?> </td>            
            <td><?php echo htmlspecialchars($person['name']); ?> </td>
            <td><?php echo htmlspecialchars($person['email']);  ?></td>
            <td><?php echo htmlspecialchars($person['faculty']);  ?></td>
            <td>
                <div class="card-action right-align">         
                    <a href="person_detail.php?id=<?php echo $person['id'] ?>">
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


