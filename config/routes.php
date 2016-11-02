<?php

use App\Routing\Routes;
use Cake\Core\Plugin;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The routes extensions.
 */
Router::extensions(['json', 'xml']);

/**
 * The default class to use for all routes.
 */
Router::defaultRouteClass(DashedRoute::class);

/**
 * Load the routes files.
 */
Routes::load(['base', 'admin']);

/**
 * Load all plugin routes.
 */
Plugin::routes();
