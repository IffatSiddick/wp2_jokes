<?php
class DatabaseTable {
    private $pdo;
    private $table;
    private $primaryKey;

    public function __construct(PDO $user_pdo, string $user_table, string $user_primary_key) {
        $this->pdo = $user_pdo;
        $this->table = $user_table;
        $this->primaryKey = $user_primary_key;
    }

    public function alljokes(){
        $stmt = $this->pdo->prepare('SELECT joke.id, `joketext`, `jokedate`,`name`, `email` FROM `jokes`
        INNER JOIN `author` ON `authorid` = author.id');

        $stmt->execute();
        return $stmt->fetchALL();
    }

    public function findAll(){
        $stmt = $this->pdo->prepare('SELECT * FROM `' . $this->table . '`');
        $stmt->execute();
        return $stmt->fetchALL();
    }

    public function delete($field, $value) {
        $stmt = $this->pdo->prepare('DELETE FROM `' . $this->table . '` WHERE `' . $field .'` = :value');
        $values = [':value' => $value];
        $stmt->execute($values);
    }

    private function insert($values) {
        $query = 'INSERT INTO `' . $this->table . '` (';

        foreach($values as $key => $value){
            $query .='`' . $key . '`,';
        }

        $query = rtrim($query, ','); //remove last comma from query array
        $query .= ') VALUES (';

        foreach($values as $key => $value){
            $query .= ':' .$key .',';
        }

        $query = rtrim($query, ',');
        $query .= ')';
        $stmt = $this->pdo->prepare($query);
            $stmt->execute($values);
    }

    private function update($values) {

        $query = ' UPDATE `' . $this->table . '` SET ';

        foreach($values as $key => $value){
            $query .= '`' . $key . '` = :' . $key .',';

        }
        $query = rtrim($query, ',');
        $query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';
        $values['primaryKey'] = $values['id'];

        $stmt =$this->pdo->prepare($query);
        $stmt->execute($values);
    }

    public function findById($values) {
        $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->primaryKey. '` = :value';
        $values = [':value' => $values];
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($values);
        return $stmt->fetch();
    }

    public function find($field, $value) {
        $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $field. '` = :value';
        $values = [':value' => $value];
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($values);
        return $stmt->fetchAll();
    }

    public function total() {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM `' . $this->table . '`');
        $stmt->execute();
        $row = $stmt->fetch();
        return $row[0];
    }

    public function save($record) {
        try{
            if (empty($record[$this->primaryKey])) {
                unset($record[$this->primaryKey]);
            }
            $this->insert($record);
        }
        catch (PDOException $e){
            $this->update($record);
        }
    }

}