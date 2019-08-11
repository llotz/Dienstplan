<?php
class calendarItem {
    var $data;
    var $name;
	
	// Example: $event = new ICS("2009-11-06 09:00","2009-11-06 21:00","Test Event","This is an event","GU1 1AA");
    function calendarItem($start,$end,$name,$description,$location, $organizer) {
        $this->name = $name;
        $this->data = "BEGIN:VCALENDAR
VERSION:2.0
METHOD:PUBLISH
BEGIN:VEVENT
TRANSP:OPAQUE
DTSTART:".date("Ymd\THis",strtotime($start))."
DTEND:".date("Ymd\THis",strtotime($end))."
ORGANIZER:".$organizer."
LOCATION:".$location."
TRANSP: OPAQUE
SEQUENCE:0
UID:
DTSTAMP:".date("Ymd\THis\Z")."
SUMMARY:".$name."
DESCRIPTION:".$description."
PRIORITY:1
CLASS:PUBLIC
BEGIN:VALARM
TRIGGER:-PT120M
ACTION:DISPLAY
DESCRIPTION:Reminder
END:VALARM
END:VEVENT
END:VCALENDAR";
    }
    function save() {
        file_put_contents($this->name.".ics",$this->data);
    }
    function show() {
		ob_end_clean();
        header("Content-type:text/calendar");
        header('Content-Disposition: attachment; filename="'.$this->name.'.ics"');
        header('Content-Length: '.strlen($this->data));
        header('Connection: close');
        echo $this->data;
        exit(0);
    }
}