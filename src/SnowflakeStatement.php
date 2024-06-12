<?php

namespace Rdr\SnowflakeJodo;

class SnowflakeStatement
{
    protected $rows;
    protected $currentIndex = 0;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function fetch($fetchStyle = \PDO::FETCH_ASSOC)
    {
        if ($this->currentIndex < count($this->rows)) {
            $row = $this->rows[$this->currentIndex];
            $this->currentIndex++;
            return $this->formatRow($row, $fetchStyle);
        }
        return false;
    }

    public function fetchAll($fetchStyle = \PDO::FETCH_ASSOC)
    {
        $allRows = [];
        foreach ($this->rows as $row) {
            $allRows[] = $this->formatRow($row, $fetchStyle);
        }
        return $allRows;
    }

    protected function formatRow($row, $fetchStyle)
    {
        // Add more formats as needed
        switch ($fetchStyle) {
            case \PDO::FETCH_ASSOC:
                return $row;
            case \PDO::FETCH_NUM:
                return array_values($row);
            default:
                return $row;
        }
    }
}
