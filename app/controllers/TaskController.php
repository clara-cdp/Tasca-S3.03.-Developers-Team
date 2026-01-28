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

    public function createAction() {}

    public function savetaskAction()
    {
        $newTask = [
            'id'       => null,
            'name'       => trim($_POST['name']),
            'description' => trim($_POST['description']),
            'user'        => trim($_POST['user']),
            'created_at'  => date('Y-m-d H:i:s'),
            'state' => 'pending'
        ];

        $model = new TaskModel();
        $model->saveTask($newTask);
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

    public function searchAction()
    {
        $keyWord = $_POST['keyWord'] ?? '';

        $model = new TaskModel();
    }
}
