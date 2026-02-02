<?php

class TaskModel extends Model
{
    protected $jsonFile = ROOT_PATH . '/app/models/tasks.json';

    public function __construct()
    {
        // By leaving this empty, we don't call parent::__construct()
        // so the app stops looking for a MySQL server.
    }

    public function getAllTasks(): array
    {
        $data = $this->readData();
        return array_reverse($data['tasks']);
    }

    public function getTask(int $id): ?array
    {
        $data = $this->readData();
        foreach ($data['tasks'] as $task) {
            if ((int)$task['id'] === (int)$id) {
                return $task;
            }
        }
        return null;
    }

    public function saveTask(array $newTask): void
    {
        $data = $this->readData();
        $newTask['id'] = $this->generateId($data['tasks']);
        $data['tasks'][] = $newTask;
        $this->writeData($data);
    }

    private function generateId(array $tasks): int
    {
        if (empty($tasks)) {
            return 1;
        }
        $lastTask = end($tasks);
        return $lastTask['id'] + 1;
    }

    public function updateTask(array $updatedTask): void
    {
        $data = $this->readData();
        foreach ($data['tasks'] as $index => $task) {
            if ((int)$task['id'] === (int)$updatedTask['id']) {
                //  $currentTask = $this->getTask($updatedTask['id']);
                if ($updatedTask['state'] === TaskState::FINIFSHED->value) { //--> add this: timeStamp to 'finished' state
                    $updatedTask['finished_at'] = date('Y-m-d H:i:s');
                } else {
                    $updatedTask['finished_at'] = null;
                }
                $data['tasks'][$index] = array_merge($task, $updatedTask);
                //  $data['tasks'][$index] = array_merge($currentTask, $updatedTask);
                break;
            }
        }
        $this->writeData($data);
    }

    public function deleteTask($id): void
    {
        $data = $this->readData();
        foreach ($data['tasks'] as $key => $task) {
            if ($task['id'] == $id) {
                unset($data['tasks'][$key]);
                break;
            }
        }
        $this->writeData($data);
    }

    public function searchTasks(string $keyWord): array
    {
        $allTasks = $this->getAllTasks();
        $filteredTasks = [];
        foreach ($allTasks as $task) {
            if (
                stripos($task['name'], $keyWord) !== false ||
                stripos($task['description'], $keyWord) !== false ||
                stripos($task['user'], $keyWord) !== false
            ) {
                $filteredTasks[] = $task;
            }
        }
        return $filteredTasks;
    }

    public function sortByState(string $state): array
    {
        $allTasks = $this->getAllTasks();
        $filteredByState = [];
        foreach ($allTasks as $task) {
            if ($task['state'] == $state)
                $filteredByState[] = $task;
        }
        return $filteredByState;
    }

    public function sortByDate(string $date): array
    {
        $allTasks = $this->getAllTasks();
        $sortedbyOld = array_reverse($allTasks);
        if ($date == "old") {
            return $sortedbyOld;
        } else {
            return $allTasks;
        }
    }

    public function changeState($taskID, $newState): void
    {
        $jsonContent = file_get_contents($this->jsonFile);
        $data = json_decode($jsonContent, true);

        foreach ($data['tasks'] as &$task) { // Note the & (reference)
            if ((int)$task['id'] === (int)$taskID) {
                $task['state'] = $newState;

                if ($newState === TaskState::FINIFSHED->value) {
                    $task['finished_at'] = date('Y-m-d H:i:s');
                } else {
                    $task['finished_at'] = null;
                }
            }
        }

        file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    private function readData(): array
    {
        if (!file_exists($this->jsonFile)) {
            return ['tasks' => []];
        }
        $content = file_get_contents($this->jsonFile);
        return json_decode($content, true) ?? ['tasks' => []];
    }

    private function writeData(array $data): void
    {
        file_put_contents(
            $this->jsonFile,
            json_encode($data, JSON_PRETTY_PRINT)
        );
    }
}
