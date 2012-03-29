<?php

require_once 'utils/utils.php';
require_once 'db/Database.class.php';
require_once 'db/QueryBuilder.class.php';

//TODO: make use of static method for get create etc... 
// make some reading before on static usage in php and web fwk

/**
 * Abstract model
 * No abstract method so far, but could occur in the future.
 * @author victorinox
 *
 */
abstract class AbstractModel {

    /**
     * Object to handle database interactions from ready to use statments
     * @var object
     */
    protected $db;

    /**
     * Class to build query statment.
     * Should be combine with the Database class
     * to execute the statment generated.
     * @var object
     */
    protected $queryBuilder;

    /**
     * Name of the concrete class
     * @var string
     */
    protected $modelName;

    /**
     * Table name, generated in constructor
     * Convention: lowercase of the concrete model class name
     * @var string
     */
    protected $tableName;

    /**
     * Use to describe the model in the concrete class
     * @var array
     */
    protected $fields;

    /**
     * For describing uniqueness constraint on one
     * or multiple fields.
     * @var array
     */
    protected $uniqueness;

    /**
     * Contains all the PHP field objects according the
     * description given into $this->fields
     * Used as an interface to stuff data before building
     * an 'insert' query
     * @var array
     */
    private $fieldObjects = array();

    /**
     * Hold the data retrieved from the db.
     * It can be a multi dimensional array it holds
     * more than one entry.
     * @var array
     */
    private $fieldObjectsStack = array();

    function __construct() {
        $this->db = new Database();
        $this->queryBuilder = new QueryBuilder();
        $this->instantiateFields();
        $this->modelName = get_called_class();
        $this->tableName = caseSwitchToUnderScore($this->modelName);
    }

    /**
     * In case of a model is dynamically instantiated
     * (e.g to retrieve foreign key data) this method
     * called because we can not easily pass parameters
     * to a constructor called dynamically
     * @param object $db
     */
    public function setDBModule($db) {
        $this->db = $db;
    }

    public function getTableName() {
        return $this->tableName;
    }

    public function getFields() {
        return $this->fields;
    }

    public function getFieldsObjects() {
        return $this->fieldObjects;
    }

    public function setFieldValue($key, $value) {
        if (isset($this->fieldObjects[$key]))
            $this->fieldObjects[$key]->setValue($value);
    }

    private function instantiateFields() {
        $id = array('id' => array('class' => 'IntegerField', 'auto_increment' => true, 'primary_key' => true));
        $this->fields = array_merge($id, $this->fields);
        foreach ($this->fields as $fieldName => $arrayAttributes) {
            require_once 'db/fields/' . $arrayAttributes['class'] . '.class.php';
            $field = new $arrayAttributes['class'];

            $field->setAttributes($fieldName, $arrayAttributes);
            $this->fieldObjects[$fieldName] = $field;
        }
    }

    private function checkEntry() {
        $n = count($this->fieldObjectsStack);
        if ($n == 0)
            throw new Exception("Can't get a value from no entry", 0);
    }

    private function checkUniqueEntry() {
        $n = count($this->fieldObjectsStack);
        if ($n > 1)
            throw new Exception("Can't get a value from multiple entries", 0);
        if ($n == 0)
            throw new Exception("Can't get a value from no entry", 0);
    }

    public function getValues() {
        $ret = array();
        foreach ($this->fieldObjects as $key => $fieldObj) {
            $ret[$key] = $this->getValue($key);
        }
        return $ret;
    }

    public function getValue($fieldName) {
        $this->checkUniqueEntry();
        if (!array_key_exists($fieldName, $this->fieldObjects))
            throw new Exception("The field '$fieldName' doesn't exist in the " . get_called_class() . " model", 0);
        $dbFieldName = $this->fieldObjects[$fieldName]->getName();
        $ret = $this->fieldObjectsStack[0][$dbFieldName];
        if ($this->fields[$fieldName]['class'] == 'ForeignKeyField') {
            $pk = $ret;
            $className = $this->fields[$fieldName]['related_model'];
            $model = new $className;
            $model->setDBModule($this->db);
            $pkName = $model->getPrimaryKeyColumnName();
            $ret = $model->get(array($pkName => $pk));
        }
        return $ret;
    }

