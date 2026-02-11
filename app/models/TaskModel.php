<?php

class TaskModel extends Model
{
    public function init()
    {
        $this->_setTable('task');
    }


    public function fetchOne($id)
    {
        $sql = 'SELECT * FROM ' . $this->_table . ' WHERE idTASK = ?';
        $statement = $this->_dbh->prepare($sql);
        $statement->execute(array($id));
        return $statement->fetch(PDO::FETCH_ASSOC);
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
        $search = '%' . $keyWord . '%';

        $sql = 'SELECT * FROM ' . $this->_table .
            ' WHERE task_title LIKE ? 
             OR task_description LIKE ? 
             OR user_name LIKE ?';

        $statement = $this->_dbh->prepare($sql);
        $statement->execute([$search, $search, $search]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sortByState(TaskState $state): array
    {
        $sql = 'SELECT * FROM ' . $this->_table . ' WHERE task_state = ?';

        $statement = $this->_dbh->prepare($sql);
        $statement->execute(array($state->value));

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sortByDate(string $date): array
    {
        if ($date === "old") {
            $sql = 'SELECT * FROM ' . $this->_table . ' ORDER BY idTASK DESC';

            $statement = $this->_dbh->prepare($sql);
            $statement->execute(array());

            return $statement->fetchAll(PDO::FETCH_ASSOC);
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
    public function updateTask($task)
    {
        $data = [
            'idTASK' => $task['idTASK'],
            'task_title' => $task['task_title'],
            'task_description' => $task['task_description'],
            'user_name' => $task['user_name'],
            'task_state' => $task['task_state']
        ];
        return $this->save($data);
    }
}
