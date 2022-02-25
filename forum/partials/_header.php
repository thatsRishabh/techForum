<?php

session_start();
echo '
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
 <div class="container-fluid">
   <a class="navbar-brand" href="/forum">IDiscuss</a>
   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
     <span class="navbar-toggler-icon"></span>
   </button>
   <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav me-auto mb-2 mb-lg-0">
       <li class="nav-item">
         <a class="nav-link active" aria-current="page" href="/forum">Home</a>
       </li>
       <li class="nav-item">
         <a class="nav-link" href="about.php">About</a>
       </li>
       <li class="nav-item dropdown">
         <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Top Categories
         </a>
         <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

         $sql = "SELECT category_name, category_id FROM `categories` LIMIT 3";
         $result = mysqli_query($conn, $sql); 
         while($row = mysqli_fetch_assoc($result)){
           echo '<li><a class="dropdown-item" href="threadlist.php?catid='. $row['category_id']. '">' . $row['category_name']. '</a></li>'; 
         }

           
           
        echo '</ul>
       </li>
       <li class="nav-item">
         <a class="nav-link" href="contact.php" tabindex="-1" aria-disabled="true">Contact</a>
       </li>
     </ul> ';
 if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo '

      <!-- search querry will be passed from here -->
      <form class="d-flex" method="get" action="search.php">
      <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>

      <!--  below will display the username after login-->
      <p class="text-light my-0 mx-2" style="width: 114%;">Welcome '. $_SESSION['useremail']. ' </p>

      <!--  below is logout code-->
      <a href="partials/_logout.php" class="btn btn-primary mx-2" >Logout</a>
    </form>
';}
else{ 
  echo '
     <form class="d-flex" method="get" action="search.php">
     <!-- this will pass to search.php page-->
     <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
     <button class="btn btn-outline-success" type="submit">Search</button>
   </form>

   <!-- in below buttons data-bs-toggle &data-bs-target will activate modal component -->

   <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
   <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#signupModal">SignUP</button>
';
}  
 echo'</div>
</nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

// $_GET function to get parameter from URL and "isset" is to check if parameter is set or not
// hover over function in VC code or search in PHP documentation .
// Below code will execute when client does Sign UP
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You can now login
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
?>