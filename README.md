## Installation
1. Install Valet on your machine using brew. Follow the instructions found here https://laravel.com/docs/5.6/valet#installation

2. If you don't already have mysql installed on your computer you can do this also using brew, instructions can be found on the link above. Create a mysql database for the project. Write down the name as this will be required later. 

3. Run the craft setup script. While in the root directory of the project type the following command in the terminal
```console
./craft setup 
``` 
4. Complete the setup process. You can see a sample below. It is important that to use the name of the database created in Step 2. 
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
5. Start the host using Valet. Type the following commands into the terminal
```console
valet link evoltuion7
valet secure evolution7
```
6. The webserver has now been created, you can now access the project at https://evoltuion7.test;
