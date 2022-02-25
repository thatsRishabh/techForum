<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>

    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id"; 
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        // retriving datas from db
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        // Insert into thread db
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

        // str_replace function is used to prevent our website from XSS Attack. Read php doc to know how to use str_replace
        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title); 
        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc); 
        
        $sno = $_POST['sno'];

        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ( '$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;

        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!!</strong> Your thread has been added! Please wait for community to respond
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

                  
        } 
    }
    ?>

    <div class="container my-3 mx-auto" style="width: 50%;">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname;?> forums</h1>
            <p class="lead"><?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
                <p>Posted by: <em> Rishabh</em></p>
        </div>
    </div>
    <hr>

    <!-- Allowing user to post the comment -->
   <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){ 
    echo '
    <div class="container my-3 mx-auto" style="width: 50%;">
        <form action="'. $_SERVER["REQUEST_URI"] . '" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Please keep your question as small as possible</div>
            </div>
            <input type="hidden" name="sno" value="'. $_SESSION["sno"]. '">
            <!-- the above comment is for identifying user with serial number & this is passed via session from login.php -->
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>';
    }
    else{
        echo '   
        <div class="container mx-auto"  style="width: 50%; ">
        <h1 class="py-2">Start a Discussion</h1> 
           <p class="lead">You are not logged in. Please login to be able to post comments.</p>
        </div>
        ';
    }
    ?>

    <!-- question section -->
    <div class="container my-3 mx-auto" id="ques" style="width: 50%;">
        <h2 class="py-2">Browse Questions</h2>


        <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id"; 
    // above code will select specific to python,javascript, react categories
    $result = mysqli_query($conn, $sql);
    $noResult= true;
    while($row = mysqli_fetch_assoc($result)){
        $noResult= false;
        // here were are again using $id variable(overiding it) just inside the bracket
        $id = $row['thread_id'];
        $title = $row['thread_title'];
        $desc = $row['thread_desc']; 
        $thread_time = $row['timestamp'];
        $thread_user_id = $row['thread_user_id']; 

        $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);

        
        echo '<div class="d-flex align-items-center my-2">
            <div class="flex-shrink-0">
                <img src="/forum/partials/user.png" width="75px" alt="...">
            </div>
            <div class="flex-grow-1 ms-3">
            <p><b>Asked by: '. $row2['user_email'] . ' at '. $thread_time. '</b></p>
                <h5><a class="text-dark" href="thread.php?threadid=' . $id. '">'. $title . ' </a></h5>
                '. $desc . ' 
            </div>
        </div>';}

        // echo var_dump($noResult);
        if($noResult){
            echo'
            <p class="lead">
                No Questions, be the first person to ask the question.
            </p>';
        }
        ?>




        <?php include 'partials/_footer.php'; ?>
        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>