This is a PHP application that is used for comparing registries of entities and detecting changes of entitities' status.
Registries are in form of CSV files. To serve its purpose, the script is initiated by a cron task everyday.
Current day's registry is downloaded from provided URL and compared with locally stored previous day's registry. 
Differences are written to CSV files:
a) active entities previously inactive,
b) inactive entities previously active.

Above mentioned CSV files are sent as attachments to recipients specified in addresses.php
In addition to that email body contains a table with differences.

send_mail.php is where the email can be customized. To send emails Mailer class is used which extends PHPMailer's PHPMailer.

This application is connected to a database. Database connection needs to be configured in database_config.php. Every time the script is run registered changes are put into a database. They can be seen at views/results_table.php.

After emails are sent to the recipients, current day's registry is saved locally, it overwrites previous day's registry. 