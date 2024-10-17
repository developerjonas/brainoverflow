<?php

require '_connect.php';

$sql = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
while($row){
    $cat = $row['ct_name'];
    echo '
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">'.$cat.'</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>        
    ';
}