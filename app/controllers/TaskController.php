<?php

class Taskcontroller extends ApplicationController

{
    public function homeAction()
    {
        $model = new TaskModel();

        $keyWord = $_POST['keyWord'] ?? '';

        $cleanKeyWord = $this->clean_input($keyWord);

        if ($cleanKeyWord) {
            $this->view->tasks = $model->searchTasks($cleanKeyWord); //shows filtered
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

    public function updateAction()
    {
        $model = new TaskModel();
        $task = $model->getTask($_GET['id']);
        $this->view->task = $task;
    }

    public function updatetaskAction()
    {
        $updatedTask = [
            'id'       => trim($_GET['id']),
            'name'       => trim($_POST['name']),
            'description' => trim($_POST['description']),
            'user'        => trim($_POST['user']),
            'state' => trim($_POST['state'])
        ];

        $model = new TaskModel();
        $model->updateTask($updatedTask);
        header("Location: " . WEB_ROOT . "/home");
        exit;
    }

    public function searchAction()
    {
        $keyWord = $_POST['keyWord'] ?? '';

        $model = new TaskModel();
    }


    //move this function to the "right place" 
    function clean_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
