<?php 
## MO Case


mO-update / Mo DLR

1. check if failed
    status = 2
    else update DLR (mysql insert Procedure)


2. check if user resend active
    user-status = 1
    else Nothing ( Before procedure )

3. check if already resend
        if resend = 1 
            THEN PICK DATA{
                        MsgContent
                        DLT INFO
                        Resend SMSC fetch
                        }

         for MT and update resend = 0
     else resend = 0
        THEN nothing





$smsc = ['airtel','idea','voda'];

aritel = 33
idea=33
voda=33

aritel = 25
idea=25
voda=25
bsnl=25



?>