## Setup Laravel

1.  cd to the project directory  
    `cd twitter-like-api-app`
2.  Install dependencies  
    `composer require`
3.  Setup the .env  
    `cp .env.example .env`
4.  Generate keys  
    `php artisan key:generate`
5.  Migrate the database. (Seeding is optional)  
    `php artisan migrate`
6.  Run the server  
    `php artisan serve`

## Consuming The API

This twitter-like-app-api contains the following requests.

**Authentication**

- Register User.
- Login User.
- Logout User.

**User**

- Get the user's Profile.
- Get someone's Profile.
- Follow a user.
- Unfollow a user.
- Get the user's following list.
- Get the user's followers list.

**Tweet**

- Create Tweet.
- Update Tweet.
- Delete Tweet.
- Get User's Tweet.

Click [here](https://documenter.getpostman.com/view/19979435/UVsLSmd4) to go the application's documentation on how to consume the API.
