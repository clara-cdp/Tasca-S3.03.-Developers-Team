<?php

class TaskModel extends Model
{
    protected $jsonFile = ROOT_PATH . '/app/models/tasks.json';

    public function __construct()
    {
        // By leaving this empty, we don't call parent::__construct()
        // so the app stops looking for a MySQL server.
    }

    public function getAllTasks()
    {
        if (!file_exists($this->jsonFile)) {
            return [];
        }

        $jsonContent = file_get_contents($this->jsonFile);
        $data = json_decode($jsonContent, true);

        $tasks = isset($data['tasks']) ? $data['tasks'] : [];

        return array_reverse($tasks);  //shows tasks by newest first  ;)

        if (isset($data['tasks'])) {
            return $data['tasks'];
        }

        return [];
    }

    public function getTask($id)
    {
        $jsonContent = file_get_contents($this->jsonFile);
        $data = json_decode($jsonContent, true);

        if (!isset($data['tasks'])) {
            return null;
        }

        foreach ($data['tasks'] as $task) {
            if ((int)$task['id'] === (int)$id) {
                return $task;
            }
        }
        return null;
    }

    public function saveTask($newTask)
    {
        $jsonContent = file_get_contents($this->jsonFile);
        $data = json_decode($jsonContent, true);

        $newTask['id'] = $this->generateId($data['tasks']);
        $data['tasks'][] = $newTask;
        file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function updateTask($updatedTask): void
    {
        $jsonContent = file_get_contents($this->jsonFile);
        $data = json_decode($jsonContent, true);

        foreach ($data['tasks'] as $index => $task) {
            if ((int)$task['id'] === (int)$updatedTask['id']) {
                $currentTask = $this->getTask($updatedTask['id']);
                $data['tasks'][$index] = array_merge($currentTask, $updatedTask);
                break;
            }
        }
        file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function deleteTask($id)
    {
        $jsonContent = file_get_contents($this->jsonFile);
        $data = json_decode($jsonContent, true);

        foreach ($data['tasks'] as $key => $task) {
            if ($task['id'] == $id) {
                unset($data['tasks'][$key]);
                break;
            }
        }

        $data['tasks'] = array_values($data['tasks']); //reset values --> no it doesn't? does it really matter at all? 

        file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT)); //save to file
    }

    public function searchTasks($keyWord)
    {
        $allTasks = $this->getAllTasks();

        $filteredTasks = [];
        foreach ($allTasks as $task) {
            if (
                stripos($task['name'], $keyWord) !== false ||
                stripos($task['description'], $keyWord) !== false
            ) {
                $filteredTasks[] = $task;
            }
        }

        return $filteredTasks;
    }

    private function generateId($tasks)
    {
        if (empty($tasks)) {
            return 1;
        }

        $lastTask = end($tasks);
        return $lastTask['id'] + 1;
    }

    public function  getTaskStatus()
    {
        // $jsonContent = file_get_contents($this->jsonFile);
        // $data = json_decode($jsonContent, true);
        if (isset($_POST['submit'])) {
            return "okey Dokey";
        }
    }
}
