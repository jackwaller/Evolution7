## Installation
1. Install Valet on your machine using brew. Follow the instructions found here https://laravel.com/docs/5.6/valet#installation

2. If you don't already have mysql installed on your computer you can do this also using brew, instructions can be found on the link above. Create a mysql database for the project. Write down the name as this will be required later. 

3. Use composer to install dependencies. While in the root directory of the project type the following command in the terminal
```console
composer install 
``` 
4. Run the craft setup script.
```console
./craft setup 
``` 
5. Complete the setup process. You can see a sample below. It is important that to use the name of the database created in Step 2. 
```console
Which database driver are you using? [mysql,pgsql,?]: mysql
Database server name or IP address: [localhost] 127.0.0.1
Database port: [3306] 
Database username: [root]  
Database password: 
Database name: [Evolution7] 
Database table prefix: 

Install Craft now? (yes|no) [yes]:yes

Username: [admin] admin
Email: jack.waller94@gmail.com
Password: 
Confirm: 
Site name: evolution7
Site URL: [@web] evolution7.test
Site language: [en-US] 
```
6. Start the webhost using Valet. Type the following commands into the terminal
```console
valet link evoltuion7
valet secure evolution7
```
7. The webserver has now been created, access the project at https://evoltuion7.test/admin. Enter your credentials. Head to  Settings -> Plugins and install the Zomato plugin. 

8. Access the homepage of the application at https://evoltuion7.test/
