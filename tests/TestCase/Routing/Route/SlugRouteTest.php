<?php
namespace App\Test\TestCase\Routing\Route;

use App\Routing\Route\SlugRoute;
use Cake\Core\App;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;

class SlugRouteTest extends TestCase {

/**
 * Test match method
 *
 * @return void
 */
	public function testMatch() {
		$route = new SlugRoute('/:controller/:action/:id', ['plugin' => null]);
		$result = $route->match(['controller' => 'Posts', 'action' => 'myView', 'plugin' => null]);
		$this->assertFalse($result);

		$route = new SlugRoute('/:controller/:action/:slug.:id', [], ['id' => Router::ID]);
		$result = $route->match([
			'plugin' => null,
			'controller' => 'threads',
			'action' => 'edit',
			'slug' => 'my awesome slug',
			'id' => 1
		]);
		$this->assertEquals('/threads/edit/my-awesome-slug.1', $result);

		$result = $route->match([
			'plugin' => null,
			'controller' => 'threads',
			'action' => 'edit',
			'slug' => 'my awésôme slug',
			'id' => 1
		]);
		$this->assertEquals('/threads/edit/my-awesome-slug.1', $result);
	}
}
