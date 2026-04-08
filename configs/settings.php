<?php

const AVAILABLE_ROUTES = [
    '/' => [
        'controller' => 'HomeController', 
        'method' => 'index'
    ],
    'login' => [
        'controller' => 'LoginController', 
        'method' => 'index'
    ],
    'logout' => [
        'controller' => 'LoginController', 
        'method' => 'logout'
    ],
    'dashboard' => [
        'controller' => 'DashboardController', 
        'method' => 'index'
    ],
    'dashboard_list' => [
        'controller' => 'DashboardController', 
        'method' => 'listing'
    ],
    'dashboard_edit' => [
        'controller' => 'DashboardController', 
        'method' => 'edit'
    ],
    'save_category' => [
        'controller' => 'CategoryController', 
        'method' => 'save'
    ],
    'delete_category' => [
        'controller' => 'CategoryController', 
        'method' => 'delete'
    ],
    'save_skill' => [
        'controller' => 'SkillController', 
        'method' => 'save'
    ],
    'delete_skill' => [
        'controller' => 'SkillController', 
        'method' => 'delete'
    ],
    'save_project' => [
        'controller' => 'ProjectController', 
        'method' => 'save'
    ],
    'delete_project' => [
        'controller' => 'ProjectController', 
        'method' => 'delete'
    ],
    'save_user' => [
        'controller' => 'DashboardController', 
        'method' => 'saveUser'
    ],
    'project' => [
        'controller' => 'ProjectController', 
        'method' => 'show'
    ],
    '404' => [
        'controller' => 'ErrorController',
        'method' => 'index'
    ]
];

const DEFAULT_ROUTE = '/';
const DEFAULT_USER_ID = 1;
