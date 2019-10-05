<?php
$message = 'Hej jag _heter_ Zara';
$message2 = "## Hej
 *jag _heter_ Zara* 
###### ey
## Riccardo is the BEST 
d";

//
// _hej_
//
function empatiseText($string) {
  return preg_replace('/\_([^\*]+)\_/i', '<em>$1</em>', $string);
}

//
// *hej*
//
function boldText($string) {
  return preg_replace('/\*([^\*]+)\*/', '<strong>$1</strong>', $string);
}

//
// # Hej -> ###### Hej
//
function heading($string) {
  preg_match_all('/^(#{1,6})\s(\w+)/m', $string, $matches);
  list($markdown, $hashes, $heading) = $matches;

  foreach ($markdown as $key => $value) {

    $headingLevel = strlen($hashes[$key]);

    $string = preg_replace('/' .$value. '/', '<h' .$headingLevel. '>' .$heading[$key]. '</h' .$headingLevel. '>', $string);
  }

  return $string;
}


// function links($string) {
//   $regex = '\[([^\*]+)\]\(([^ ]+)(?: "(.+)")?\)';
//   preg_match("`$regex`", $string, $matches);  
//   return json_encode($matches, JSON_PRETTY_PRINT);  

//   // http://blog.michaelperrin.fr/2019/02/04/advanced-regular-expressions/
// }

//
// create an array of regex matches 
// loop over the array and pass the string 
// add heading and links regex
// dont save markup in the db, only render markup when showing post.
// 

function render($string) {

  // $regexMatches = array(
  //   'bold' => '/\*([^\*]+)\*/',
  //   'italic' => '/\_([^\*]+)\_/i'
  // );

  // var_dump($regexMatches);


  // return boldText(empatiseText($string));

}
$string = '[hej](htp:// "htk")';

// echo($message2);
echo(heading($message2));

// echo fizz_buzz("### header");
