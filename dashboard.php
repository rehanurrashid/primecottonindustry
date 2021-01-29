<?php
    // We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard | Cotton</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
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
                    <h1 class="text-uppercase">Welcome <?= (isset($_SESSION['name']))? $_SESSION['name'] : ''; ?>!</h1>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div><!-- /#wrapper -->
</body>
</html>