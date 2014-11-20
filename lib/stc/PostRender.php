<?php

namespace STC;

use Cocur\Slugify\Slugify;

class PostRender
{
  private $slugify;

  public function __construct()
  {
    $this->slugify = new Slugify();
  }

  public function make_slug($str)
  {
    return $this->slugify->slugify($str);
  }

  private function make_data($file)
  {
    if (!array_key_exists('template', $file)) {
      throw new Exception('x> Current Post: ' . $file['title'] . ' does not have a template.');
    }

    $t = Config::templates()->template($file['template']);
    $c = Config::data_folder() . '/';

    $tmpl = $file;
    $tmpl['slug'] = $this->make_slug($file['title']);

    $tmpl['html'] = view($c . 'templates/' . $t, [
      'content' => view($c . $file['content']),
      'post' => $file,
    ]);

    printLn('==> Current Post: ' . $file['title'] . ': ' . $tmpl['slug']);

    return $tmpl;
  }

  public function render($files)
  {
    printLn('=> PostRender.');

    $post_files = Config::db()->retrieve('post_list');

    $t = Config::templates()->templates_path() . '/';

    $writer = new DataWriter();

    foreach($post_files as $file) {
      $tmpl = $this->make_data($file);
      $writer->write($tmpl['slug'], 'index.html', $tmpl['html']);
    }
  }
}
