<?php

require_once 'db/CriteriaBuilder.class.php';

class QueryBuilder {

    protected $db;

    /**
     * Not supported yet but should be a value in
     * mysql/postresql etc...
     * @var string
     */
    protected $databaseType;
    protected $engine;
    protected $charset;
    protected $criteriaBuilder;
    protected $buffer;
    private $firstInsert;

    public function __construct() {
        $this->db = new Database();
        $this->engine = DATABASE_ENGINE;
        $this->databaseType = DATABASE_TYPE;
        $this->charset = DATABASE_CHARSET;
        $this->criteriaBuilder = new CriteriaBuilder();
        // append mode default: true, for user its the best mode.
        $this->firstInsert = true;
        $this->cleanBuffer();
    }

    public function setDBType($type) {
        $this->databaseType = $type;
    }

    public function setEngine($eng) {
        $this->engine = $eng;
    }

    private function cleanBuffer() {
        $this->buffer = "";
        $this->criteriaBuilder->cleanBuffer();
    }

    public function setCriteria($criteriaBuilder) {
        $this->criteriaBuilder = $criteriaBuilder;
        $this->buffer .= $criteriaBuilder->getBuffer();
    }

    public function getStatment() {
        $this->firstInsert = true;
        return $this->buffer;
    }

    public function escape($val) {
        $ret = trim($val);
        if (!get_magic_quotes_gpc()) {
            $ret = mysql_real_escape_string($val);
        }
        return $ret;
    }

    private function checkFieldName($str) {
        $t1 = strtolower(trim($str));
        if ($t1 != $str)
            throw new Exception("Model field names must no have spare blank space", 0);
        $t2 = preg_replace('/[^a-z_]/', '-', $t1);
        $t2 = preg_replace('/-+/', "-", $t2);
        if ($t2 != $t1)
            throw new Exception("Only [a-z_] character sequences are authorized for model field names ", 0);
    }

    public function createTable($tableName, $phpFieldObjects, $uniqueness) {
        $this->cleanBuffer();
        $this->buffer = "CREATE TABLE IF NOT EXISTS `$tableName` (";
        $n = count($phpFieldObjects);
        $i = 0;
        $tmp = array();
        $pks = array();
        $uniqFieldsClauses = array();
        foreach ($phpFieldObjects as $fieldName => $fieldObj) {
            $this->checkFieldName($fieldName);
            $ttmp = "`" . $fieldObj->getName() . "` " . $fieldObj->getDBType() . " ";
            if ($fieldObj->getAttribute('required')) {
                $ttmp .= "NOT ";
            }
            $ttmp .= "NULL ";

            if (!is_null($fieldObj->getAttribute('default_value'))) {
                $fieldObj->reset();
                $fieldObj->escape();
                $def = $fieldObj->getValue();
                $ttmp .= "DEFAULT '" . $def . "' ";
            }

            if ($fieldObj->getAttribute('auto_increment')) {
                $ttmp .= "AUTO_INCREMENT ";
            }


            if ($fieldObj->getAttribute('foreign_key')) {
                $ttmp .= ",";
                $ttmp .= "CONSTRAINT `fk_" . $fieldObj->getRelatedModelDBName() . "` ";
                $ttmp .= "FOREIGN KEY (`" . $fieldObj->getName() . "`) ";
                $ttmp .= "REFERENCES `" . $fieldObj->getRelatedModelDBName() . "` (`id`) ";
                $ttmp .= "ON DELETE CASCADE";
                $keyUniqFk = array_search($fieldName, $uniqueness);

                if ($keyUniqFk !== FALSE) {
                    $uniqueness[$keyUniqFk] = $uniqueness[$keyUniqFk] . "_id";
                }
            }

            if ($fieldObj->getAttribute('primary_key')) {
                $pks[] = $fieldObj->getName();
            }

            if ($fieldObj->getAttribute('unique')) {
                $uniqFieldsClauses[] = "UNIQUE (" . $fieldObj->getName() . ")";
            }

            $tmp[] = $ttmp;
        }

        $this->buffer .= flat_array($tmp, ",");

        $n = count($pks);
        if ($n > 0) {
            $this->buffer .= ", PRIMARY KEY (" . flat_array($pks, ",") . ")";
        }

        $n = count($uniqFieldsClauses);
        if ($n > 0) {
            $this->buffer .= ", " . flat_array($uniqFieldsClauses, ",");
        }

        $n = count($uniqueness);
        $i = 0;
        if ($n > 0) {
            $unique_key_name = "uniq_" . flat_array($uniqueness, "_");
            $fields = flat_array($uniqueness, ",");
            $this->buffer .= ", UNIQUE KEY `" . $unique_key_name . "` ($fields)";
        }

        $this->buffer .= ") ENGINE=$this->engine  DEFAULT CHARSET=$this->charset;";
    }

    public function select(array $fields = array()) {
        $this->cleanBuffer();
        $f = "*";
        if (count($fields) > 0) {
            $f = flat_array($fields, ',');
        }
        $this->buffer = "SELECT $f ";
        return $this;
    }

    public function from($tableName, $databaseName = DATABASE_NAME) {
        $this->buffer .= "FROM `" . $databaseName . "`.`" . $tableName . "` ";
        return $this;
    }

