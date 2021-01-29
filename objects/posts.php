<?php

header("Content-Type: text/html;charset=UTF-8");

class Post{
 
    // database connection and table name
    private $conn;
    private $table_name = "wp_posts";
 
    // object properties
    
    public $post_id;
    public $user_id;
    public $post_title;
    public $post_summary;
    public $post_url;
    public $post_thumbnail;
    public $post_publish_datetime;
    public $post_update_datetime;
    public $post_type;
    public $post_status;
 
    // constructor with $db as database connection
    public function __construct($db){
         
        $this->conn = $db;
        
    }
    
    
    // read all posts with like dislike data.
    function readAll(){
        
        //echo "Rechord From : $rec_from";
        
        $query =  "SELECT  *
        
            from wp_posts
            
            ORDER BY ID DESC";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    
    // read all posts with like dislike data.
    function readPost($_post_id){
            
        $query =  "SELECT  *
                
            from wp_posts
            
            where wp_posts.ID=$_post_id";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    
   
    public function create()
    {

      $query = "INSERT INTO wp_posts (post_author, publish_date, modified_date, post_title, post_url, content, post_type, post_status, thumbnail) VALUES ('$this->user_id', '$this->post_publish_datetime', '$this->post_update_datetime', '$this->post_title', '$this->post_url', '$this->post_summary', '$this->post_type', '$this->post_status', '$this->post_thumbnail')";
        // prepare query

        $stmt = $this->conn->prepare($query);
       
        //echo "\n $query \n";
        // echo "<pre>", print_r($stmt);exit;
        // execute query
        if($stmt->execute())
        {
            // $id = $this->conn->lastInsertId();

            return true;
        }
        return false;
    }

    public function update()
    {

      $query = "UPDATE wp_posts SET 
                    post_author = '$this->user_id',
                    modified_date = '$this->post_update_datetime',
                    post_url = '$this->post_url',
                    content = '$this->post_summary',
                    thumbnail = '$this->post_thumbnail',
                    post_title = '$this->post_title'
                WHERE ID=$this->post_id";

        // prepare query
// echo "<pre>", print_r($query);exit;
        $stmt = $this->conn->prepare($query);
       
        //echo "\n $query \n";
        // echo "<pre>", print_r($stmt);exit;
        // execute query
        if($stmt->execute())
        {
            $id = $this->conn->lastInsertId();

            return true;
        }
        return false;
    }

    public function delete_post($post_id)
    {
        // select post query
        $select_post = "SELECT * FROM " . $this->table_name." WHERE ID = ".$post_id ;
        $stmt = $this->conn->prepare($select_post);
        $stmt->execute();
        
        if($stmt->rowCount() > 0)
        {
            // query to delete record
            $query = "DELETE FROM
                        " . $this->table_name 
                    ." WHERE
                        ID = ".$post_id ;
            // prepare query
            $stmt = $this->conn->prepare($query);
            
            // execute query
            if($stmt->execute())
            {
                return true;
            }
            return false;
        } 
        else
        {
            return false;
        }
        
    }    

};
