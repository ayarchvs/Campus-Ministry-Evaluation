<?php
// access_control.php

function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

function can_manage_event($event_type) {
    if (is_admin()) {
        return true;
    }
    return isset($_SESSION['event_type']) && $_SESSION['event_type'] == $event_type;
}

function get_allowed_event_types() {
    if (is_admin()) {
        return ['Retreat', 'Recollection 01', 'Recollection 02'];
    }
    return isset($_SESSION['event_type']) ? [$_SESSION['event_type']] : [];
}

function can_add_staff() {
    return is_admin();
}
?>