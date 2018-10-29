Sample MVC web application for educational demo purposes

Project creates cities and/or languages in the world
database.

Database (mysql/mariahdb) may be created by the file
worldsample.sql.

To test it, please clone or download to a directory 
within reach of your local web server. Install the 
database, and start playing.

Offered as is, no warranties, please read the licensing document.
Please study release notes.

/Niels ML

RELEASE NOTES 
2nd release 2017-10-10
    - database altered. Profile added to separate regular and admin
      users. User 'admin' added with password 'admin'.
    - controller code in index.php has been moved to controller :)
    - future functionalities
        - activation/deactivation only by admin
        - maintenance of profile only by admin
        - editing of password only by user and admin

1st release 2017-10-08
    - Login required. Users may be created, activation not
      implemented yet. Login as 'somebody', password 'password'.
    - The distribution of labor between index.php and the
      controller is not yet final.
