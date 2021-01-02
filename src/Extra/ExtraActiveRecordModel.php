<?php

namespace Anax\Extra;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

class ExtraActiveRecordModel extends ActiveRecordModel
{
    public function findAllAndOrderBy($orderBy, $limit = 1000)
    {
        $this->checkDb();
        return $this->db->connect()
            ->select()
            ->from($this->tableName)
            ->orderBy($orderBy)
            ->limit($limit)
            ->execute()
            ->fetchAllClass(get_class($this));
    }

    public function findAllWhereOrderBy($orderBy, $where, $value, $limit = 1000)
    {
        $this->checkDb();
        $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
            ->select()
            ->from($this->tableName)
            ->orderBy($orderBy)
            ->where($where)
            ->limit($limit)
            ->execute($params)
            ->fetchAllClass(get_class($this));
    }

    public function findAllThenOrderByAndGroupBy($orderBy, $groupBy, $select = "*", $limit = 1000)
    {
        $this->checkDb();
        return $this->db->connect()
            ->select($select)
            ->from($this->tableName)
            ->groupBy($groupBy)
            ->orderBy($orderBy)
            ->limit($limit)
            ->execute()
            ->fetchAllClass(get_class($this));
    }
}
