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
        //$statement->execute(array($id));
        $statement->execute([$id]);

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
     
    }

}
