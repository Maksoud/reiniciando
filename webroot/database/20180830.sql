UPDATE `users` SET `sendmail` = "N" WHERE `sendmail` = "0";
UPDATE `users` SET `sendmail` = "S" WHERE `sendmail` = "1";