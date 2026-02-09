<?php

class TaskController extends ApplicationController

{
    private TaskModel $model;

    public function __construct()
    {
        $this->model = new TaskModel();
    }

    public function homeAction()
    {
        $model = new TaskModel();

        $this->view->allTasks = $model->getAllTasks();

        $keyWord = $_POST['keyWord'] ?? '';
        $status = $_REQUEST['status'] ?? '';
        $date = $_REQUEST['date'] ?? 'new';

        $cleanKeyWord = $this->clean_input($keyWord);

        if ($cleanKeyWord) {
            $this->view->tasks = $this->model->searchTasks($cleanKeyWord); //shows filtered
        } elseif ($status) {
            $statusEnum = TaskState::from($status);
            $this->view->tasks = $this->model->sortByState($statusEnum);
        } elseif ($date !== 'new') {
            $this->view->tasks = $this->model->sortByDate($date);
        } else {
            $this->view->tasks = $this->model->getAllTasks();
        }

        $this->view->isSearch = ($cleanKeyWord || $status || $date !== 'new');
    }

    public function createAction() {}

    public function savetaskAction()
    {
        $newTask = [
            'task_title' => $this->clean_input($_POST['task_title'] ?? ''),
            'task_description' => $this->clean_input($_POST['task_description'] ?? ''),
            'user_name' => $this->clean_input($_POST['user_name'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'task_state'  => TaskState::PENDING->value,   //updated this to status ENUM
            'finished_at' => null
        ];

        $this->model->save($newTask);
        header("Location: " . WEB_ROOT . "/home");
        exit;
    }

    /*    public function changeStateAction()
    {
        $taskID = $_GET['idTask'];
        $newState = $_GET['task_state'];

        $model = new TaskModel();
        $model->changeState($taskID, $newState);

        header('Location: ' . $_SERVER['HTTP_REFERER']); //find the right route
        exit;
    }
*/

    /*
    public function savetaskAction()
    {

        $newTask = [
            'id' => null,
            'name' => $this->clean_input($_POST['name'] ?? ''),
            'description' => $this->clean_input($_POST['description'] ?? ''),
            'user' => $this->clean_input($_POST['user'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'state'  => TaskState::PENDING->value   //updated this to status ENUM
        ];

        $this->model->saveTask($newTask);
        header("Location: " . WEB_ROOT . "/home");
        exit;
    }

    public function deleteAction()
    {
        $idToDelete = $_GET['id'];

        $this->model->deleteTask($idToDelete);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function updateAction()
    {
        $task = $this->model->getTask($_GET['id']);
        $this->view->task = $task;
    }

    public function updatetaskAction()
    {
        $statusEnum = TaskState::from($_POST['state']);

        $updatedTask = [
            'id'       => (int)$this->clean_input($_GET['id']),
            'name'       => $this->clean_input($_POST['name']),
            'description' => $this->clean_input($_POST['description']),
            'user'        => $this->clean_input($_POST['user']),
            'state'       => $statusEnum ? $statusEnum->value : TaskState::PENDING->value
        ];

        $this->model->updateTask($updatedTask);
        header("Location: " . WEB_ROOT . "/home");
        exit;
    }

    public function changeStateAction()
    {
        $taskID = $_GET['id'];
        $newState = $_GET['state'];

        $model = new TaskModel();
        $model->changeState($taskID, $newState);

        header('Location: ' . $_SERVER['HTTP_REFERER']); //find the right route
        exit;
    }*/
}
