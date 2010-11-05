<?php

class DefaultConf {
    const THEME = 'default';
    const BASEURL = 'http://localhost';
    const NAME = 'LPRMS';
    const TAG = 'Because we are awesome';
    const HOST = 'SIUC ACM';
    const HOSTLINK = 'http://acm.rso.siuc.edu';
    const RECAPTCHA_PUB = '6LeN-QsAAAAAANRw7fx2AcDcqbZzN0_n2Xm2X9y-';
    const RECAPTCHA_PRI = '6LeN-QsAAAAAAJrhIs7uSgnRni56g6bVHQPLOUs2';
    const GOOGLE_ANALYTICS = 'UA-15248894-3';
    const DATEFORMAT = 'M j, Y @ g:iA';
    const GOOGLE = '';
    const ADMIN = 'salukilan@gmail.com';

}

class SocialConf {
    const TWITTER = 'salukilan';
    const TWITTERLIST = '';
    const FACEBOOK = 'salukilan';
    const MYSPACE = 'salukilan';
    const STEAM = 'salukilan';
    const XFIRE = 'salukilan';
    const GOOGLE = '';
}

class TextConf {
    const REGISTER = 'Dear %name%,

Thank you for registering at %place%! Your user details are as follows:

Username: %username%
E-mail: %email%

Please click on the following link in order to confirm your e-mail address:
%confirmurl%

Sincerely,
%host%';

    const FORGOT = 'Dear %name%,

Someone originating from %ip% (probably you) requested a password reset for the following account:

Username: %username%
E-mail: %email%

Please click on the following link in order to continue with the password reset:
%reseturl%

If you did not request a password reset, you may safely ignore this e-mail.

Sincerely,
%host%';

    const THANKYOU = 'Dear %name%,

You have successfully activated your account at %place%!

Now is the opportunity to register for any upcoming events and/or tournaments:

UPCOMING EVENTS:
%eventlist%

Enjoy, and we hope to see you soon!

Sincerely,
%host%
';

    const RESETTED = 'Dear %name%,

You have successfully reset your password at %place%!

Now is the opportunity to register for any upcoming events and/or tournaments:

UPCOMING EVENTS:
%eventlist%

Enjoy, and we hope to see you soon!

Sincerely,
%host%
';

    const REMINDER = 'Dear %name%,

SalukiLAN starts tomorrow!

==== USER INFORMATION ====
Username: %username%
E-mail: %email%
Status: %active%

==== TIME ====
Start: May 1 @ 10AM
End: May 2 @ 5PM

==== LOCATION ====
Ballrooms C & D
2nd Floor
SIUC Student Center
1255 Lincoln Drive
Carbondale, IL 62901

GOOGLE MAP:
http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=1255+Lincoln+Drive,+Carbondale,+IL

==== PARKING ====
You may park in one of two areas:

Area 1: 2nd Level Parking Garage near SIUC Student Center
Area 2: Lot Between Parking Garage and US 51

==== INFORMATION FOR MINORS ====
If you are under 18 (or are fortunate enough to look so), please be ready to show some form of valid ID to enter the event. You, along with your parent or guardian, must also sign and date the following permission slip and present it in order to be admitted into the event:
http://www.spr.salukilan.com/SalukiLan_Slip.pdf
If more information is required, click here: http://www.spr.salukilan.com/?page_id=31

NOTE: AS STAFF WE RESERVE THE RIGHT TO REFUSE ADMISSION WITHOUT A PERMISSION SLIP SIGNED BY A PARENT/GUARDIAN!

==== T-SHIRTS ====
We have t-shirts! To place your order, click on the following link:
http://portal.salukilan.com/tshirt/
We have a limited supply, so purchase them now!

We will distribute shirts to those who have ordered them at the event.

==== REGISTRATION ====
Some of you have registered, but not joined the event/reserved your seat. Please do so before arriving, or else you will be classified as a walk-in!
Note: you must first login, then click on the following:
http://portal.salukilan.com/event/salukilan2010

To reserve your seat (while logged in):
http://portal.salukilan.com/event/salukilan2010/map

==== FINAL NOTES ====
Be aware that the forecast for the Carbondale, IL area is 70-80% chance of precipitation for the weekend.
Please, drive safely!

Let the games begin!

Sincerely,
%host%
';

}

?>
