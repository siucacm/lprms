<?php

class MySQLProcedure extends SQLProcedure {

    public function getSettings()
    {
        $sql = SQL::getInstance();
        $sql->login();
        $array = $sql->query('SELECT * FROM '.$sql->table('core_settings').';');
        $sql->logout();

        $result = array();
        foreach ($array as $value)
            $result[$value['cat']][$value['key']] = $value['value'];

        return $result;
    }

    public function getLocationList()
    {
        $sql = SQL::getInstance();
        $sql->login();

        $array = $sql->query('SELECT * FROM '.$sql->table('core_locations').';');
        $sql->logout();

        return $array;
    }


    public function updateEntry($table, $data)
    {
        $sql = SQL::getInstance();
        $sql->login();

        $sql->update($table, $data, 'WHERE `id` = '.$data['id']);

        $sql->logout();
    }


    public function getEventList()
    {
        $sql = SQL::getInstance();
        $sql->login();

        $query1 = 'SELECT * FROM `core_events` ORDER BY `id` DESC';

        $query2 = 'SELECT
                    (SELECT CONCAT(`value`, \'/event/\', `t1`.`sanitized`) FROM '.$sql->table('core_settings').' WHERE `cat` = \'config\' AND `key` = \'url\') AS `link`,
                    (SELECT CONCAT(`value`, \'/event/\', `t1`.`sanitized`, \'/location\') FROM '.$sql->table('core_settings').' WHERE `cat` = \'config\' AND `key` = \'url\') AS `link_location`,
                    (SELECT CONCAT(`value`, \'/event/\', `t1`.`sanitized`, \'/map\') FROM '.$sql->table('core_settings').' WHERE `cat` = \'config\' AND `key` = \'url\') AS `link_map`,
                    (CASE (SELECT COUNT(*) FROM '.$sql->table('core_locations').' WHERE `t1`.`id_location` = `id`) WHEN 0 THEN \'\' ELSE (SELECT CAST(CONCAT(`room`, \'\n\', `floor`, \'\n\', `address1`, \'\n\', `address2`, \'\n\', `city`, \'\n\', `state`, \'\n\', `zip`, \'\n\', `country`) AS CHAR(512)) FROM '.$sql->table('core_locations').' WHERE `t1`.`id_location` = `id`) END) AS `location`,
                    (CASE (SELECT COUNT(*) FROM '.$sql->table('core_locations').' WHERE `t1`.`id_location` = `id`) WHEN 0 THEN \'\' ELSE (SELECT CAST(CONCAT(`address1`, \'\n\', `address2`, \'\n\', `city`, \'\n\', `state`, \'\n\', `zip`, \'\n\', `country`) AS CHAR(512)) FROM '.$sql->table('core_locations').' WHERE `t1`.`id_location` = `id`) END) AS `address`,
                    (CASE (SELECT COUNT(*) FROM '.$sql->table('core_locations').' WHERE `t1`.`id_location` = `id`) WHEN 0 THEN \'Unknown\' ELSE (SELECT `name` FROM '.$sql->table('core_locations').' WHERE `t1`.`id_location` = `id`) END) AS `location_name`,
                    (SELECT TIMESTAMPDIFF(SECOND, `t1`.`datetime_start`, `t1`.`datetime_end`)) AS `duration`,
                    (SELECT TIMESTAMPDIFF(HOUR, `t1`.`datetime_start`, `t1`.`datetime_end`)) AS `duration_h`,
                    (CASE WHEN (SELECT TIMESTAMPDIFF(SECOND, NOW(), `t1`.`datetime_end`)) > 0 THEN 1 ELSE 0 END) AS `active`,
                    (SELECT COUNT(*) FROM '.$sql->table('ref_user_event').' WHERE `id_event` = `t1`.`id`) AS `registered`,
                    (SELECT COUNT(*) FROM '.$sql->table('status_users').' AS `tt1` LEFT JOIN('.$sql->table('ref_user_event').' AS `tt2`) ON (`tt1`.`id_ref` = `tt2`.`id`) WHERE `checkout` = \'0000-00-00 00:00:00\' AND `tt2`.`id_event` = `t1`.`id`) AS `onsite`,
                    (CASE (SELECT COUNT(*) FROM '.$sql->table('ref_user_event').' WHERE `id_event` = `t1`.`id`) WHEN `t1`.`capacity` THEN 1 ELSE 0 END) AS `full`
                FROM '.$sql->table('core_events').' AS `t1` ORDER BY `id` DESC';

        $array1 = $sql->query($query1);
        $array2 = $sql->query($query2);

        $sql->logout();

        $results = array();

        for ($i = 0; $i < count($array1); $i++)
        {
            $results[$i]['data'] = $array1[$i];
            $results[$i]['extra'] = $array2[$i];
        }

        return $results;
    }
}

?>
