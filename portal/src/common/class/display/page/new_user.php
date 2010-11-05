<?php

class Page {
    public static final function render()
    {
        echo '<h1 class="title">Incoming Users</h1>';
        $ulist = Library::list_user_ids();
        echo '<table width="100%">';
        for ($i = count($ulist) - 1; $i >= 0; $i--)
        {
            $uid = $ulist[$i];
            $user = Library::get_user_mini($uid);
            echo '<tr>';
            echo '<td>'.$user->id.'</td>';
            echo '<td>'.$user->name().'</td>';
            echo '<td>'.$user->username.'</td>';
            echo '</tr>';
            echo "\n\n";
        }

        echo '</table>';
    }
}
?>