    public function getRelated($fieldName) {
        $this->checkUniqueEntry();
        if (!array_key_exists($fieldName, $this->fieldObjectsStack[0]))
            throw new Exception("The field '$fieldName' doesn't exist in the " . get_called_class() . " model", 0);
        if ($this->fields[$fieldName]['class'] != 'ForeignKeyField')
            throw new Exception("The field '$fieldName' is not defined as a ForeignKeyField in " . get_called_class() . " model", 0);

        $className = $this->fields[$fieldName]['related_model'];
        $model = new $className;
        $model->setDBModule($this->db);
        $pk = $model->getPrimaryKeyColumnName();
        $id_related = $this->getValue($fieldName);
        return $model->get(array($pk => $id_related));
    }

    /**
     * Take a variable length of param
     * @param $datas must be 1-or-2 dimensional
     * 2 dim is for creating several entries
     * @throws DBException::child
     */
    public function create(array $args) {
        $multiple_insert = true;
        if (!is_multi($args)) {
            $args = array($args);
            $multiple_insert = false;
        }
        foreach ($args as $data) {
            foreach ($this->fieldObjects as $fieldName => $fieldObj) {
                $fieldObj->reset();
                if (array_key_exists($fieldName, $data)) {
                    $fieldObj->setValue($data[$fieldName]);
                }
                $fieldObj->clean();
            }

            if ($multiple_insert) {
                $this->queryBuilder->multipleInsert($this->tableName, $this->fieldObjects);
            }
            else
                $this->queryBuilder->insert($this->tableName, $this->fieldObjects);
        }
        $stat = $this->queryBuilder->getStatment();
        $this->db->setStatment($stat)->executeQuery();
        return clone $this;
    }

    
    /**
     * Must be called
     * @param type $insert
     * @return type 
     */
    public function save($insert = true) {
        if ($insert) {
            $this->queryBuilder->insert($this->tableName, $this->fieldObjects);
        } else {
            //TODO: a save with insert = false requires update method to be called before...
            //print_a($this->fieldObjects);
            $this->queryBuilder->update($this->tableName, $this->fieldObjects);
        }
        $stat = $this->queryBuilder->getStatment();
        $this->db->setStatment($stat)->executeQuery();
        return ($insert) ? clone $this : $this;
    }

    /**
     * Must return only one entry matching the criteria.
     * Result stored into $this->fieldObjectsStack
     * @param array $criteria: array of K/V. the operator
     * used is AND
     */
    public function get(array $criterias) {
        unset($this->fieldObjectsStack);
        $qb = $this->queryBuilder->select()->from($this->tableName);
        $i = 0;
        foreach ($criterias as $fieldName => $value) {
            $dbFieldName = $this->fieldObjects[$fieldName]->getName();
            $this->fieldObjects[$fieldName]->setValue($value);
            $rawValue = $this->fieldObjects[$fieldName]->getValue();
            if ($i == 0) {
                $qb->where($dbFieldName, '=', $rawValue);
            } else {
                $qb->andWhere($dbFieldName, '=', $rawValue);
            }
            $i++;
        }
        $stat = $qb->getStatment();
        $this->db->setStatment($stat);
        $this->db->executeQuery();
        $rows = $this->db->count();
        if ($rows == 0) {
            require_once 'db/exceptions/NoEntryException.class.php';
            throw new NoEntryException($this->modelName);
        }
        if ($rows > 1) {
            require_once 'models/exceptions/MultipleEntryException.class.php';
            throw new MultipleEntryException($this->modelName);
        }

        //TODO : make conversion btw db types to php types
        $this->fieldObjectsStack[] = $this->db->fetchAssoc(); // TO CHECK
        /*         * $arr = $this->db->fetchAssoc();
          $entry = array();
          foreach ($this->fieldObjects as $fieldName => $fieldObj) {
          $dbFieldName = $this->fieldObjects[$fieldName]->getName();
          $entry[$fieldName] = $arr[$dbFieldName];
          }
          $this->fieldObjectsStack[] = $entry; */
        return clone $this;
    }

