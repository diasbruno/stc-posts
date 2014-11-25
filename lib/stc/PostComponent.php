<?php

namespace STC;

class PostComponent
{
  public function __construct()
  {
    $this->type = 'post';
  }

  public function filter_by_type($file)
  {
    return array_key_exists('type', $file)
        && $file['type'] == $this->type;
  }

  public function build($files)
  {
    $posts = $files->filter_by(array(&$this, 'filter_by_type'));

    $fixed_posts = [];
    foreach($posts as $post) {
      $fixed_posts[(int)format_date_YYYYMMDD($post['file'])] = $post;
    }

    sort($fixed_posts, SORT_NUMERIC);
    Application::db()->store('post_list', $fixed_posts);
  }
}
