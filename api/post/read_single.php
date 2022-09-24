<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get ID
  $post->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $result = $post->single_post();

  $num = $result->rowCount();

 if($num > 0){
  $row = $result->fetch(PDO::FETCH_ASSOC);

  // Create array
  $post_arr = array(
    'id' => $post->id,
    'title' => $row['title'],
    'body' => $row['body'],
    'author' => $row['author'],
    'category_id' => $row['category_id'],
    'category_name' => $row['category_name']
  );

  // Make JSON
  echo json_encode($post_arr);
 }
 else{
   // No Posts
   echo json_encode(
    array('message' => 'No Posts Found')
  );
 }

  