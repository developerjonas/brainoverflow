<?php
echo '



<nav class="navbar navbar-expand-lg navbar-dark bg-secondary rounded">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample10">
        <ul class="navbar-nav">';
include 'database/_connect.php';
$sql  = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $cat_id = $row['ct_id'];
    echo '
           <li class="nav-item">
            <a class="nav-link" href="threadlist.php?cat_id='.$cat_id.'">' . $row['ct_name'] . '</a>
           </li>
           ';
}
echo '
        </ul>
    </div>
</nav>
';
