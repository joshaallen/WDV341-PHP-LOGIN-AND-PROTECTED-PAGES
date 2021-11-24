# **Unit-13 Login and Protected Pages**

## 13-1:Create event_user table

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

## 13-2:Create a login.php page

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

## 13-3:Create a logout.php page

The logout page is called when the user/customer has completed their work in your system.  The logout page is used to clean up the session variables, close connections and do any additional work your system requires when a user is finished.

This page is very useful when testing SESSION variables.  It will be necessary for you to remove the session variables in order to test logins and page accesses.

For the user this is their way of "leaving" the Administrator area and going back to the public area of the website application.

Create a page called logout.php.  The page should do the following:
  1. The page should set your session variable validUser to false.
      * `session_unset( )`;
      * `session_destroy( )`;
  2. The page should redirect the user to the websites home page or login page.
      * Use the PHP `header( )` function to perform the redirect.