    public function insert($tableName, $ormFields) {
        $this->cleanBuffer();
        $n = count($ormFields);
        $i = 0;
        $fields = "";
        $values = "";
        $this->buffer = "INSERT INTO `" . $tableName . "` ";
        foreach ($ormFields as $fieldObj) {
            $fields .= $fieldObj->getName();
            $values .= "'" . $this->escape($fieldObj->getValue()) . "'";
            if ($i < $n - 1) {
                $fields .= ",";
                $values .= ",";
            }
            $i++;
        }
        $this->buffer .= "($fields) VALUES ($values);";
    }

    public function multipleInsert($tableName, $ormFields) {
        $n = count($ormFields);
        $i = 0;
        $fields = "";
        $values = "";
        foreach ($ormFields as $fieldObj) {
            $fields .= $fieldObj->getName();
            $values .= "'" . $this->escape($fieldObj->getValue()) . "'";
            if ($i < $n - 1) {
                $fields .= ",";
                $values .= ",";
            }
            $i++;
        }
        if ($this->firstInsert) {
            $this->cleanBuffer();
            $this->firstInsert = false;
            $this->buffer = "INSERT INTO `" . $tableName . "` ";
            $this->buffer .= "($fields) VALUES ($values) ";
        } else {
            $this->buffer .= ", ($values) ";
        }
    }

    /**
     * Support only the update of one entry.
     * Use the convention that each table has a `id` primary key
     * to find the entry according the $ormFields param.
     * @param String $tableName
     * @param array $ormFields
     * @return QueryBuilder
     */
    public function update($tableName, array $ormFields) {
        $this->cleanBuffer();
        $this->buffer = "UPDATE `" . $tableName . "` SET ";
        $id = $ormFields['id']->getValue();
        unset($ormFields['id']);
        $n = count($ormFields);
        $i = 0;
        foreach ($ormFields as $fieldObj) {
            $this->buffer .= $fieldObj->getName() . "=";
            if (is_numeric($fieldObj->getValue())) {
                $this->buffer .= $this->escape($fieldObj->getValue());
            } else {
                $this->buffer .= "'" . $fieldObj->getValue() . "'";
            }
            if ($i < $n - 1) {
                $this->buffer .= ",";
            }
            $this->buffer .= " ";
            $i++;
        }
        $this->where('id', '=', $id);
        return $this;
    }

    /**
     * Generate the delete statment base, and then
     * the where method must be called to provide criteria
     * @param String $tableName
     * @param boolean $cascade: trigger deletion of child's table's content
     * @throws Exception
     * @return QueryBuilder
     */
    public function delete($tableName, $cascade = false) {
        // We need to find the child table in order to deal
        // with the foreign key constraint
        $this->cleanBuffer();
        $this->select()->from("KEY_COLUMN_USAGE", 'information_schema')->where("REFERENCED_TABLE_NAME", "=", $tableName);
        $this->db->setStatment($this->getStatment())->executeQuery();
        if ($this->db->count() > 0 && !$cascade) {
            $data = $this->db->fetchAssoc();
            $referencedField = $data['REFERENCED_COLUMN_NAME'];
            $childTable = $data['TABLE_NAME'];
            $foreignKey = $data['COLUMN_NAME'];
            throw new Exception("Cascade delete is not allowed and the table `$tableName` holds `$childTable` as child.", 0);
        }

        $this->cleanBuffer();
        $this->buffer = "DELETE ";
        $this->from($tableName);
        return $this;
    }

    /**
     * Delete all the entries of a table.
     * @param String $tableName
     * @return QueryBuilder
     */
    public function deleteAll($tableName, $cascade) {
        $this->cleanBuffer();
        $this->select()->from("KEY_COLUMN_USAGE", 'information_schema')->where("REFERENCED_TABLE_NAME", "=", $tableName);
        $this->db->setStatment($this->getStatment());
        $res = $this->db->executeQuery();
        if ($res->count() > 0 && !$cascade) {
            require_once 'db/exceptions/CascadeDeletion.class.php';
            $data = $res->fetchAssoc();
            $referencedField = $data['REFERENCED_COLUMN_NAME'];
            $childTable = $data['TABLE_NAME'];
            $foreignKey = $data['COLUMN_NAME'];
            $ex = new CascadeDeletion();
            $ex->setMessage("Cascade delete is not allowed and the table `$tableName` holds `$childTable` as child.");
            throw $ex;
        }
        $this->buffer = "DELETE ";
        $this->from($tableName);
        return $this;
    }

    public function where($field, $binOp, $value) {
        $this->buffer .= $this->criteriaBuilder->where($field, $binOp, $value)->getBuffer();
        $this->criteriaBuilder->cleanBuffer();
        return $this;
    }

    public function andWhere($field, $binOp, $value) {
        $this->buffer .= $this->criteriaBuilder->andWhere($field, $binOp, $value)->getBuffer();
        $this->criteriaBuilder->cleanBuffer();
        return $this;
    }

    public function orWhere($field, $binOp, $value) {
        $this->buffer .= $this->criteriaBuilder->orWhere($field, $binOp, $value)->getBuffer();
        $this->criteriaBuilder->cleanBuffer();
        return $this;
    }

    public function orderBy() {
        $this->buffer .= $this->criteriaBuilder->orderBy(func_get_args())->getBuffer();
        $this->criteriaBuilder->cleanBuffer();
        return $this;
    }

    public function limit($value, $offset = null) {
        $this->buffer .= $this->criteriaBuilder->limit($value, $offset)->getBuffer();
        $this->criteriaBuilder->cleanBuffer();
        return $this;
    }

}
