# Project Title
MiniFacebook
## Overview
MiniFacebook is a web application inspired by Facebook, offering a platform for users to connect, share posts, manage friendships, and explore dating features. Users can register, send friend requests, view their friends list, post text and images, block users, and access social media insights (if they are administrators).

In the dating section, users can search for others based on location and shared hobbies.

## Features
- User Registration
- Friend Requests
- Friends List
- Post Text and Images
- User Blocking
- Social Media Insights (Admins only)
- Dating: Search by Location and Hobbies

## Installation
1. **Install XAMPP**: Download and install XAMPP from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
2. **Start XAMPP**: Open XAMPP and ensure Apache and MySQL are running.
3. **Open phpMyAdmin**: Visit [http://localhost/phpmyadmin](http://localhost/phpmyadmin) in your browser.
4. **Create Database**:
   - Click on the "Databases" tab.
   - Enter "socialite_db" in the "Database name" field.
   - Click "Create" to create the database.

5. **Configure Database Credentials**:
   
   - Update the database credentials in `\facebook\commons\connection.php`
## Project Information
This project was developed as part of a collaborative effort at UniMi. It was a joint effort between Alessandro Scalambrino and Andrea Garofalo.