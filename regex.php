<?php
$message = "## Hej
 *jag _heter_ Zara* 
###### ey
## Riccardo is the BEST 
Hej there  this is my link [My Project](https://github.com/zarasyversen/PHP-Project)";

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
  preg_match_all('/^(#{1,6})\s(.+)/m', $string, $matches);
  list($markdown, $hashes, $heading) = $matches;

  foreach ($markdown as $key => $value) {

    $headingLevel = strlen($hashes[$key]);

    $string = str_replace(
      $value, 
      '<h' .$headingLevel. '>' .$heading[$key]. '</h' .$headingLevel. '>', 
      $string
    );
  }

  return $string;
}

//
// [Link Title](Link Url)
//
function links($string) {
  $regex = '/\[([\w\s\d]+)\]\((.+)\)/';
  preg_match_all($regex, $string, $matches);

  list($fullLink, $title, $url) = $matches;

  foreach ($fullLink as $key => $value) {

    $string = str_replace(
      $value, 
      '<a href="' .$url[$key]. '" title="' .$title[$key]. '">' .$title[$key]. '</a>', 
      $string
    );
  }

  return $string;
  
}

//
// create an array of regex matches 
// loop over the array and pass the string 
// 

function renderMarkDown($string) {


}

echo renderMarkDown($message);

