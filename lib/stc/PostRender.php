<?php

namespace STC;

use Cocur\Slugify\Slugify;

class PostRender
{
  const TYPE = 'post';
  public function __construct() {}

  public function filter_by_type($file)
  {
    return $file['type'] == PostRender::TYPE;
  }

  private function make_data($file)
  {
    if (!array_key_exists('template', $file)) {
      throw new Exception('x> Current Post: ' . $file['title'] . ' does not have a template.');
    }
    printLn('==> Current Post: ' . $file['title'] . '.');

    $t = Config::templates()->template($file['template']);
    $c = Config::data_folder() . '/';

    $tmpl = $file;
    $slugify = new Slugify();
    $tmpl['slug'] = $slugify->slugify($file['title']);
    printLn('===> Post link: ' . $tmpl['slug']);

    $tmpl['html'] = view($c . 'templates/' . $t, [
      'content' => view($c . $file['content']),
      'post' => $file,
    ]);

    printLn('');

    return $tmpl;
  }

  public function render($files)
  {
    printLn('=> Start PostRender.');
    printLn('');
    $post_files = $files->filter_by(array(&$this, 'filter_by_type'));

    $t = Config::templates()->templates_path() . '/';

    $writer = new DataWriter();

    foreach($post_files as $file) {
      $tmpl = $this->make_data($file);
      $writer->write($tmpl['slug'], 'index.html', $tmpl['html']);
    }
    printLn('=> End PostRender.');
  }
}
