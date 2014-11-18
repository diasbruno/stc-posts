<?php

namespace STC;

class PostComponent
{
  public function build($files)
  {
    Config::store_data('post_list', $files->get_all());
  }
}
