<?php

namespace STC;

class PostComponent
{
  const TYPE = 'post';

  public function filter_by_type($file)
  {
    return $file['type'] == PostRender::TYPE;
  }

  public function build($files)
  {
    $post_files = $files->filter_by(array(&$this, 'filter_by_type'));

    $fixed_posts = [];
    foreach($posts as $post) {
      if ($post['type'] != 'post') continue;
      $fixed_posts[(int)format_date_YYYYMMDD($post['file'])] = $post;
    }

    sort($fixed_posts, SORT_NUMERIC);
    Config::db()->store('post_list', $fixed_posts);
  }
}
