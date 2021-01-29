<?php
    // We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
        header('Location: ../login.php');
        exit;
    }

    include_once 'connection.php';
    include_once 'objects/posts.php';

    $database = new DB();
    $db = $database->getConnection();
     
    $post = new Post($db);

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
        $stmt = $post->readAll();
        $num = $stmt->rowCount();
        
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
         
        }
         
        else{
            $products = array("message" => "No products found.");
        }
     }
// echo "<pre>", print_r($products);exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products | Cotton</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    
<!--===============================================================================================-->

<!--  DATATABLES CSS -->
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.jqueryui.min.css">
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
            <a class="navbar-brand" href="dashboard.php">
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
                        <form action="logout.php">
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
                    <a href="post.php"><i class="fa fa-list-alt"></i>&nbsp;&nbsp; Products</a>
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
                    <h3>Products</h3>
                </div>
            </div>
            <div style="display: none;" class="alert alert-success delete-response-true" role="alert">
                Product Deleted Successfully!
            </div>
            <div style="display: none;" class="alert alert-danger delete-response-false" role="alert">
                Something went wrong!
            </div>
            <div class="row add-new">
                <a href="post/add.php" class="btn btn-outline-dark">Add Product</a>
            </div>
            <div class="row">
                <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Name</th>
                <th>Excerpt</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; if(isset($posts_arr["records"]) && !empty($posts_arr["records"])): ?>
                <?php foreach($posts_arr["records"] as $key => $value): ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><a href="<?= 'post/read.php/?post_id='.$value['post_id']?>"><?php echo $value['post_title']; ?></a></td>
                        <?php  $first10words = implode(' ', array_slice(str_word_count($value['post_summary'],1), 0, 10)); ?>
                        <td><?php echo $first10words; ?></td>
                        <td><button class="btn btn-danger delete" data-id="<?php echo $value['post_id']; ?>">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Sr. No.</th>
                <th>Name</th>
                <th>Excerpt</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div><!-- /#wrapper -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Alert!</h3>
      </div>
      <div class="modal-body">
        Are you sure you want to delete product?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete">Delete</button>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {

    $('#example').DataTable( {
    } );

    //delete record
    $("body").on('click',"#example .delete",function(){
        jQuery("#exampleModal").modal('show') 
        $("#delete").attr('data-id', $(this).data('id'))       
    })

    $("body").on('click',"#delete",function(){
        let post_id = $(this).data('id');

        $.ajax({
            url: 'post/delete.php',
            method: 'GET',
            data:{ 'post_id':post_id},
            success: function(d){
                d = JSON.parse(d)
                console.log(d)
                if(d.Message === "True"){
                    $(".delete-response-true").show()
                }
                if(d.Message === "False"){
                    $(".delete-response-false").show()
                }
            }
        })      
    })

});

</script>

</body>
</html>