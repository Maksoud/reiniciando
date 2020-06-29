<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="format-detection" content="telephone=no" /> <!-- disable auto telephone linking in iOS -->
    <style type="text/css">
        /* RESET STYLES */
        html{ background-color:#E1E1E1; margin:0; padding:0; }
        body, #bodyTable, #bodyCell, #bodyCell{ height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, "Lucida Grande", sans-serif; }
        table{ border-collapse:collapse; }
        table[id=bodyTable]{ width:100%!important;margin:auto;max-width:900px!important;color:#7A7A7A;font-weight:normal; }
        img, a img{ border:0; outline:none; text-decoration:none;height:auto; line-height:100%; }
        a{ text-decoration:none !important;border-bottom: 1px solid; }
        h1, h2, h3, h4, h5, h6{ color:#5F5F5F; font-weight:normal; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0; }

        /* CLIENT-SPECIFIC STYLES */
        .ReadMsgBody{ width:100%; } .ExternalClass{ width:100%; } /* Force Hotmail/Outlook.com to display emails at full width. */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{ line-height:100%; } /* Force Hotmail/Outlook.com to display line heights normally. */
        table, td{ mso-table-lspace:0pt; mso-table-rspace:0pt; } /* Remove spacing between tables in Outlook 2007 and up. */
        #outlook a{ padding:0; } /* Force Outlook 2007 and up to provide a "view in browser" message. */
        img{ -ms-interpolation-mode: bicubic;display:block;outline:none; text-decoration:none; } /* Force IE to smoothly render resized images. */
        body, table, td, p, a, li, blockquote{ -ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; font-weight:normal!important; } /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */
        .ExternalClass td[class="ecxflexibleContainerBox"] h3{ padding-top: 10px !important; } /* Force hotmail to push 2-grid sub headers down */

        /* /\/\/\/\/\/\/\/\/ TEMPLATE STYLES /\/\/\/\/\/\/\/\/ */
        /* ========== Page Styles ========== */
        h1{ display:block;font-size:26px;font-style:normal;font-weight:normal;line-height:100%; }
        h2{ display:block;font-size:20px;font-style:normal;font-weight:normal;line-height:120%; }
        h3{ display:block;font-size:17px;font-style:normal;font-weight:normal;line-height:110%; }
        h4{ display:block;font-size:18px;font-style:italic;font-weight:normal;line-height:100%; }

        .flexibleImage{ height:auto; }
        .linkRemoveBorder{ border-bottom:0 !important; }
        table[class=flexibleContainerCellDivider]{ padding-bottom:0 !important;padding-top:0 !important; }
        body, #bodyTable{ background-color:#E1E1E1; }
        #emailHeader{ background-color:#E1E1E1; }
        #emailBody{ background-color:#FFFFFF; }
        #emailFooter{ background-color:#E1E1E1; }
        .nestedContainer{ background-color:#F8F8F8; border:1px solid #CCCCCC; }
        .emailButton{ background-color:#205478; border-collapse:separate; }
        .buttonContent{ color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center; }
        .buttonContent a{ color:#FFFFFF; display:block; text-decoration:none!important; border:0!important; }
        .emailCalendar{ background-color:#FFFFFF; border:1px solid #CCCCCC; }
        .emailCalendarMonth{ background-color:#205478; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center; }
        .emailCalendarDay{ color:#205478; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center; }
        .imageContentText{ margin-top: 10px;line-height:0; }
        .imageContentText a{ line-height:0; }
        #invisibleIntroduction{ display:none !important; } /* Removing the introduction text from the view */

        /*FRAMEWORK HACKS & OVERRIDES */
        span[class=ios-color-hack]  a{ color:#275100!important;text-decoration:none!important; } /* Remove all link colors in IOS (below are duplicates based on the color preference) */
        span[class=ios-color-hack2] a{ color:#205478!important;text-decoration:none!important; }
        span[class=ios-color-hack3] a{ color:#8B8B8B!important;text-decoration:none!important; }
        /* A nice and clean way to target phone numbers you want clickable and avoid a mobile phone from linking other numbers that look like, but are not phone numbers.  Use these two blocks of code to "unstyle" any numbers that may be linked.  The second block gives you a class to apply with a span tag to the numbers you would like linked and styled.
        Inspired by Campaign Monitor's article on using phone numbers in email: http://www.campaignmonitor.com/blog/post/3571/using-phone-numbers-in-html-email/.
        */
        .a[href^="tel"], a[href^="sms"]{ text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important; }
        .mobile_link a[href^="tel"], .mobile_link a[href^="sms"]{ text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important; }

        /* MOBILE STYLES */
        @media only screen and (max-width: 480px){
            /*////// CLIENT-SPECIFIC STYLES //////*/
            body{width:100% !important; min-width:100% !important; } /* Force iOS Mail to render the email at full width. */

            /* FRAMEWORK STYLES */
            table[id="emailHeader"],
            table[id="emailBody"],
            table[id="emailFooter"],
            table[class="flexibleContainer"],
            td[class="flexibleContainerCell"]{ width:100% !important; }
            td[class="flexibleContainerBox"], td[class="flexibleContainerBox"] table{ display: block;width: 100%;text-align: left; }
            td[class="imageContent"] img{ height:auto !important; width:100% !important; max-width:100% !important; }
            img[class="flexibleImage"]{ height:auto !important; width:100% !important;max-width:100% !important; }
            img[class="flexibleImageSmall"]{ height:auto !important; width:auto !important; }
            table[class="flexibleContainerBoxNext"]{ padding-top: 10px !important; }
            table[class="emailButton"]{ width:100% !important; }
            td[class="buttonContent"]{ padding:0 !important; }
            td[class="buttonContent"] a{ padding:15px !important; }
        }

        .text-left{ text-align: left; }
        .text-right{ text-align: right; }
        .text-center{ text-align: center; }
        .text-justify{ text-align: justify; }
        .text-nowrap{ white-space: nowrap; }
        .text-lowercase{ text-transform: lowercase; }
        .text-uppercase{ text-transform: uppercase; }
        .text-capitalize{ text-transform: capitalize; }
        .text-muted{ color: #777; }
        .text-primary{ color: #337ab7; }

        .left-0{  margin-left: 0px !important; }
        .left-5{  margin-left: 5px; }   .left-10{ margin-left: 10px; }
        .left-15{ margin-left: 15px; }  .left-20{ margin-left: 20px; }
        .left-25{ margin-left: 25px; }  .left-30{ margin-left: 30px; }
        .left-35{ margin-left: 35px; }  .left-40{ margin-left: 40px; }
        .left-45{ margin-left: 45px; }  .left-50{ margin-left: 50px; }
        .left-55{ margin-left: 55px; }  .left-60{ margin-left: 60px; }
        .left-65{ margin-left: 65px; }  .left-70{ margin-left: 70px; }
        .left-75{ margin-left: 75px; }  .left-80{ margin-left: 80px; }
        .left-85{ margin-left: 85px; }  .left-90{ margin-left: 90px; }
        .left-95{ margin-left: 95px; }  .left-100{margin-left: 100px; }
        .left-150{margin-left: 150px; } .left-200{margin-left: 200px; }

        .right-0{  margin-right: 0px !important; }
        .right-5{  margin-right: 5px; }   .right-10{ margin-right: 10px; }
        .right-15{ margin-right: 15px; }  .right-20{ margin-right: 20px; }
        .right-25{ margin-right: 25px; }  .right-30{ margin-right: 30px; }
        .right-35{ margin-right: 35px; }  .right-40{ margin-right: 40px; }
        .right-45{ margin-right: 45px; }  .right-50{ margin-right: 50px; }
        .right-55{ margin-right: 55px; }  .right-60{ margin-right: 60px; }
        .right-65{ margin-right: 65px; }  .right-70{ margin-right: 70px; }
        .right-75{ margin-right: 75px; }  .right-80{ margin-right: 80px; }
        .right-85{ margin-right: 85px; }  .right-90{ margin-right: 90px; }
        .right-95{ margin-right: 95px; }  .right-100{margin-right: 100px; }
        .right-150{margin-right: 150px; } .right-200{margin-right: 200px; }

        .top-0{  margin-top: 0px !important; }
        .top-5{  margin-top: 5px; }   .top-10{margin-top: 10px; }
        .top-15{ margin-top: 15px; }  .top-20{margin-top: 20px; }
        .top-25{ margin-top: 25px; }  .top-30{margin-top: 30px; }
        .top-35{ margin-top: 35px; }  .top-40{margin-top: 40px; }
        .top-45{ margin-top: 45px; }  .top-50{margin-top: 50px; }
        .top-55{ margin-top: 55px; }  .top-60{margin-top: 60px; }
        .top-65{ margin-top: 65px; }  .top-70{margin-top: 70px; }
        .top-75{ margin-top: 75px; }  .top-80{margin-top: 80px; }
        .top-85{ margin-top: 85px; }  .top-90{margin-top: 90px; }
        .top-95{ margin-top: 95px; }  .top-100{margin-top: 100px; }
        .top-150{margin-top: 150px; } .top-200{margin-top: 200px; }

        .bottom-0{ margin-bottom: 0px !important; }
        .bottom-5{ margin-bottom: 5px !important; }
        .bottom-10{margin-bottom: 10px; } .bottom-20{ margin-bottom: 20px; }
        .bottom-30{margin-bottom: 30px; } .bottom-40{ margin-bottom: 40px; }
        .bottom-50{margin-bottom: 50px; } .bottom-60{ margin-bottom: 60px; }
        .bottom-70{margin-bottom: 70px; } .bottom-80{ margin-bottom: 80px; }
        .bottom-90{margin-bottom: 90px; } .bottom-100{margin-bottom: 100px; }

        .font-9{ font-size: 11px !important; } .font-10{ font-size: 12px !important; } 
        .font-11{ font-size: 11px !important; } .font-12{ font-size: 12px !important; } 
        .font-13{ font-size: 13px !important; } .font-14{ font-size: 14px !important; } 
        .font-16{ font-size: 16px !important; } .font-18{ font-size: 18px !important; } 
        .font-20{ font-size: 20px !important; } .font-22{ font-size: 22px !important; } 
        .font-24{ font-size: 24px !important; } .font-26{ font-size: 26px !important; } 
        .font-28{ font-size: 28px !important; } .font-30{ font-size: 30px !important; } 
        .font-32{ font-size: 32px !important; } .font-34{ font-size: 34px !important; } 
        .font-36{ font-size: 36px !important; } .font-52{ font-size: 52px !important; }

        .width-50{  width: 50px;  word-wrap: break-word; } 
        .width-100{ width: 100px; word-wrap: break-word; }
        .width-150{ width: 150px; word-wrap: break-word; } 
        .width-155{ width: 155px; word-wrap: break-word; }
        .width-165{ width: 165px; word-wrap: break-word; } 
        .width-175{ width: 175px !important; word-wrap: break-word; }
        .width-190{ width: 190px !important; word-wrap: break-word; } 
        .width-200{ width: 200px !important; word-wrap: break-word; }
        .width-300{ width: 300px !important; word-wrap: break-word; } 
        .width-400{ width: 400px !important; word-wrap: break-word; }

        /*=====================================================*/
        /*  CONDITIONS FOR ANDROID DEVICES ONLY
        *   http://developer.android.com/guide/webapps/targeting.html
        *   http://pugetworks.com/2011/04/css-media-queries-for-targeting-different-mobile-devices/ ;
        =====================================================*/
        @media only screen and (-webkit-device-pixel-ratio:.75){
            /* Put CSS for low density (ldpi) Android layouts in here */
        }
        @media only screen and (-webkit-device-pixel-ratio:1){
            /* Put CSS for medium density (mdpi) Android layouts in here */
        }
        @media only screen and (-webkit-device-pixel-ratio:1.5){
            /* Put CSS for high density (hdpi) Android layouts in here */
        }
        /* end Android targeting */
        
        /* CONDITIONS FOR IOS DEVICES ONLY
        =====================================================*/
        @media only screen and (min-device-width : 320px) and (max-device-width:568px){ 
        }
        /* end IOS targeting */
    </style>

    <!--[if mso 12]>
            <style type="text/css">
                    .flexibleContainer{display:block !important; width:100% !important; }
            </style>
    <![endif]-->
    <!--[if mso 14]>
            <style type="text/css">
                    .flexibleContainer{display:block !important; width:100% !important; }
            </style>
    <![endif]-->
</head>