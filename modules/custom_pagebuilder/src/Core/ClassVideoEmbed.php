<?php
namespace Drupal\custom_pagebuilder\Core;

/**
 * Description of ClassVideoEmbed
 *
 * @author Chau Phan
 */
class ClassVideoEmbed {
  
  private $autoplay = true;
  
  public function __construct($autoplay) {
    if($autoplay == 'no') {
      $this->autoplay = false;
    }
  }

  public function getDailyMotionId($url)
  {
      if (preg_match('!^.+dailymotion\.com/(video|hub)/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly/([^_]+))!', $url, $m)) {
          if (isset($m[6])) {
              return $m[6];
          }
          if (isset($m[4])) {
              return $m[4];
          }
          return $m[2];
      }
      return false;
  }
  /**
   * Extracts the vimeo id from a vimeo url.
   * Returns false if the url is not recognized as a vimeo url.
   */
  public function getVimeoId($url)
  {
      if (preg_match('#(?:https?://)?(?:www.)?(?:player.)?vimeo.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#', $url, $m)) {
          return $m[1];
      }
      return false;
  }
/**
 * Extracts the youtube id from a youtube url.
 * Returns false if the url is not recognized as a youtube url.
 */
  public function getYoutubeId($url)
  {
      $parts = parse_url($url);
      if (isset($parts['host'])) {
          $host = $parts['host'];
          if (
              false === strpos($host, 'youtube') &&
              false === strpos($host, 'youtu.be')
          ) {
              return false;
          }
      }
      if (isset($parts['query'])) {
          parse_str($parts['query'], $qs);
          if (isset($qs['v'])) {
              return $qs['v'];
          }
          else if (isset($qs['vi'])) {
              return $qs['vi'];
          }
      }
      if (isset($parts['path'])) {
          $path = explode('/', trim($parts['path'], '/'));
          return $path[count($path) - 1];
      }
      return false;
  }
  
  public function getVideoThumbnailByUrl($url, $format = 'small')
  {
    if (false !== ($id = getVimeoId($url))) {
        $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
        /**
         * thumbnail_small
         * thumbnail_medium
         * thumbnail_large
         */
        return $hash[0]['thumbnail_large'];
    }
    elseif (false !== ($id = getDailyMotionId($url))) {
        return 'http://www.dailymotion.com/thumbnail/video/' . $id;
    }
    elseif (false !== ($id = getYoutubeId($url))) {
        if ('medium' === $format) {
            return 'http://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
        }
        return 'http://img.youtube.com/vi/' . $id . '/default.jpg';
    }
    return false;
  }
  /**
   * Returns the location of the actual video for a given url which belongs to either:
   *
   *      - youtube
   *      - daily motion
   *      - vimeo
   *
   * Or returns false in case of failure.
   * This public function can be used for creating video sitemaps.
   */
  public function getVideoLocation($url)
  {
      if (false !== ($id = getDailyMotionId($url))) {
          return 'http://www.dailymotion.com/embed/video/' . $id;
      }
      elseif (false !== ($id = getVimeoId($url))) {
          return 'http://player.vimeo.com/video/' . $id;
      }
      elseif (false !== ($id = getYoutubeId($url))) {
          return 'http://www.youtube.com/embed/' . $id;
      }
      return false;
  }
  /**
   * Returns the html code for an embed responsive video, for a given url.
   * The url has to be either from:
   * - youtube
   * - daily motion
   * - vimeo
   *
   * Returns false in case of failure
   */
  public function getEmbedVideo($url)
  {
    $auto = '';
    if($this->autoplay) {
        $auto = '?autoplay=1';
    }
    if (false !== ($id = $this->getDailyMotionId($url))) {
      
      return '<div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="http://www.dailymotion.com/embed/video/'. $id . $auto .'" frameborder="0" allowfullscreen></iframe>
              </div>';
    }
    if (false !== ($id = $this->getVimeoId($url))) {
      return '<div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="http://player.vimeo.com/video/'. $id . $auto .'" frameborder="0" allowfullscreen></iframe>
              </div>';
    }
    if (false !== ($id = $this->getYoutubeId($url))) {
      return '<div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/'. $id . $auto .'" frameborder="0" allowfullscreen></iframe>
              </div>';
    }
    return '';
  }
      

}
