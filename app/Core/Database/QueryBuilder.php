<?php

namespace App\Core\Database;

trait QueryBuilder
{
    public array $wheres = [];

    public function where($column, $operator = null, $value = null, $boolean = 'AND'): static
    {
        $this->wheres[] = compact('column', 'operator', 'value', 'boolean');

        return $this;
    }

    protected function compileWheres(): string
    {
        if (is_null($this->wheres)) {
            return '';
        }

        if (count($sql = $this->mapWheres()) > 0) {
            return $this->concatenateWhereClauses($sql);
        }
        return '';
    }

    protected function mapWheres(): array
    {
        return array_map(function ($where) {
            return $where['boolean'] . ' ' . '`' . $where['column'] . '`' . ' ' . $where['operator'] . ' ' . '\'' . $where['value'] . '\'';
        },
        $this->wheres);
    }

    protected function concatenateWhereClauses(array $sql): string
    {
        return 'WHERE' . ' ' . preg_replace('/and |or /i', '', implode(' ', $sql), 1);
    }
}