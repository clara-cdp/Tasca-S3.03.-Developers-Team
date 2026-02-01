<?php

class Taskcontroller extends ApplicationController

{
    public function homeAction()
    {
        $model = new TaskModel();

        $keyWord = $_POST['keyWord'] ?? '';
        $status = $_REQUEST['status'] ?? '';
        $date = $_REQUEST['date'] ?? 'new'; // Default to newest

        $cleanKeyWord = $this->clean_input($keyWord);

        if ($cleanKeyWord) {
            $this->view->tasks = $model->searchTasks($cleanKeyWord); //shows filtered
        } elseif ($status) {
            $this->view->tasks = $model->sortByState($status);
        } elseif ($date !== 'new') {
            $this->view->tasks = $model->sortByDate($date);
        } else {
            $this->view->tasks = $model->getAllTasks();
        }

        $this->view->isSearch = ($cleanKeyWord || $status || $date !== 'new');

        $this->view->displayMenu = true; //displays menu

    }

    public function createAction()
    {
        $this->view->displayMenu = false; // not displaying menu
    }

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

        $model = new TaskModel();           // go to json and remove it
        $model->deleteTask($idToDelete);

        header('Location: ' . $_SERVER['HTTP_REFERER']); //find the right route
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
