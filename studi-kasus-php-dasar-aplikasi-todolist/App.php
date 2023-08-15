<?php

require_once __DIR__.'/Entity/TodoList.php';
require_once __DIR__.'/Helper/InputHelper.php';
require_once __DIR__.'/Repository/TodoListRepository.php';
require_once __DIR__.'/Service/TodoListService.php';
require_once __DIR__.'/View/TodoListView.php';
require_once __DIR__."/Config/Database.php";

use \Entity\TodoList;
use \Repository\TodoListRepositoryImpl;
use \Service\TodoListServiceImpl;
use \View\TodoListView;

echo "Aplikasi To Do List".PHP_EOL;

$connection = \Config\Database::getConnection();
$todoListRepository = new TodoListRepositoryImpl($connection);
$todoListService = new TodoListServiceImpl($todoListRepository);
$todoListView = new TodoListView($todoListService);

$todoListView->showTodoList();