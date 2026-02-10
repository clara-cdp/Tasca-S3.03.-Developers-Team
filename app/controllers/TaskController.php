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

    public function deleteAction()
    {
        $id = $_GET['idTASK'] ?? null;

        if ($id) {
            $this->model->deleteTask($id);
        }

        header('Location: ' . $this->_baseUrl() . '/home');
        exit;
    }
    public function changeStateAction()
    {
        $taskID = $_GET['idTASK'];
        $newState = $_GET['task_state'];
        $this->model->changeState($taskID, $newState);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function updateAction()
    {
        $id = $_GET['idTASK'];
        $task = $this->model->getTask($id);
        $this->view->task = $task;
    }

    public function updatetaskAction()
    {
        $statusEnum = TaskState::from($_POST['state']);

        $updatedTask = [
            'idTASK'          => (int)$this->clean_input($_GET['idTASK']),
            'task_title'        => $this->clean_input($_POST['name']),
            'task_description' => $this->clean_input($_POST['description']),
            'user_name'        => $this->clean_input($_POST['user']),
            'task_state'       => $statusEnum ? $statusEnum->value : TaskState::PENDING->value
        ];

        $this->model->updateTask($updatedTask);
        header("Location: " . WEB_ROOT . "/home");
        exit;
    }
}
