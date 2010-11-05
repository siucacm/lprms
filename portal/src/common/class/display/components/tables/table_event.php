<?php
class Table_Event
{
    public static function render()
    {
        $array = SQLProcedure::getInstance()->getEventList();
        if (count($array) == 0)
        {
            echo 'No Events Available';
            return;
        }
        ?>
        <table class="table_list">
            <tr>
                <th>Status</th>
                <th>Event</th>
                <th>When</th>
                <th>Duration</th>
                <th>Location</th>
                <th>Price</th>
                <th>Capacity</th>
            </tr>
        <?php
        foreach ($array as $value)
        {
            $value = array_merge($value['data'], $value['extra']);
        ?>
            <tr>
                <td>
                    <?php if ($value['active'] == 0) echo 'Expired';
                    else ;
                    ?>
                </td>
                <td><a href="<?php echo $value['link']; ?>"><?php echo $value['name']; ?></a></td>
                <td><?php echo date(Settings::getInstance()->dateformat, strtotime($value['datetime_start'])); ?></td>
                <td><?php echo $value['duration_h']; ?> hours</td>
                <td><?php echo $value['location_name']; ?></td>
                <td><?php echo '$'.$value['price']; ?></td>
                <td><?php echo $value['registered']; ?> / <?php echo $value['capacity']; ?></td>
            </tr>
        <?php
        }
        ?>
        </table>
        <?php
    }
}
?>
