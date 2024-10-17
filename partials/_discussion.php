<?php

require 'database/_connect.php';

$sql = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
    $cat_name = $row['ct_name'];
    $cat_desc = $row['ct_desc'];
    $cat_id = $row['ct_id'];
    echo '
        <div class="col-sm-6">
            <div class="card my-2">
                <div class="card-body">
                <h5 class="card-title">'.$cat_name.'</h5>
                <p class="card-text">'.$cat_desc.'</p>
                <a href="threadlist.php?cat_id='.$cat_id.'" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>        
    ';
}