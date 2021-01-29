<?php


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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link href="css/style.css" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">


  <title>Prime Cotton</title>
</head>

<body>
  <section class="main-section">
    <nav class="navbar navbar-expand-lg navbar-light  bg-nav">
      <div class="container">
        <a class="navbar-brand" href="#"><img src="images/logo.png" class="img-fluid" width="40"> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto ">
            <li class="nav-item">
              <a class="nav-link text-white active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#about">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#product">Our Product</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#testimonial">Testimonial</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#contact">Contact Us</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </section>
  <!-- =======================================About Us============================== -->
  <section class="mt-5" id="about">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="color-1 font-weight-bold text-center">About Us</h2>
          <div class="inner">&nbsp;</div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-md-6">
          <img src="images/about.png" class="img-fluid">
        </div>
        <div class="col-md-6">
          <p class="size-1 mt-3">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint necessitatibus ullam eligendi consequuntur?
            Optio ex obcaecati pariatur sapiente minima cumque nulla! Eius neque voluptatum distinctio nulla magnam
            deserunt ad odio!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo consectetur repellendus officia quae,
            consequuntur necessitatibus, ad laudantium eveniet velit similique vero eum praesentium soluta asperiores
            iure qui modi ipsam error. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, molestiae
            sed deleniti neque enim ullam? Error odio voluptas placeat deserunt reprehenderit quis unde impedit cum quam
            maiores accusamus, dolorum quidem?
          </p>
          <button class="btn btn-contact">Contact Us</button>
        </div>
      </div>
    </div>
  </section>
  <!-- ======================================Our Products============================= -->
  <section class="mt-5" id="product">
    <div class="container">
      <div class="row pt-5">
        <div class="col-md-12">
          <h2 class="color-1 font-weight-bold text-center">Our Products</h2>
          <div class="inner">&nbsp;</div>
        </div>
      </div>

      <div class="row mt-5">
        <?php $count = 1; if(isset($posts_arr["records"]) && !empty($posts_arr["records"])): ?>
                <?php foreach($posts_arr["records"] as $key => $value): ?>
                  <?php if($count < 4): 

                    if($count == 2){
                      $class = 'margin-1';
                    }
                    else if($count == 3){
                      $class = 'margin-2';
                    }

                  ?>
                  <div class="col-md-4 <?= $class; ?> ">

                    <img src="<?= (isset($value['thumbnail']))? 'post/upload/images/'.$value['thumbnail']:'/images/placeholder.png' ?>" class="img-fluid">

                    <h6 class="mt-3 font-weight-bold"><?php echo $value['post_title']; ?></h6>
                    <?php  $first10words = implode(' ', array_slice(str_word_count($value['post_summary'],1), 0, 20)); ?>

                    <p class="size-2"><?php echo $first10words; ?></p>
                  </div>
                <?php endif; ?>
            <?php $count++; endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="row" id="btnn">
        <div class="col-md-12">
          <div class="text-center">
            <button class="btn btn-contact " onclick=" ShowElement()">See more <i
                class="fas fa-long-arrow-alt-right ml-2"></i></button>
          </div>
        </div>
      </div>
      <div class="row mt-5" style="display: none;" id="roww">
        <?php $count = 1; if(isset($posts_arr["records"]) && !empty($posts_arr["records"])): ?>
                <?php foreach($posts_arr["records"] as $key => $value): ?>
                  <?php if($count > 3): ?>
                  <div class="col-md-4">

                    <img src="<?= (isset($value['thumbnail']))? 'post/upload/images/'.$value['thumbnail']:'/images/placeholder.png' ?>" class="img-fluid">

                    <h6 class="mt-3 font-weight-bold"><?php echo $value['post_title']; ?></h6>
                    <?php  $first10words = implode(' ', array_slice(str_word_count($value['post_summary'],1), 0, 10)); ?>
                    <p class="size-2"><?php echo $first10words; ?></p>
                  </div>
              <?php endif; ?>
            <?php $count++; endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- ========================================Testimonial================================ -->
  <section class="mt-5 tesi-section" id="testimonial">
    <div class="container">
      <div class="row pt-5">
        <div class="col-md-12">
          <h2 class="color-1 font-weight-bold text-center">Testimonial</h2>
          <div class="inner">&nbsp;</div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="offset-md-1 col-md-4">
          <div class="card bg-white card-style" >
            <div class="card-body">
              <div class="row bg-white w-75 p-2 mt-2 custom-row">
                <div class="col-4">
                  <img src="images/user.png" class="img-fluid">

                </div>
                <div class="col-6 pl-0">
                  <h6 class="mt-1 font-weight-bold">John Doe</h6>
                  <h6 class="size-2 font-weight-normal">Senior SMT</h6>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-10 offset-1 pt-5">
                 <p class="size-2 ">"Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic repellat doloribus esse iure, excepturi delectus itaque error"</p> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-end mt-md-0 mt-4">
        <div class="col-md-4">
          <div class="card bg-white card-style" >
            <div class="card-body">
              <div class="row bg-white w-75 p-2 mt-2 custom-row">
                <div class="col-4">
                  <img src="images/user.png" class="img-fluid">

                </div>
                <div class="col-6 pl-0">
                  <h6 class="mt-1 font-weight-bold">John Doe</h6>
                  <h6 class="size-2 font-weight-normal">Senior SMT</h6>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-10 offset-1 pt-5">
                 <p class="size-2 ">"Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic repellat doloribus esse iure, excepturi delectus itaque error"</p> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mb-5 pb-5 mt-md-0 mt-4">
        <div class="offset-md-1 col-md-4">
          <div class="card bg-white card-style" >
            <div class="card-body">
              <div class="row bg-white w-75 p-2 mt-2 custom-row">
                <div class="col-4">
                  <img src="images/user.png" class="img-fluid">

                </div>
                <div class="col-6 pl-0">
                  <h6 class="mt-1 font-weight-bold">John Doe</h6>
                  <h6 class="size-2 font-weight-normal">Senior SMT</h6>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-10 offset-1 pt-5">
                 <p class="size-2 ">"Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic repellat doloribus esse iure, excepturi delectus itaque error"</p> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ===========================================Contact Us================================ -->
  <section class="mt-5" id="contact">
    <div class="container">
      <div class="row pt-5 justify-content-center">
        <div class="col-md-8">
          <h2 class="color-1 font-weight-bold text-center">Contact Us</h2>
          <div class="inner">&nbsp;</div>
          <p class="size-2 mt-4 text-center">Lorem ipsum dolotus cum nihil ea aut ratione modi perferendis. Lorem ipsum
            dolor sit amet consectetur adipisicing elit. Asperiores maxime quasi voluptatum. Esse molestiae, voluptatum
            iste quam distinctio architecto maxime corrupti eligendi, rerum commodi totam quas nisi, est hic? Eum?</p>
        </div>
      </div>
      <form action="contact_us.php" method="POST" >
        <div class="row justify-content-center mt-5">
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control input-style"  aria-describedby="emailHelp"
                placeholder="Name" name="name" required="required">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <input type="Email" class="form-control input-style"  aria-describedby="emailHelp"
                placeholder="Email Address" name="email" required="required">
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="form-group mt-4">
              <textarea class="form-control input-style" rows="8" placeholder="Description.." name="description"  required="required"></textarea>
            </div>
          </div>
        </div>
        <div class="row justify-content-center mt-5 mb-5">
          <div class="col-md-8">
            <div class="text-center">
              <button type="submit" class="btn btn-send">Send</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
  <section class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-1">
                <div class="text-center text-md-left text-white">
                    Copyright &copy; By Prime Cotton Industry 2021. All Rights Reserved.
                </div>
            </div>
            <div class="col-md-6 mt-1">
                <div class="text-center text-md-right">
                    <a href="#" class="ml-3 text-decoration-none text-white">Home</a>
                    <a href="#about" class="ml-3 text-decoration-none text-white">About us</a>
                    <a href="#product" class="ml-3 text-decoration-none text-white">Our Products</a>
                    <a href="#testimonial" class="ml-3 text-decoration-none text-white">Testominal</a>
                    <a href="#contact" class="ml-3 text-decoration-none text-white">Contact Us</a>

                </div>

            </div>
        </div>
    </div>
</section>
  <script>
    function ShowElement() {
      document.getElementById('btnn').style.display = 'none';
      document.getElementById('roww').style.display = 'flex';
    }
  </script>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
</body>

</html>