# Overview
Fruit Flip is a full-stack memory card game where players match pairs of fruit cards while trying to complete the game in as few moves as possible.

The application combines an interactive JavaScript frontend with a PHP and MySQL backend to store player information, game results, and leaderboard statistics.

## Features
- Interactive 16-card memory matching game
- Randomized card placement for each game
- Move tracking and match detection
- Animated card interactions and splash screen
- Persistent player and game data
- Player performance statistics
- Top-five leaderboard based on best scores
- Help interface with instructions

## Running Locally
Fruit Flip requires PHP and MySQL. It can be run locally using XAMPP.

1. Clone this repository.
2. Place the project inside the XAMPP `htdocs` directory.
3. Start Apache and MySQL through XAMPP.
4. Create the required MySQL database and tables.
5. Configure the database connection in `connect.php`.
6. Open the application through `localhost` in your browser.

## Tech Stack
**Frontend**
- HTML
- CSS
- JavaScript
- HTML Canvas API

**Backend**
- PHP
- PHP Data Objects (PDO)

**Database**
- MySQL

## How It Works
Fruit Flip uses object-oriented JavaScript to manage the game. Individual cards are represented by `Card` objects, while the `Game` class manages game state, card selection, match detection, move tracking, and game completion.

When a game is completed, the player's score is submitted to the PHP backend and stored in a MySQL database. PHP queries the database to calculate player statistics and generate a leaderboard containing the five best-performing players.

## Author
Nicole Carter

## Project Status
Fruit Flip was originally developed as a full-stack web development project and is currently being improved for public deployment.

Planned improvements include:
- Modernized responsive user interface
- Improved player identification and session management
- Updated database structure
- Public deployment