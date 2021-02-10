<?php
$video = $_POST['Video'];
$title = $_POST['Title'];
$year = $_POST['Year'];
$genre = $_POST['Genre'];
$plot = $_POST['Plot'];
$poster = $_POST['Poster'];
$runtime = $_POST['Runtime'];
$awards = $_POST['Awards'];
$actors = $_POST['Actors'];
$imdbVotes = $_POST['imdbVotes'];
$imdbRating = $_POST['imdbRating'];

require_once('../wp-load.php');
require_once ABSPATH . '/wp-admin/includes/taxonomy.php';

//Check if category already exists
$cat_ID = get_cat_ID( $genre );

//If it doesn't exist create new category
if($cat_ID == 0) {
    $cat_name = array('cat_name' => $genre);
    wp_insert_category($cat_name);
}

$postType = 'post';
$userId = 1;
$postStatus = 'publish';
$categoryId = 19;
$leadTitle = $title.' '.' ('.$year.')';

$leadContent .=
     '<p>'.$video.'</p>
     <p>'.$plot.'</p> 
     <p>Duração <strong>' .$runtime. '</strong></p> 
     <p>Avaliação IMDB <strong>' .$imdbRating. '</strong></p>
     <p>Actores: <strong>' .$actors. '</strong></p> 
     <p>Nomeações : <strong>' .$awards. '</strong></p>';


$new_post = array(
    'post_title' => $leadTitle,
    'post_id' => 1,
    'post_content' => $leadContent,
    'post_status' => $postStatus,
    'post_author' => $userId,
    'post_type' => $postType,
    'post_category' => array($cat_ID)
);

if ($video) {
    $post_id = wp_insert_post($new_post);
} else {
    echo 'no video';
}

// Add Featured Image to Post
$image_url        = $poster;
$image_name       = $title.'.jpg';
$upload_dir       = wp_upload_dir(); // Set upload folder
$image_data       = file_get_contents($image_url); // Get image data
$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
$filename         = basename( $unique_file_name ); // Create image file name

// Check folder permission and define file location
if( wp_mkdir_p( $upload_dir['path'] ) ) {
    $file = $upload_dir['path'] . '/' . $filename;
} else {
    $file = $upload_dir['basedir'] . '/' . $filename;
}

// Create the image  file on the server
file_put_contents( $file, $image_data );

// Check image file type
$wp_filetype = wp_check_filetype( $filename, null );

// Set attachment data
$attachment = array(
    'post_mime_type' => $wp_filetype['type'],
    'post_title'     => sanitize_file_name( $filename ),
    'post_content'   => $plot,
    'post_excerpt' => $plot,
    'post_status'    => 'inherit'
);

// Create the attachment
$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

// Include image.php
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Define attachment metadata
$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

// Assign metadata to attachment
wp_update_attachment_metadata( $attach_id, $attach_data );

update_post_meta($attach_id, '_wp_attachment_image_alt', $title);


// And finally assign featured image to
set_post_thumbnail( $post_id, $attach_id );

$final_text = '';

if($post_id) {
    header("Location: https://www.netfilmes.pt/addpost/");
    exit();
} else {
    $final_text .= 'Something went wrong. <br>';
}

echo $final_text;


