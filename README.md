# event-mgmt
Event Management System

#Setup Instructions:
1. Download the repository as zip.
2. Extract in your xampp htdocs folder or hosting's public_html folder, you can extract in current folder or in a subfolder(i.e event)
3. Create a database and import event.sql
4. Put your database credentials in config/database.json
5. Then open your browser and visit localhost or localhost/event (depending on your folder) or yourdomain.com or yourdomain.com/event (depending on your folder)
6. Use email: css@css.com and password: css@css.com for login
7. Live Project Link: http://event-mgmt.rf.gd/ (Due to using free hosting, I don't have SSL, so it might say dangerous website)

#Project Overview:
1. A host can register and log in.
2. Each host has his own dashboard.
3. Each host can Create, View , Update, Delete Events.
4. Events Have name, description, date and max capacity.
5. In login page, Event registration link is given, where users can browse events and register
6. Host can download event registration information as CSV file from his/her dashboard.
7. Live Project Link: http://event-mgmt.rf.gd/ (Due to using free hosting, I don't have SSL, so it might say dangerous website)
8. An API is implemented to fetch all the events with details information as JSON at once. API Link: http://event-mgmt.rf.gd/event_fetch_api.php

#Features:
1. Used Prepared SQL statements to prevent SQL injection.
2. Smooth user experience. Pages don't refresh after data submission.
3. Good Looking host dashboard, due to using popup modals in to create and edit events.
4. Pagination is used to show 5 data per page.
5. Search and Sorting functionality available.
6. An API is implemented to fetch all the events with details information as JSON at once. API Link: http://event-mgmt.rf.gd/event_fetch_api.php
