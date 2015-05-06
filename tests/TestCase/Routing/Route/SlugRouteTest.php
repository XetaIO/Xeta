<?php
namespace App\Test\TestCase\Routing\Route;

use App\Routing\Route\SlugRoute;
use Cake\Core\App;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;

class SlugRouteTest extends TestCase
{

    /**
     * Test match method
     *
     * @return void
     */
    public function testMatch()
    {
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

        $route = new SlugRoute(':plugin/:controller/:action/:slug.:id', [], ['id' => Router::ID]);
        $result = $route->match([
            'plugin' => 'MyPlugin',
            'controller' => 'Threads',
            'action' => 'edit',
            'slug' => 'my awésôme slug',
            'id' => 1
        ]);
        $this->assertEquals('my_plugin/threads/edit/my-awesome-slug.1', $result);
    }

    /**
     * Test parse method
     *
     * @return void
     */
    public function testParse()
    {
        $route = new SlugRoute('/:controller/:action/:slug.:id', [], ['id' => Router::ID]);
        $route->compile();
        $result = $route->parse('/threads/edit/my-awesome-slug.1');
        $this->assertEquals('Threads', $result['controller']);
        $this->assertEquals('edit', $result['action']);
        $this->assertEquals('my-awesome-slug', $result['slug']);
        $this->assertEquals('1', $result['id']);

        $result = $route->parse('/threads/edit/my-awesome-sl.ug.1');
        $this->assertEquals('Threads', $result['controller']);
        $this->assertEquals('edit', $result['action']);
        $this->assertEquals('my-awesome-sl-ug', $result['slug']);
        $this->assertEquals('1', $result['id']);

        $route = new SlugRoute(':plugin/:controller/:action/:slug.:id', [], ['id' => Router::ID]);
        $route->compile();
        $result = $route->parse('myplugin/threads/edit/my-awesome-sl.ug.1');
        $this->assertEquals('Myplugin', $result['plugin']);
        $this->assertEquals('Threads', $result['controller']);
        $this->assertEquals('edit', $result['action']);
        $this->assertEquals('my-awesome-sl-ug', $result['slug']);
        $this->assertEquals('1', $result['id']);

        $result = $route->parse('');
        $this->assertFalse($result);
    }
}
