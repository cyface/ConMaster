The INSTALL Instructions assume that you can create a database named cyface on 
your system.

If you are installed on a hosting provider, this is probably not the case.

In order to work with a differently named database, this this what you need to
do.

1) Rename the database file:
	A) Go to cm/config
	B) Rename cyface.ini to <database_name.ini>

2) Change the connection string:
	A) Go to cm/config
	B) Edit conmaster.ini
	C) Change the connection string to reflect the new DB name.

That's it!
