<?php 

add_filter( 'the_content', 'get_films_list_in_the_main_loop' );

function get_films_list_in_the_main_loop() {
	$content = "";
	if(curPageURL()  == home_url()."/"){// bad pracice but can't find right hook
		$loop = new WP_Query( array( 'post_type' => 'film', 'posts_per_page' => 10 ) );
		while ( $loop->have_posts() ){
			$loop->the_post();
			$genres = wp_get_object_terms(get_the_ID(),'genre');
			$genres = getTaxonomyNames($genres);
			$countries = wp_get_object_terms(get_the_ID(),'country');
			$countries = getTaxonomyNames($countries);

			echo "<a href='".get_permalink()."'><h1>";the_title(); echo "</h1></a> ";
			echo "descreption: ".get_the_content()."<br/> ";		
			echo "country: ". implode(', ', $countries)."<br/> ";
			echo "genre: ". implode(', ', $genres)."<br/> ";
			echo "Release Date: ". get_field("release_date")."<br/> ";
			echo "Ticket Price: ". get_field("ticket_price")."<br/> ";
		} 
	}

 	return $content;     
}



function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


if(!function_exists("getTaxonomyNames")) {
	function getTaxonomyNames($taxonomyArr){
		$taxonomyNames = array();
		foreach($taxonomyArr as $taxonomyObj) {
		  $taxonomyNames[] = $taxonomyObj->name;
		}
		return $taxonomyNames;
	}
}


function getLastFilms() {
	echo  '<h1>Last 5 Films</h1>';

	$loop = new WP_Query( array( 'post_type' => 'film', 'posts_per_page' => 5 , 'orderby' => 'id','order' => 'DESC') );
	while ( $loop->have_posts() ){
		$loop->the_post();
		$genres = wp_get_object_terms(get_the_ID(),'genre');
		$genres = getTaxonomyNames($genres);
		$countries = wp_get_object_terms(get_the_ID(),'country');
		$countries = getTaxonomyNames($countries);
		
		echo "<a href='".get_permalink()."'><h3>";the_title(); echo "</h3></a> ";		
		echo "country: ". implode(', ', $countries)."<br/> ";
		echo "genre: ". implode(', ', $genres)."<br/> ";
		echo "Release Date: ". get_field("release_date")."<br/> ";
		echo "Ticket Price: ". get_field("ticket_price")."<br/> ";
	} 

	exit;
}

add_shortcode('last5Films', 'getLastFilms');



?>