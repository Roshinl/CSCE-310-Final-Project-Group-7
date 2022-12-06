# CSCE-310
Group 7
#
login.php - Page for logging in

register.php - Page for registering your account

loginRegBackend.php - Backend code for login.php and register.php

userHomePage.php - Home page after logging in. From here, the user can navigate to edit their profile (set appointment, other pages in future)

profileEdit.php - Page that allows user to edit their user account details as well as add payment information

profileEditBackend.php - Backend code for profileEdit.php

adminHomePage.php - Home page for admin. Ideally, login for admin takes them there. From here, admin can go to separate pages to deal with appointments, courses, etc.

adminAppointment - Page that allows admin to view all appointments, create appointment between any user/tutor, delete, and update appointments

adminAppointmentBackend - Backend code for adminAppointment.php

#
Index/Views

Clinton:

Index on username (many repeated queries with username attribute)

View named appointments_table_with_names joins 3 tables for a complex query

JP:

View called reviews_table_with_names; seen on reviews page, joins appointment, course, and user tables to display tutor names, appointment ids, and their respective reviews with all necessary data

Roshin:
View called user_table_with_paymentinfo joins the payment_info table with the user table to show admins the student's payment information for adding/deleting payment methods.
