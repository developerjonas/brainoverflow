<?php
require_once __DIR__ . '/_helpers.php';
require 'database/_connect.php';
$cat_id = positive_int($_GET['cat_id'] ?? null);
if ($cat_id === null) {
  http_response_code(404);
  exit('Category not found.');
}
// Keep category lookup parameterized and return a clear not-found response.
$statement = mysqli_prepare($conn, 'SELECT ct_name, ct_desc FROM `categories` WHERE ct_id = ?');
mysqli_stmt_bind_param($statement, 'i', $cat_id);
mysqli_stmt_execute($statement);
$category = mysqli_fetch_assoc(mysqli_stmt_get_result($statement));
if (!$category) {
  http_response_code(404);
  exit('Category not found.');
}
$cat_name = $category['ct_name'];
$cat_desc = $category['ct_desc'];

echo '
<section class="py-5 text-center container">
  <div class="row py-lg-5">
    <div class="col-lg-6 col-md-8 mx-auto">
      <h1 class="fw-light">' . h($cat_name) . '</h1>
      <p class="lead text-body-secondary">' . h($cat_desc) . '</p>
      <p>
        <a href="#" class="btn btn-primary my-2">Ask Questions</a>
        <a href="#" class="btn btn-success my-2">Code</a>
      </p>
    </div>
  </div>
</section>
';


?>