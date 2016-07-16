<?php

/**
 * @file
 *  Contains \Drupal\emarket_order\Path\OrderOutboundPathProcessor
 */

namespace Drupal\emarket_order\Path;


use Drupal\Core\PathProcessor\OutboundPathProcessorInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Symfony\Component\HttpFoundation\Request;

class OrderOutboundPathProcessor implements OutboundPathProcessorInterface {

  /**
   * Processes the outbound path.
   *
   * @param string $path
   *   The path to process, with a leading slash.
   * @param array $options
   *   (optional) An associative array of additional options, with the following
   *   elements:
   *   - 'query': An array of query key/value-pairs (without any URL-encoding)
   *     to append to the URL.
   *   - 'fragment': A fragment identifier (named anchor) to append to the URL.
   *     Do not include the leading '#' character.
   *   - 'absolute': Defaults to FALSE. Whether to force the output to be an
   *     absolute link (beginning with http:). Useful for links that will be
   *     displayed outside the site, such as in an RSS feed.
   *   - 'language': An optional language object used to look up the alias
   *     for the URL. If $options['language'] is omitted, it defaults to the
   *     current language for the language type LanguageInterface::TYPE_URL.
   *   - 'https': Whether this URL should point to a secure location. If not
   *     defined, the current scheme is used, so the user stays on HTTP or HTTPS
   *     respectively. TRUE enforces HTTPS and FALSE enforces HTTP.
   *   - 'base_url': Only used internally by a path processor, for example, to
   *     modify the base URL when a language dependent URL requires so.
   *   - 'prefix': Only used internally, to modify the path when a language
   *     dependent URL requires so.
   *   - 'route': The route object for the given path. It will be set by
   *     \Drupal\Core\Routing\UrlGenerator::generateFromRoute().
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The HttpRequest object representing the current request.
   * @param \Drupal\Core\Render\BubbleableMetadata $bubbleable_metadata
   *   (optional) Object to collect path processors' bubbleable metadata.
   *
   * @return string
   *   The processed path.
   */
  public function processOutbound($path, &$options = array(), Request $request = NULL, BubbleableMetadata $bubbleable_metadata = NULL) {
    // If we have a 'order_hash' parameter in the query, then keep it.
    //$order_hash = $request->get('order_hash');
    if (!empty($_GET['order_hash'])) {
      if ($path == '/node/add') {
        $options['query']['order_hash'] = $_GET['order_hash'];
      }
      //echo '<pre>'; print_r($options['query']); die();
    }
    return $path;
  }
}
