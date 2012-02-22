<?php

class CriteriaBuilder {

    protected $buffer;

    function __construct() {
        $this->cleanBuffer();
    }

    public function cleanBuffer() {
        $this->buffer = "";
    }

    public function getBuffer() {
        return $this->buffer;
    }

    public function escape($val) {
        $ret = trim($val);
        if (!get_magic_quotes_gpc()) {
            $ret = mysql_real_escape_string($val);
        }
        return $ret;
    }

    public function where($field, $binOp, $value) {

        // TODO CHECK ESCAPING ON VALUE VAR
        // make test on where with accents, appostrophe and so on...
        $value = $this->escape($value);
        if (!is_numeric($value))
            $sql = "`$field` $binOp '" . $value . "' ";
        else
            $sql = "`$field` $binOp $value ";
        $this->buffer .= "WHERE $sql ";
        return $this;
    }

    public function andWhere($field, $binOp, $value) {
        $value = $this->escape($value);
        if (is_numeric($value))
            $this->buffer .= "AND `$field` $binOp $value ";
        else
            $this->buffer .= "AND `$field` $binOp '" . $value . "' ";
        return $this;
    }

    public function orWhere($field, $binOp, $value) {
        $value = $this->escape($value);
        if (is_numeric($value))
            $this->buffer .= "OR `$field` $binOp $value ";
        else
            $this->buffer .= "OR `$field` $binOp '" . $value . "' ";
        return $this;
    }

    /**
     * Append the statment to order the selected entries
     * Convention: "-field" mean DESC order on that field
     * whereas "field" mean ASC order on that field.
     * @return QueryBuilder
     */
    public function orderBy() {
        $fields = func_get_args();
        $n = count($fields);
        $i = 0;
        foreach ($fields as $arg) {
            $order = "ASC ";
            if (substr($arg, 0, 1) == "-") {
                $order = "DESC ";
                $count = 1;
                $arg = str_replace('-', '', $arg, $count);
            }
            $s = "$arg $order";
            if ($i < $n - 1)
                $s .= ", ";
            $i++;
        }
        $this->buffer .= "ORDER BY $s ";
        return $this;
    }

    /**
     * Append the LIMIT statement to the current buffer
     * If no offset is provided it takes 0 as default value.
     * @param int $value
     * @param int $offset
     * @return QueryBuilder
     */
    public function limit($value, $offset = null) {
        $this->buffer .= "LIMIT ";
        if (is_null($offset))
            $this->buffer .= $value;
        else
            $this->buffer .= "$offset, $value";
        return $this;
    }

    public function groupBy() {
        
    }

    public function distinct() {
        
    }

}