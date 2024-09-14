# TaxiPark Management System

## Project Overview

This project is a platform for taxi park management. It provides functionalities for adding and editing both drivers and cars, as well as viewing detailed change logs.

## Technology Stack

- **Backend**: Symfony PHP framework
- **Frontend**: React, Bootstrap
- **Database**: PostgreSQL
- **Web Server**: Nginx
- **Containerization**: Docker

## Data Fixtures

The project includes data fixtures to generate sample data for cars and drivers:
~~~
cd backend/
php bin/console doctrine:fixtures:load
~~~

## Installation and Setup

### 1. Using Docker (Recommended)

1. Clone the repository:
```
git clone https://github.com/smaiht/taxipark.git
cd taxipark
```
2. Build and run the Docker containers:
~~~
docker-compose up --build
~~~
3. Access the application:
- Frontend: http://localhost:30009
- Backend API: http://localhost:8009
To Stop Server Run:
~~~
docker-compose down
~~~


### 2. Local Development Setup

1. Clone the repository:
```
git clone https://github.com/smaiht/taxipark.git
cd taxipark
```
2. Set up the backend (Symfony):
~~~
cd backend
composer install
~~~
Edit the `.env` file and set the PostgreSQL credentials.

3. Set up the frontend (React):
~~~
cd ../frontend
npm install
~~~
Edit the `.env` file and set `REACT_APP_BACKEND_URL` to your local backend URL.

4. Start the PostgreSQL server locally.

5. Run the Symfony development server:
~~~
cd ../backend
symfony server:start
~~~

6. In a new terminal, start the React development server:
~~~
cd frontend
npm start
~~~
7. Access the application:
- Frontend: http://localhost:3000
- Backend API: http://localhost:8000 (or the port specified by Symfony)

## Configuration

- Backend environment variables are set in `backend/.env`
- Frontend environment variables are set in `frontend/.env`
- Docker configuration is in `docker-compose.yml` and the respective `Dockerfile`s in each service directory

