public function countDataWithConditions($table, $conditions)
{
    $query = "SELECT COUNT(*) as count FROM $table WHERE ";
    $params = [];
    foreach ($conditions as $key => $value) {
        if (strpos($key, '[>=]') !== false) {
            $query .= str_replace('[>=]', '', $key) . " >= ? AND ";
        } elseif (strpos($key, '[<=]') !== false) {
            $query .= str_replace('[<=]', '', $key) . " <= ? AND ";
        } else {
            $query .= "$key = ? AND ";
        }
        $params[] = $value;
    }
    $query = rtrim($query, ' AND ');
    $result = $this->query($query, $params);
    return $result[0]['count'] ?? 0;
}