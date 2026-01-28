<?php

class Taskcontroller extends ApplicationController
{
    public function homeAction()
    {
        $model = new TaskModel();

        $keyWord = $_POST['keyWord'] ?? null;

        if ($keyWord) {
            $this->view->tasks = $model->searchTasks($keyWord); //shows filtered
            $this->view->isSearch = true;
        } else {
            $this->view->tasks = $model->getAllTasks(); //shows all
            $this->view->isSearch = false;
        }
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
        $keyWord = $_POST['keyWord'] ?? '';

        $model = new TaskModel();
    }
}
