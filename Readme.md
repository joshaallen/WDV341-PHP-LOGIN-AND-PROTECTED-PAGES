# **Unit-13 Login and Protected Pages**

## 13-1: Create event_user table

A table is often used to contain the usernames and passwords of an website application. We will use a table called event_user.  This table needs to be built within your wdv341 database.  

1. Create the event_user table.
2. The event user_table should include the following fields.
    * event_user_id *This should be your primary key and it should auto increment
    * event_user_name
    * event_user_password
3. Create a row on this table with the following values for testing purposes.
    * event_user_name = "wdv341"
    * event_user_password = "wdv341"

ATTACH A screen shot of your completed table when you turn in this assigment. 

## 13-2: Create a login.php page

This assignment will create a login page.  This page will control access to all of the other pages in your application.  The page performs a variety of functions all within the one page. 

Create a `login.php` page.  It will do the following:
  1. This is a self posting page.
  2. If the user is not already signed on, display a form asking the user for their username and password.
  3. When the form is submitted it will call itself in order to validate the username and password.
  4. If the user has entered an **invalid** username and/or password the page will display an error message and the login form allowing the user to re-enter their information. If the user has already entered a valid username and password the page will display the adminstrator options available to a valid user. 
      * Add New Event
      * Show a list of events.  Provide an  Update and Delete option for each event.
      * Logout of Administrator
  5. If the user has entered a valid signon the page will establish a session variable called **validUser** and set its value to **true** and THEN display the administrator options available to a valid user.
  6. The page will display a Logout option as a link.  This option will call a page called `logout.php`.

## 13-3: Create a logout.php page

The logout page is called when the user/customer has completed their work in your system.  The logout page is used to clean up the session variables, close connections and do any additional work your system requires when a user is finished.

This page is very useful when testing SESSION variables.  It will be necessary for you to remove the session variables in order to test logins and page accesses.

For the user this is their way of "leaving" the Administrator area and going back to the public area of the website application.

Create a page called logout.php.  The page should do the following:
  1. The page should set your session variable validUser to false.
      * `session_unset( )`;
      * `session_destroy( )`;
  2. The page should redirect the user to the websites home page or login page.
      * Use the PHP `header( )` function to perform the redirect.

# **UNIT-14 Session Variables**
 
## 14-1: Protect your dynamic pages

This project uses the SESSION variable **validUser** to protect the pages in your Event Administration System (CMS).  It is established in your login.php process.

For this assignment you are going to protect your page from being accessed by unauthorized users.

This is the first step in protecting your database and its data.  In order to gain access to any pages that can INSERT/UPDATE/DELETE data from your database you must have a vaid username and password. The login page validates that you are valid user and sets that session variable **validUser** to yes.  

You will need to complete the following:

1. Create a log in page with a simple log in form
    * The log in page should validate the username and password against the users table created in Unit-13
    * If login fails, display a message telling the user "Invalid username or password"
    * If login succeeds, a session variable is created to validate the user on subsiquent pages and they're sent to the homepage
2. Create a homepage
    * This page should only be accessible if the user is logged in and has a valid session variable
    * If validation fails, send the user back to the login page

# **UNIT-15 SQL DELETE**
 
## 15-1: Create delete functionality

1. Create a page that displays all events (You can reuse the examples from Unit-6)
2. Create a delete button for each event
3. Add a Javascript event listener to each delete button that sends the user to a delete-event.php page
    * There should be a confirmation message before sending the user
    * The delete-event.php url that you send the user to should contain a parameter with the event ID to delete (i.e. delete-event.php?id=5)
4. delete-event.php will delete the event
    * Upon success or fail, redirect the user back to the events page
    * Display a success or error message to the user
5. You delete buttons should be protected using the HoneyPot method
    * You can wrap each button in a form, or the entire events list in a single form with a single HoneyPot input

When complete, please include a link to your working form in your homework submission so that I can test.
1. I'd recommend putting a couple of extra events for me to delete.

# **UNIT-16 SQL UPDATE**
 
## 16-1: Create Update Form for an Event

Create a form that will update a selected event from the selectEvents.php page. 

The form called updateEvent.php should do the following:

1. The form should use the 'recid' to get the selected event data from the database. 
2. It should load the data into the form fields.
3. Display the form to the user and allow for changes. 
4. Apply the HoneyPot validation method
5. UPDATE the record in the database.
6. Provide a confirmation message upon completion. 

When finished move all files to your host and to your Git repo.  Provide a link to your WDV341 homework page and to your Git repo on Blackboard when you submit the assignment.