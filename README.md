Client-Contact Management System
A simple web-based application built in PHP (without any frameworks) that allows you to manage clients and contacts. It includes features such as contact linking, client code generation, validation, and a dark/light mode toggle for user experience.

Features
Add, list, and delete clients and contacts

Auto-generate unique 6-character client codes

Link contacts to multiple clients and vice versa

Unlink contacts from clients

View number of links per contact or client

Server-side and client-side form validation

Theme toggle (Light/Dark mode)


Validation & Requirements Covered
OOP structure

MVC pattern

Server-side validation (required fields, unique emails, client codes)

Client-side validation using HTML5


Notes
No frameworks were used (per assessment rules)

Email addresses and client codes are unique



Setup & Running the Project

XAMPP or similar local web server 
Steps to Run It:

Install XAMPP

Start Apache and MySQL from the XAMPP control panel.

Create the Database

Open http://localhost/phpmyadmin

Create a new database named:

client_contact_db

Open config/Database.php

Ensure the username and password match your MySQL setup:

Open your browser and navigate to:

http://localhost/client_contact_system/public/

