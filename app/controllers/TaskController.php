<?php

class Taskcontroller extends ApplicationController
{
    public function homeAction()
    {

        $model = new TaskModel();

        $allTasks = $model->getAllTasks(); // go to json 

        $this->view->tasks = $allTasks;
    }

    public function deleteAction()
    {
        $idToDelete = $_GET['id'];

        $model = new TaskModel(); // go to json and remove it
        $model->deleteTask($idToDelete);

        header('Location: ' . $_SERVER['HTTP_REFERER']); //find the right route
        exit;
    }

    public function searchAction()
    {
        $keyWord = $_POST['keyWord'];

        $model = new TaskModel();
        $filteredTasks = $model->searchTasks($keyWord);

        $this->view->tasks = $filteredTasks;
    }
}
