# covidwebapp
A COVID web app run off of Azure virtual machines, which logs infections and visits of a user and informs them of infections near them. Completed for ECM1417 in 2021.

To change where the service is run to, edit the code where the virtual machine is declared to your preference. You will need to add databases accordingly as such:

user_info(first_name TEXT NOT NULL, surname TEXT NOT NULL, username TEXT NOT NULL UNIQUE, password TEXT NOT NULL, id INTEGER AUTO_INCREMENT NOT NULL, PRIMARY KEY(id));

visits(x FLOAT NOT NULL, y FLOAT NOT NULL, duration INTEGER NOT NULL, date TEXT NOT NULL, time TEXT NOT NULL, id INTEGER NOT NULL, visitid INTEGER NOT NULL AUTO_INCREMENT, PRIMARY KEY(visitid));

infections(x FLOAT NOT NULL, y FLOAT NOT NULL, duration INTEGER NOT NULL, date TEXT NOT NULL, time TEXT NOT NULL, id INTEGER NOT NULL, infectionid INTEGER NOT NULL AUTO_INCREMENT, PRIMARY KEY(infectionid));
