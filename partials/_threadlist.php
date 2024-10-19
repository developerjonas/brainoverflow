<?php


require 'database/_connect.php';
$cat_id = $_GET['cat_id'];
$sql = "SELECT * FROM `categories` WHERE ct_id=$cat_id";
$results = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($results)) {
  $cat_name = $row['ct_name'];
  $cat_desc = $row['ct_desc'];
}

echo '
<section class="py-5 text-center container">
  <div class="row py-lg-5">
    <div class="col-lg-6 col-md-8 mx-auto">
      <h1 class="fw-light">' . $cat_name . '</h1>
      <p class="lead text-body-secondary">' . $cat_desc . '</p>
      <p>
        <a href="#" class="btn btn-primary my-2">Ask Questions</a>
        <a href="#" class="btn btn-success my-2">Code</a>
      </p>
    </div>
  </div>
</section>
';


?>