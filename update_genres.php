<?php
session_start();
require_once('classes/database.php');
$con = new database();
 $sweetAlertConfig = ""; 


if(empty($id = $_POST['id'])) {
 
 
 
    header('location:index.php');
 
} else {
 
    $id = $_POST['id'];
    $data = $con->viewGenreID($id);
 
}
 
 
 if (isset($_POST['update'])) {
     $genreName = $_POST['genreName'];
     $id=$_POST['id'];

$genresID= $con->updateGenres($genreName, $id);

if ($genresID){
    $sweetAlertConfig = "
    <script>
    Swal.fire({
      icon: 'success',
      title: 'Genre Updated',
      text: 'Updated Successfully!',
      confirmButtonText: 'OK'
    }).then((result) => {
    if (result.isConfirmed) {
    window.location.href = 'admin_homepage.php';
    }
    });
    </script> ";

  }else{
    $_SESSION['error'] = "Sorry, there was an error adding.";
  }
 

}
 
 
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./package/dist/sweetalert2.css">
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <title>Genres</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Library Management System (Admin)</a>
    <a class="btn btn-outline-light ms-auto" href="add_authors.html">Add Authors</a>
    <a class="btn btn-outline-light ms-2 active" href="add_genres.html">Add Genres</a>
    <a class="btn btn-outline-light ms-2" href="add_books.html">Add Books</a>
  </div>
</nav>

<div class="container my-5 border border-2 rounded-3 shadow p-4 bg-light">
  <h4 class="mt-5">Update New Genre</h4>
  <form id="genreForm" method="POST" action="">
      <div class="mb-3">
      <label for="genreName" class="form-label">Genre Name</label>
      <input type="text" value="<?php echo $data['genre_name']?>" name="genreName" class="form-control" id="genreName" required>
      <div class="invalid-feedback">Please enter a valid genre.</div>
    </div>
    <div class="mb-3">
      <label for="id" class="form-label"></label>
      <input type="hidden" value="<?php echo $data['genre_id']?>" name="id" class="form-control" id="id" required>
      <div class="invalid-feedback"></div>
    </div>
    <button type="submit"  id="submitButton" name="update" class="btn btn-primary">Add Genre</button>
  </form>

  <script src="./package/dist/sweetalert2.js"></script>
  <?php echo $sweetAlertConfig; ?>
</div>

<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>