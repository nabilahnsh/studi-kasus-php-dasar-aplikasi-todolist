<?php

namespace Repository {

    use Entity\TodoList;

    interface TodoListRepository
    {
        function save(TodoList $todolist): void;

        function remove(int $number): bool;

        function findAll(): array;
    }

    class TodoListRepositoryImpl implements TodoListRepository {
        public array $todolist = array();

        private \PDO $connection;

        public function __construct(\PDO $connection) {
            $this->connection = $connection;
        }

        function save(TodoList $todolist): void
        {
            //$number = sizeof($this->todolist) + 1;
            //$this->todolist[$number] = $todolist;
            $sql = "INSERT INTO todolist(todo) VALUES (?)";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$todolist->getTodo()]);
        }

        function remove(int $number): bool
        {
           /* if ($number > sizeof($this->todolist)) {
                return false;
            }

            for ($i = $number; $i < sizeof($this->todolist); $i++){
                $this->todolist[$i] = $this->todolist[$i + 1];
            }

            unset($this->todolist[sizeof($this->todolist)]);

            return true; */
            $sql = "SELECT id FROM todolist WHERE id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$number]);

            if ($statement->fetch()) {
                //id ada
                $sql = "DELETE FROM todolist WHERE id = ?";
                $statement = $this->connection->prepare($sql);
                $statement->execute([$number]);     
                return true;
            } else {
                // id tidak ada
                return false;
            }

        }

        function findAll(): array
        {
            //return $this->todolist;
            $sql = "SELECT id, todo FROM todolist";
            $statement = $this->connection->prepare($sql);
            $statement->execute();

            $result = [];

            foreach ($statement as $row) {
                $todolist = new Todolist();
                $todolist->setId($row['id']);
                $todolist->setTodo($row['todo']);

                $result[] = $todolist;
            }

            return $result;
        }
    }
}