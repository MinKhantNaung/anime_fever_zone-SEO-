
# Project Title

### Anime Fever Zone (SEO)

You can visit here: 'https://animefeverzone.com'

## Project Description

- 'Anime Fever Zone' is a dedicated blog for anime enthusiasts, featuring reviews, news, and analysis of popular and emerging anime series. The blog aims to create a vibrant community for anime fans to share insights and stay updated on the latest trends.

## Blogger Features

- Topic Management:
  - Ability to create, update and delete topics.
  - Can upload one image.
- Tag Management:
  - Ability to create, update and delete tags.
  - Can upload one image.
- Post Management:
  - Ability to create, update and delete posts.
  - Can upload one post image.
  - Can manage which posts are featured.
  - Can send new post emails to subscribers.
    - Section Management: 
      - Ability to create, update and delete sections of a post.
      - Can upload multiple images and videos.
- Profile Management: 
  - Can update or delete profile details and profile image.
  - Can update password.
  - Can delete own account.
  - Can decide to enable or disable the email subscription feature on the post page.

## Frondend Features

1. **Responsive Design**: The frontend is designed to be responsive, ensuring compatibility across different devices and screen sizes. Users can access and utilize the system seamlessly from desktops, laptops, tablets, and mobile devices.
2. **User Authentication**: The frontend includes a user authentication system that allows users to create accounts, log in, and manage their profiles. They can also reset password.
3. **Tag Section**:  The frontend incorporates a tag section that features related posts.
4. **Post Section**: When users click a post, they can see post with images and videos.
5. **Comment System**: In post page, it includes a comment system. Users can comment in posts. *Authorized users have the ability to update and delete their own comments if necessary*.
6. **Like System**: Authenticated and non-authenticated users can like posts.
7. **Email Subscription**: Any user can subscribe to new post notifications by verifying their email.


## Technologies Used 

- PHP (Always latest version)
- Laravel (Always latest version)
- Livewire (SPA)
- Alpine
- HTML/CSS
- Javascript
- Tailwind
- Sweetalert 2

## Installation

- If cloning my project is complete or download is complete, open terminal in project directory.
- Install composer dependicies
  - **composer install** (command)
- Install npm dependicies
  - **npm install**
- Create a copy of .env file
  - **cp .env.example .env**
- Generate an app encryption key
  - **php artisan key:generate**
- Create an empty database for my web project
  - created database name must match from .env file
- Start npm 
  - **npm run dev**
- Migrate
  - **php artisan migrate**
- Seed Database
  - **php artisan db:seed**
- Link storage
  - **php artisan storage:link**
- Start 
  - **php artisan serve**

## SEO  

- I write custom command for generating site-map
  - **php artisan sitemap:generate**

## Usage

- Need Internet!
- In UserSeeder.php, I created blogger account.
- Login as blogger,
  - Email - blogger@gmail.com