    /**
     * Update only if there is exactly one entry retrieved from
     * the DB
     * @param array $data: array containing updated K/V
     * @throws Exception: if there is more than 1 or 0 entry retrieved
     * from the DB.
     */
    public function update(array $data) {
        $this->checkUniqueEntry();
        foreach ($this->fieldObjects as $key => $fieldObj) {
            $fieldObj->setValue($this->fieldObjectsStack[0][$fieldObj->getName()]);
        }
        foreach ($data as $key => $value) {
            $this->fieldObjects[$key]->setValue($value);
        }
        return $this->save(false);
    }

    /**
     * Delete all the entries related to the model.
     * @param boolean $cascade: tells if deletion of child table content is allowed
     */
    public function deleteAll($cascade = false) {
        $this->queryBuilder->deleteAll($this->tableName, $cascade);
        $stat = $this->queryBuilder->getStatment();
        $this->db->setStatment($stat)->executeQuery();
        return $this;
    }

    /**
     * Delete only the current entry retrieved from the DB.
     * Callable only after a successful get method call.
     * @param boolean $cascade
     */
    public function deleteIt($cascade = false) {
        $this->checkUniqueEntry();
        $pk = $this->fieldObjectsStack[0]['id'];
        $qb = $this->queryBuilder->delete($this->tableName, $cascade)->where('id', '=', $pk);
        $this->db->setStatment($qb->getStatment())->executeQuery();
        return $this;
    }

    /**
     * Delete the filtered entry retrieved thanks to find method
     * @param array $criteria: should be like array('fieldname'=>array_of_values) or null
     * @return AbstractModel
     */
    public function delete($cascade = false) {
        $this->checkEntry();
        $qb = $this->queryBuilder->delete($this->tableName, $cascade);
        $qb->where('id', '=', $this->fieldObjectsStack[0]['id']);
        unset($this->fieldObjectsStack[0]);
        foreach ($this->fieldObjectsStack as $entry) {
            $qb->orWhere('id', '=', $entry['id']);
        }
        $this->db->setStatment($this->queryBuilder->getStatment());
        $this->db->executeQuery();
        return $this;
    }

    public function map($data) {
        $this->fieldObjectsStack[] = $data;
    }

    public function all() {
        $this->queryBuilder->select()->from($this->tableName);
        $this->db->setStatment($this->queryBuilder->getStatment())->executeQuery();
        $modelsArray = array();
        while ($data = $this->db->fetchAssoc()) {
            $this->fieldObjectsStack[] = $data;
            $model = new $this->modelName;
            $model->map($data);
            $modelsArray[] = $model;
        }
        return $modelsArray;
    }

    public function find($criteriaBuilder) {
        $this->queryBuilder->select()->from($this->tableName);
        $this->queryBuilder->setCriteria($criteriaBuilder);
	$stat = $this->queryBuilder->getStatment();
	$this->queryBuilder->cleanBuffer();
        $this->db->setStatment($stat)->executeQuery();
        $modelsArray = array();
        while ($data = $this->db->fetchAssoc()) {
            $this->fieldObjectsStack[] = $data;
            $model = new $this->modelName;
            $model->map($data);
            $modelsArray[] = $model;
        }
        return $modelsArray; // Add a container such as AbstractModelSet
        //in order to call delete on it...
    }

    public function latest() {
        $qb = $this->queryBuilder->select()->from($this->tableName);
        $qb = $qb->orderBy('-id')->limit(1);
        $this->db->setStatment($qb->getStatment())->executeQuery();
        unset($this->fieldObjectsStack);
        $this->fieldObjectsStack = array();
        $this->fieldObjectsStack[] = $this->db->fetchAssoc();
        return clone $this;
    }

    public function count() {
        return count($this->fieldObjectsStack);
    }

    public function getPrimaryKeyColumnName() {
        // assume that there is exactly only one primary key per table.
        $res = mysql_query("SHOW INDEX FROM `" . $this->tableName . "` WHERE `Key_name` = 'PRIMARY'");
        $row = mysql_fetch_assoc($res);
        return $row['Column_name'];
    }

    public function createTable() {
        $this->queryBuilder->createTable($this->tableName, $this->fieldObjects, $this->uniqueness);
        $sql = $this->queryBuilder->getStatment();
        $this->db->setStatment($sql)->executeQuery();
    }

    abstract public function toString();

    public function __toString() {
        if ($this->count() > 1) {
            return "[$this->modelName's models array]";
        } else {
            return $this->toString();
        }
    }

}
