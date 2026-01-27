<?php

class TaskController extends ApplicationController
{

    public function homeAction()
    {
        $model = new TaskModel();

        $allTasks = $model->getAllTasks(); // go to json 

        $this->view->tasks = $allTasks;
    }

    public function createAction() {}

    public function savetaskAction()
    {
        $model = new TaskModel();
        $model->saveTask();
        header("Location: " . WEB_ROOT . "/home");
        exit;
    }

    public function deleteAction()
    {
        $idToDelete = $_GET['id'];

        $model = new TaskModel(); // go to json and remove it
        $model->deleteTask($idToDelete);

        header('Location: ' . $_SERVER['HTTP_REFERER']); //find the right route
        exit;
    }
}
