<?php
namespace Packfire\Core;

use Packfire\Core\ClassLoader\ClassFinder;
use Packfire\Core\ClassLoader\ClassLoader;

/**
 * Packfire Application Front Controller for HTTP interface
 * 
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2010-2012, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @since 1.0-sofia
 * @internal
 * @ignore
 */

require('pack/constants.php');

$path = null;
if(__PACKFIRE_ROOT__){
    $path = __PACKFIRE_ROOT__;
}else{
    $namespaces = require('vendor/composer/autoload_namespaces.php');
    if($namespaces){
        $path = $namespaces['Packfire'];
    }
}

if($path){
    // include the main Packfire class
    require $path . DIRECTORY_SEPARATOR . 'Packfire\Packfire.php';
    $packfire = new Packfire\Packfire();
    $packfire->classLoader()->register(true);
    $finder = new ClassFinder();
    $finder->addNamespace('', 'pack/src/');
    $loader = new ClassLoader($finder);
    $loader->register(true);
    $packfire->fire(new Packfire\Application\Http\Application());
}else{
    throw new \Exception('Could not bootstrap test because Packfire Framework was not installed.');
}