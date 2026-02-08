<?php

class TaskModel extends Model
{
    public function init()
    {
        $this->_setTable('task');
    }

    public function fetchOne($id)
    {
        $sql = 'SELECT * FROM ' . $this->_table;
        $sql .= ' WHERE idTASK = ?'; // eal column name

        $statement = $this->_dbh->prepare($sql);
        $statement->execute(array($id));

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function getAllTasks()
    {
        $sql = "SELECT * FROM task";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}


/*

  public function getAllTasks(): array
    {
       // $data = $this->readData();
        return array_reverse($data['tasks']); //this already sets the data to newest by default
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

                if ($updatedTask['state'] === TaskState::FINISHED->value) { //--> added this: timeStamp to 'finished' state
                    $updatedTask['finished_at'] = date('Y-m-d H:i:s');
                } else {
                    $updatedTask['finished_at'] = null;
                }
                $data['tasks'][$index] = array_merge($task, $updatedTask);

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

        $filteredTasks = array_filter(
            $allTasks,
            fn($task) =>
            stripos($task['name'], $keyWord) !== false ||
                stripos($task['description'], $keyWord) !== false ||
                stripos($task['user'], $keyWord) !== false
        );

        return $filteredTasks;
    }

    public function sortByState(TaskState $state): array
    {
        $allTasks = $this->getAllTasks();

        $filteredByState = $filteredByState = array_filter($allTasks, function ($task) use ($state) {
            return $task['state'] === $state->value;
        });

        return $filteredByState;
    }

    public function sortByDate(string $date): array
    {
        if ($date === "old") {
            $data = $this->readData();
            return $data['tasks'];
        }

        return $this->getAllTasks();
    }

    public function changeState($taskID, $newState): void
    {
        $data = $this->readData();

        foreach ($data['tasks'] as &$task) {
            if ((int)$task['id'] === (int)$taskID) {
                $task['state'] = $newState;

                if ($newState === TaskState::FINISHED->value) {
                    $task['finished_at'] = date('Y-m-d H:i:s');
                } else {
                    $task['finished_at'] = null;
                }
            }
        }

        $this->writeData($data);
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
}*/
