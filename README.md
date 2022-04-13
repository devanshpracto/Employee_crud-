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



Note : I have started my server on the port 3306 , yours may be different also the username , password may be different too . 
Change these setting in .env file before starting the server 
DATABASE_URL="mysql://root:root@127.0.0.1:3306/emoployee?serverVersion=mariadb-10.4.21"

Api Endpoints: 

(For Employee) :

GET request for getting all employee :
http://127.0.0.1:8000/employee

POST request for create new employee :
http://127.0.0.1:8000/employee

GET request for getting all employee by id  :
http://127.0.0.1:8000/employee/{id}

PUT request for update a employee :
http://127.0.0.1:8000/employee/{id}

PUT request for update salary of a employee :
http://127.0.0.1:8000/employee/salary/{id}

DELETE request for deleting a employee :
http://127.0.0.1:8000/employee/{id}


(For Salary) :

GET request for getting all salary :
http://127.0.0.1:8000/salary

POST request for create new salary :
http://127.0.0.1:8000/salary

GET request for getting all salary by id  :
http://127.0.0.1:8000/salary/{id}

PUT request for update a salary :
http://127.0.0.1:8000/salary/{id}


DELETE request for deleting a salary :
http://127.0.0.1:8000/salary/{id}

(For Department) :

GET request for getting all department :
http://127.0.0.1:8000/department

POST request for create new department :
http://127.0.0.1:8000/department

GET request for getting all department by id  :
http://127.0.0.1:8000/department/{id}

PUT request for update a department :
http://127.0.0.1:8000/department/{id}


DELETE request for deleting a department :
http://127.0.0.1:8000/employee/{id}




