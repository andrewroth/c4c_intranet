In order to make the site work on the crusade servers and so that it uses php5, the following line must be contained in the php5 directory in a .htaccess file.

----
AddHandler php-script .php
----
-------------------
A useful command to know to create a copy for production and development versions is 

svn co svn+ssh://svn.james.crusade.org/campus/apps/phoenix/trunk/ .
svn co svn+ssh://svn.james.crusade.org/campus/apps/phoenix/trunk/c4cwebsite .

-------------------
