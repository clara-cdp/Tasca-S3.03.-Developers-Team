<?php

class TaskModel extends Model
{
    public function init()
    {
        $this->_setTable('task');
    }

    public function fetchOne($id) //  updated id with idTASK :_S
    {
        $sql = 'SELECT * FROM ' . $this->_table;
        $sql .= ' WHERE idTASK = ?'; // real column name

        $statement = $this->_dbh->prepare($sql);
        $statement->execute(array($id));

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function getAllTasks()
    {
        $sql = 'select * from ' . $this->_table;

        $statement = $this->_dbh->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    protected function _setTable($table)
    {
        $this->_table = $table;
    }

    public function save($data = array())
    {
        $sql = '';

        $values = array();

        if (array_key_exists('idTASK', $data)) {
            $sql = 'update ' . $this->_table . ' set ';

            $first = true;
            foreach ($data as $key => $value) {
                if ($key != 'idTASK') {
                    $sql .= ($first == false ? ',' : '') . ' ' . $key . ' = ?';

                    $values[] = $value;

                    $first = false;
                }
            }

            // adds the id as well
            $values[] = $data['idTASK'];

            $sql .= ' where idTASK = ?'; // . $data['id'];

            $statement = $this->_dbh->prepare($sql);
            return $statement->execute($values);
        } else {
            $keys = array_keys($data);

            $sql = 'insert into ' . $this->_table . '(';
            $sql .= implode(',', $keys);
            $sql .= ')';
            $sql .= ' values (';

            $dataValues = array_values($data);
            $first = true;
            foreach ($dataValues as $value) {
                $sql .= ($first == false ? ',?' : '?');

                $values[] = $value;

                $first = false;
            }

            $sql .= ')';

            $statement = $this->_dbh->prepare($sql);
            if ($statement->execute($values)) {
                return $this->_dbh->lastInsertId();
            }
        }

        return false;
    }
    public function deleteTask(int $id): bool
    {
        $statement = $this->_dbh->prepare("delete from " . $this->_table . " where idTASK = ?");
        return $statement->execute(array($id));
    }


    public function searchTasks(string $keyWord): array
    {
        $allTasks = $this->getAllTasks();

        $filteredTasks = array_filter(
            $allTasks,
            fn($task) =>
            stripos($task['task_title'], $keyWord) !== false ||
                stripos($task['task_description'], $keyWord) !== false ||
                stripos($task['user_name'], $keyWord) !== false
        );

        return $filteredTasks;
    }

    public function sortByState(TaskState $state): array
    {
        $allTasks = $this->getAllTasks();

        $filteredByState = $filteredByState = array_filter($allTasks, function ($task) use ($state) {
            return $task['task_state'] === $state->value;
        });

        return $filteredByState;
    }

    public function sortByDate(string $date): array
    {
        $allTasks = $this->getAllTasks();

        if ($date === "old") {
            $oldFirst = array_reverse($allTasks);
            return $oldFirst;
        }

        return $this->getAllTasks();
    }

    public function changeState($taskID, $newState): void
    {

        $sql = "UPDATE " . $this->_table . " SET task_state = ?, finished_at = ? WHERE idTASK = ?";

        $finishedAt = null;
        if ($newState === TaskState::FINISHED->value) {
            $finishedAt = date('Y-m-d H:i:s');
        }

        $statement = $this->_dbh->prepare($sql);
        $statement->execute(array($newState, $finishedAt, $taskID));
        /*$data = $this->readData();

        foreach ($data['tasks'] as &$task) {
            if ((int)$task['idTASK'] === (int)$taskID) {
                $task['task_state'] = $newState;

                if ($newState === TaskState::FINISHED->value) {
                    $task['finished_at'] = date('Y-m-d H:i:s');
                } else {
                    $task['finished_at'] = null;
                }
            }
        }

        $this->writeData($data);*/
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
    }*/
}
