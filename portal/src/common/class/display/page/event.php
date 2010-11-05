<?php

class EventPage {
    public static function render($args) {
        Datastore::getInstance()->loadComponent('event');
        if (isset($args[0]))
            if (isset($args[1]))
                switch ($args[1]) {
                    case 'map':     self::render_map($args[0]); break;
                    case 'join':
                    case 'leave':
                    case 'seating':
                    case 'reserve':
                    default:        LPRMS::redirect('event/'.$args[0]);
                }
            else
                self::render_event($args[0]);
        else
            self::render_index();

        exit;
    }

    public static function render_index() {
        Display::header();
        ?>
<h1>Event List</h1>
        <?php
        Table_Event::render();

        Display::footer();
    }

    public static function render_event($sanitized) {
        $id = Library::lookupIdFromSanitized($sanitized);

        Display::header();

        if ($id == 0) echo 'No such event';
        else {
            $eventlist = Datastore::getInstance()->event;
            $event = $eventlist[$id];
            ?>
<h1><?php echo $event->name; ?></h1>
<div class="box">
    <div class="tabber">
        <div class="tabbertab" title="Details">
            <div class="location_map">

            </div>
            <div class="status">
                <span class="textheader">Where</span>
                <span class="location"><?php echo $event->location_name; ?></span><br />
            <?php echo $event->location; ?>

                <span class="textheader">When</span>
                <b>Start:</b> <?php echo date(Settings::getInstance()->dateformat, strtotime($event->datetime_start)); ?><br />
                <b>End:</b> <?php echo date(Settings::getInstance()->dateformat, strtotime($event->datetime_end)); ?><br />
                <b>Duration:</b> <?php echo $event->duration_h; ?> hours
            </div>
        </div>
        <div class="tabbertab" title="Information">
            <?php echo $event->information; ?>
        </div>
        <div class="tabbertab" title="Location Map">
            <iframe src="<?php echo $event->link_map; ?>"></iframe>
        </div>
        <div class="tabbertab" title="Seating Map">
        </div>
        <div class="tabbertab" title="Tournaments">
        </div>
        <div class="tabbertab" title="Attendees">
        </div>
        <div class="tabbertab" title="Register">
        </div>
    </div>
</div>
            <?php
        }
        Display::footer();
    }

    public static final function render_map($sanitized)
    {
        $id = Library::lookupIdFromSanitized($sanitized);
        if ($id == 0) echo 'No such event';
        else Blob_GoogleMap::render($id);
    }

}

?>
