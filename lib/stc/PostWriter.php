<?php

namespace STC;

use Cocur\Slugify\Slugify;

/**
 * @author Bruno Dias <dias.h.bruno@gmail.com>
 * @license MIT License (see LICENSE)
 */
class PostWriter
{
  private $slugify;

  /**
   * @constructor
   */
  public function __construct()
  {
    $this->slugify = new Slugify();
  }

  /**
   * Make the page slug.
   * @param $file array | Raw file data.
   * @param $tmpl array | Reference to the new file data.
   * @return void
   */
  public function make_slug($str)
  {
    return $this->slugify->slugify($str);
  }

  /**
   * Format a file to be rendered.
   * @param $file array | Json file as array.
   * @return array
   */
  private function make_data($file)
  {
    if (!array_key_exists('template', $file)) {
      throw new Exception('x> Current Post: ' . $file['title'] . ' does not have a template.');
    }

    $t = Application::templates()->template($file['template']);

    $data_folder = Application::data_folder();
    $template_name = $data_folder . '/templates/' . $t;
    $content_template = $data_folder . '/' . $file['content'];

    $render_content_with = Application::renders()->select($content_template);
    $render_with = Application::renders()->select($template_name);

    $tmpl['slug'] = $this->make_slug($file['title']);

    $tmpl['html'] = $render_with->render($template_name, [
      'content' => $render_content_with->render($content_template, [
        'post'=> $file,
      ]),
      'post'=> $file,
    ]);

    $this->log_current_page($file['title'], $tmpl['slug']);

    return $tmpl;
  }

  /**
   * Execute.
   * @param $files array | A list of all available entries.
   * @return void
   */
  public function execute($files)
  {
    printLn('=> PostWriter.');

    $post_files = Application::db()->retrieve('post_list');

    $writer = new DataWriter();

    foreach($post_files as $file) {
      $tmpl = $this->make_data($file);
      $writer->write($tmpl['slug'], 'index.html', $tmpl['html']);
    }
  }

  /**
   * Log current page.
   * @param $title string | The title of the page.
   * @param $slug string | The slug.
   * @return void
   */
  private function log_current_page($title, $slug)
  {
    printLn('==> Current page: ' . $title . ': /' . $slug);
  }
}
