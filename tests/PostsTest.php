<?php

namespace STC\Test;

use STC\Application;
use STC\Files;
use STC\PostDatabase;
use STC\PostWriter;

class PostsTest extends \PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    Application::bootstrap(dirname(__FILE__), 'data');
  }

  public function testUnits()
  {
    $this->assertTrue(new PostDatabase() != null);
    $this->assertTrue(new PostWriter() != null);
  }

  public function testExecuteDatabase()
  {
    $files = new Files();
    $files->load(dirname(__FILE__).'/data', 'page-data');

    $component = new PostDatabase();
    $component->execute($files);

    $this->assertTrue(count(Application::db()->retrieve('post_list')) > 0);
  }
}
