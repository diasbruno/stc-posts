<?php

namespace STC;

class PostComponent
{
  public function build($files)
  {
    $posts = $files->get_all();

    $fixed_posts = [];
    foreach($posts as $post) {
      if ($post['type'] != 'post') continue;
      $fixed_posts[(int)format_date_YYYYMMDD($post['file'])] = $post;
    }
    sort($fixed_posts, SORT_NUMERIC);
    Config::db()->store_data('post_list', $fixed_posts);
  }
}
