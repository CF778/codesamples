<?php

/**
 * @file
 * Contains \Drupal\custom_route\Controller\RouteController.
 */
/* The goal of this logic was to generate new urls with a new alias pattern for pages with existing aliases on the site
 *as well as using a separate twig file to restyle the content
*/
namespace Drupal\custom_route\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use \Drupal\Core\Database\Database;
use \Drupal\Core\Url;
use Drupal\menu_link_content\Entity\MenuLinkContent;

class RouteController extends ControllerBase {
    public function getStory($story_type, $title) {
       //Uses routing variables (custom_route.routing.yml) to get content with a pre-existing alias at new url
       $system_path = \Drupal::service('path.alias_manager')->getPathByAlias('/stories/'.$story_type.'/'.$title);
       $nid = basename($system_path);
       $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
       $alias = \Drupal::service('path.alias_manager')->getAliasByPath($system_path);
	
       /* 
       //Adds new links to menu programmatically for new urls
       //Gets all of the node ids of type story in an array
       $route_list = [];
       $nids = \Drupal::entityQuery('node')
    	->condition('type','story')
    	->execute();
      
       //Get nodes based on ids and extract aliases putting them in array
       foreach($nids as $id => $nid) {
    	     $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
    	     if($node->isPublished() == True){
    	         $system_path = '/node/'.$nid;
    	         $alias = \Drupal::service('path.alias_manager')->getAliasByPath($system_path); 
    	         $route_list[] = $alias;
    	     }
       }
       foreach($route_list as $route){
    	 $title = ucwords(str_replace("-"," ",basename($route)));
    	 $collection_route = str_replace("stories","collection/stories",$route);
    	 $menu_link = MenuLinkContent::create([
           'title' => $title,
           'link' => ['uri' => 'internal:'.$collection_route],
           'menu_name' => 'collection-menu',
           'expanded' => TRUE,
         ]);
         $menu_link->save();  
       }
       */
       return \Drupal::entityTypeManager()->getViewBuilder('node')->view($node, $view_mode = 'story', $langcode = NULL);
    }
}
