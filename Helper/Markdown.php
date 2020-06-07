<?php 

namespace Helper;

class Markdown {

  //
  // _hej_
  //
  public static function empatiseText($string)
  {
    return preg_replace('/\_([^\*]+)\_/i', '<em>$1</em>', $string);
  }

  //
  // *hej*
  //
  public static function boldText($string)
  {
    return preg_replace('/\*([^\*]+)\*/', '<strong>$1</strong>', $string);
  }

  //
  // # Hej -> ###### Hej
  //
  public static function heading($string)
  {
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
  public static function links($string)
  {
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
  // Render Markdown
  //
  public static function render($string)
  {
    $functions = array(
      'links',
      'heading',
      'boldText',
      'empatiseText'
    );

    foreach($functions as $function) {
      $string = self::$function($string);
    }

    return $string;
  }
}
