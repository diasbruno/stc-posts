<?php

namespace STC;

class PostComponent
{
  public function build($files)
  {
    $post_files = $files->get_all();

    Config::store_data('post_list', $post_files);
  }
}


