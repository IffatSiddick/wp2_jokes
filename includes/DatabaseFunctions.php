<?php
function alljokes($pdo){
      $stmt = $pdo->prepare('SELECT joke.id, `joketext`, `jokedate`,`name`, `email` FROM `joke`
    INNER JOIN `author` ON `authorid` = author.id');

      $stmt->execute();
      return $stmt->fetchALL();
}


####### generic functions #06-01######

function findAll($pdo, $table){
    $stmt = $pdo->prepare('SELECT * FROM `' . $table . '`');
    $stmt->execute();
    return $stmt->fetchALL();
}

function delete($pdo, $table, $field, $value){
     $stmt = $pdo->prepare('DELETE FROM `' . $table . '` WHERE `' . $field .'` = :value');
     $values = [':value' => $value];
    $stmt->execute($values);
}

function insert($pdo, $table, $values){
    $query = 'INSERT INTO `' . $table . '` (';

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
$stmt =$pdo->prepare($query);
    $stmt->execute($values);
}

function update($pdo, $table, $primaryKey, $values){

    $query = ' UPDATE `' . $table . '` SET ';

    foreach($values as $key => $value){
        $query .= '`' . $key . '` = :' . $key .',';

    }
$query = rtrim($query, ',');
$query .= ' WHERE `' . $primaryKey . '` = :primaryKey';
$values['primaryKey'] = $values['id'];

$stmt =$pdo->prepare($query);
$stmt->execute($values);
}

function findById($pdo, $table, $primaryKey, $values){
$query = 'SELECT * FROM `' . $table . '` WHERE `' . $primaryKey. '` = :value';
  $values = [':value' => $values];
$stmt =$pdo->prepare($query);
$stmt->execute($values);
 return $stmt->fetch();

}
//more flexable version of findById,  allows find by any field - see page 285 for function call tweak.
function find($pdo, $table, $field, $value){
$query = 'SELECT * FROM `' . $table . '` WHERE `' . $field. '` = :value';
  $values = [':value' => $value];
$stmt =$pdo->prepare($query);
$stmt->execute($values);
 return $stmt->fetchAll();

}

function total($pdo, $table){
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM `' . $table . '`');
    $stmt->execute();
    $row = $stmt->fetch();
    return $row[0];
}

function save($pdo, $table, $primaryKey, $record){// page 297
    try{
        if (empty($record[$primaryKey])){
            unset($record[$primaryKey]);
        }
        insert($pdo, $table, $record);
    }
    catch (PDOException $e){
        update($pdo, $table, $primaryKey, $record);
    }
}




