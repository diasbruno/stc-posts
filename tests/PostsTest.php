<?php

namespace STC\Test;

use STC\Config;
use STC\Files;
use STC\PostComponent;
use STC\PostRender;

class PostsTest extends \PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    Config::bootstrap(dirname(__FILE__), 'data');
  }

  public function testUnits()
  {
    $this->assertTrue(new PostComponent() != null);
    $this->assertTrue(new PostRender() != null);
  }

  public function testBuildComponent()
  {
    $files = new Files();
    $files->load(dirname(__FILE__).'/data', 'page-data');

    $component = new PostComponent();
    $component->build($files);

    $this->assertTrue(count(Config::db()->retrieve('post_list')) > 0);
  }
}
