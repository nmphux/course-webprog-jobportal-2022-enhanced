<?php

namespace Core;

use PDO;
use PDOStatement;

class Model
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Prepare and execute a SQL statement with optional parameters.
     */
    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Execute a query and return a single row, or null if none found.
     */
    protected function queryOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }

    /**
     * Execute a query and return all rows.
     */
    protected function queryAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Insert a row into the given table.
     *
     * @param string $table Table name
     * @param array  $data  Associative array of column => value
     * @return int The last inserted ID
     */
    protected function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($col) => ':' . $col, array_keys($data)));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        $this->query($sql, $data);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Update rows in the given table.
     *
     * @param string $table       Table name
     * @param array  $data        Associative array of column => value to set
     * @param string $where       WHERE clause (e.g., "id = :id")
     * @param array  $whereParams Parameters for the WHERE clause
     * @return int Number of affected rows
     */
    protected function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $setClauses = [];
        foreach (array_keys($data) as $col) {
            $setClauses[] = "{$col} = :set_{$col}";
        }
        $setString = implode(', ', $setClauses);

        $sql = "UPDATE {$table} SET {$setString} WHERE {$where}";

        // Prefix data keys with 'set_' to avoid collisions with where params
        $params = [];
        foreach ($data as $col => $value) {
            $params['set_' . $col] = $value;
        }
        $params = array_merge($params, $whereParams);

        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    /**
     * Delete rows from the given table.
     *
     * @param string $table       Table name
     * @param string $where       WHERE clause (e.g., "id = :id")
     * @param array  $whereParams Parameters for the WHERE clause
     * @return int Number of affected rows
     */
    protected function delete(string $table, string $where, array $whereParams = []): int
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->query($sql, $whereParams);
        return $stmt->rowCount();
    }

    /**
     * Execute a COUNT query and return the integer result.
     */
    protected function count(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return (int) $stmt->fetchColumn();
    }
}
