This is a basic crud application designed in PHP using Symfony

Pre requistics :
1. Symfony should be installed in the system 
2. PHP should be installed 
3. Mysql server should be up and running .




To run this project follow these step:
1. clone this projects from this github repo
2. go the clone folder and run this command "composer install".
    It will install the required packages in your local system .
3. Run command "symfony server:start" to run the application.



Note : I have started my server on the port 3307 , yours may be different also the username , password may be different too . 
Change these setting in .env file before starting the server 
DATABASE_URL="mysql://root:root@127.0.0.1:3307/emoployee?serverVersion=mariadb-10.4.21"

Api Endpoints: 

(For Employee) :

GET request for getting all employee :
http://localhost/employee

POST request for create new employee :
http://localhost/employee

GET request for getting all employee by id  :
http://localhost/employee/{id}

PUT request for update a employee :
http://localhost/employee/{id}

PUT request for update a employee :
http://localhost/employee/salary/{id}

POST request for deleting a employee :
http://localhost/employee/{id}


(For Salary) :

GET request for getting all salary :
http://localhost/salary

POST request for create new salary :
http://localhost/salary

GET request for getting all salary by id  :
http://localhost/salary/{id}

PUT request for update a salary :
http://localhost/salary/{id}


POST request for deleting a salary :
http://localhost/salary/{id}

(For Department) :

GET request for getting all department :
http://localhost/department

POST request for create new department :
http://localhost/department

GET request for getting all department by id  :
http://localhost/department/{id}

PUT request for update a department :
http://localhost/department/{id}


POST request for deleting a department :
http://localhost/employee/{id}




