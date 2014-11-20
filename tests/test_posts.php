<?php 

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use Testify\Testify;
use STC\Config;

Config::bootstrap(dirname(__FILE__), 'data');

$test_case = new Testify('test project configuration.');

$test_case->test('unit.', function($t)
{
  $t->assert(new STC\PostComponent() != null);
  $t->assert(new STC\PostRender() != null);
});

$test_case->test('build component.', function($t)
{
  $files = new STC\Files();
  $files->load(dirname(__FILE__).'/data', 'page-data');

  $component = new STC\PostComponent();
  $component->build($files);

  $t->assert(count(Config::db()->retrieve('post_list')) > 0);
});

$test_case();
