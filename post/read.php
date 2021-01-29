<?php


// We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
        header('Location: ../login.php');
        exit;
    }

    // get database connection
    include_once '../connection.php';
     
    // instantiate object
    include_once '../objects/posts.php';
    
    // get uload file function
    include_once '../objects/upload.php';

    $database = new DB();
    $db = $database->getConnection();
     
    $post = new Post($db);

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    if(!empty($_GET['user_id']) && empty($_GET['post_id']))
        {
    	    $stmt = $post->readAll($user_id);
            $num = $stmt->rowCount();
        }
    else 
        if(!empty($_GET['post_id']))
        {
            $stmt = $post->readPost($_GET['post_id']);
            $num = $stmt->rowCount();
           // echo "Success row_count=$num for post_id=".$post_id;
        }
        
        //echo $num;
        
        // check if more than 0 record found
    if($num>0){
            
            // products array
            $posts_arr=array();
            $posts_arr["records"]=array();
         
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                
                $post_item=array(
                    "post_id" => $ID,
                    "author_id" => $post_author,
                    "post_url" => $post_url,
                    "post_title" => html_entity_decode($post_title),
                    "post_summary" => $content,
                    "post_thumbnail" => $thumbnail,
                    "post_publish_datetime" => $publish_date,
                    "post_update_datetime" => $modified_date,
                    "post_type" => $post_type,
                    "post_status" => $post_status,
                    "thumbnail" => $thumbnail,
                );
         
                array_push($posts_arr["records"], $post_item);
            }
         
            // echo "<pre>", print_r($post_item);exit;
        }
         
        else{
            $products = array("message" => "No products found.");
        }
     }

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    // uploading image
    if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
        $file = new Upload();
        $file = $file->upload_image($_FILES['image']);
        if($file['Status'] == "OK"){
            $post->post_thumbnail =  $file['Message'];
        }

            
    }
    else{
         $post->post_thumbnail =  $_POST['thumbnail'];

    }

    // set product property values
    $post->post_id = (isset($_POST['post_id']))? $_POST['post_id'] : die();
    $post->user_id =  (isset($_SESSION['id']))? $_SESSION['id'] : die();
    $post->post_title =  (isset($_POST['title']))? $_POST['title'] : '';
    $post->post_summary = (isset($_POST['description']))? $_POST['description'] : '';
    // $post->post_publish_datetime = date('Y-m-d');
    $post->post_update_datetime = date('Y-m-d');

    // $post->post_type = "product";
    // $post->post_status = "publish";
    $post->post_url = '';


// echo "<pre>", print_r($post);exit;
    // create
    if($post->update()){
        $create =array(

            "message"   => "True"
        );

        $stmt = $post->readPost($post->post_id);
        $num = $stmt->rowCount();
        if($num>0){
            
            // products array
            $posts_arr=array();
            $posts_arr["records"]=array();
         
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                
                $post_item=array(
                    "post_id" => $ID,
                    "author_id" => $post_author,
                    "post_url" => $post_url,
                    "post_title" => html_entity_decode($post_title),
                    "post_summary" => $content,
                    "post_thumbnail" => $thumbnail,
                    "post_publish_datetime" => $publish_date,
                    "post_update_datetime" => $modified_date,
                    "post_type" => $post_type,
                    "post_status" => $post_status,
                    "thumbnail" => $thumbnail,
                );
         
                array_push($posts_arr["records"], $post_item);
            }
         
            // echo "<pre>", print_r($post_item);exit;
        }
         
        else{
            $products = array("message" => "No products found.");
        }
    }
     
    // if unable to create
    else{
        $create =array(
        "message"   => "False"
    );
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Product | Cotton</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="../../images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="../../css/dashboard.css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
<!--===============================================================================================-->
</head>
<body>
<div id="throbber" style="display:none; min-height:120px;"></div>
<div id="noty-holder"></div>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../../dashboard.php">
                <img src="http://placehold.it/200x50&text=LOGO" alt="LOGO">
            </a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">         
            <li class="dropdown">
                <a href="#" class="dropdown-toggle text-uppercase" data-toggle="dropdown">
                    <?= (isset($_SESSION['name']))? $_SESSION['name'] : ''; ?>
                    &nbsp;<b class="fa fa-angle-down"></b>&nbsp;</a>
                <ul class="dropdown-menu">
<!--                     <li><a href="#"><i class="fa fa-fw fa-cog"></i> Change Password</a></li> -->
                    <!-- <li class="divider"></li> -->
                    <li class="text-center text-capitalize logout-dropdown">
                        <form action="../../logout.php">
                            <label for="logout" style="cursor: pointer;"><i class="fa fa-fw fa-power-off"></i>&nbsp;&nbsp;Logout</label>
                            <input type="submit" value="Logout"  id="logout">
                        </form>
                        
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a href="../../post.php"><i class="fa fa-list-alt"></i>&nbsp;&nbsp; Products</a>
                </li>
                <!-- <li>
                    <a href="faq"><i class="fa fa-envelope"></i>&nbsp;&nbsp; Messages</a>
                </li> -->
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row" id="main" >
                <div class="col-sm-12 col-md-12 well" id="content">
                    <h1 class="text-uppercase">Update Product</h1>
                </div>
            </div>
            <div id="add-form">
                <div class="col-sm-8 col-md-8">
                    <?php if(isset($create) && !empty($create)): ?>

                        <?php if($create['message'] == "True"): ?>
                        <div class="alert alert-success" role="alert">
                            Product Updated Successfully!
                        </div>
                        <?php endif; ?>

                        <?php if($create['message'] == "False"): ?>
                        <div class="alert alert-danger" role="alert">
                            Something went wrong!
                        </div>
                        <?php endif; ?>

                    <?php endif; ?>
                    <div class="row">
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" value="<?= (isset($post_item['post_id']))?$post_item['post_id']:'' ?>" name="post_id" >
                    <input type="hidden" value="<?= (isset($post_item['thumbnail']))?$post_item['thumbnail']:'' ?>" name="thumbnail" >
                  <div class="form-group">
                    <label for="formGroupExampleInput">Title</label>
                    <input type="text" class="form-control" placeholder="Enter Title" required="" name="title" value="<?= (isset($post_item['post_title']))?$post_item['post_title']:'' ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea class="form-control"  rows="6" required="" placeholder="Write Description" name="description"><?= (isset($post_item['post_summary']))?$post_item['post_summary']:'' ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="image-upload" id="image-upload-label">
                        Upload Product Image (.png, jpeg)
                        <img src="https://img.icons8.com/pastel-glyph/64/000000/upload.png"/></label>
                    <input type="file" name="image" accept="image/png, image/jpeg" id="image-upload" >
                  </div>

                  <div class="form-group">
                    <img src="<?= (isset($post_item['thumbnail']))? '../upload/images/'.$post_item['thumbnail']:'../../images/placeholder.png' ?>" alt="" width="350px" class="img-thumbnail" id="image_output" >
                    </div>
                  <div class="form-group add-new">
                    <input type="submit" value="Update" class="btn btn-dark pull-right">
                  </div>
                </form>
            </div>  
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<script src="../../js/main.js"></script>
</body>
</html>