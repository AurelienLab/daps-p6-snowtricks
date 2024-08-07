[![Codacy Badge](https://app.codacy.com/project/badge/Grade/6ae0625a4d1449a3a0e64ed3c66ee654)](https://app.codacy.com/gh/AurelienLab/daps-p6-snowtricks/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

# Snowtricks

Snowtricks is a community-driven website where snowboard enthusiasts can share and learn about various snowboard tricks.
Users can contribute their own tricks and learn from others in the community.

## Installation

Follow these steps to install and set up the project on your local machine.

### Prerequisites

- PHP 8.3 or higher
- Composer
- Symfony CLI (optional to serve the project)
- Node.js and Yarn

### Clone the Repository

First, clone the repository to your local machine:

```
git clone https://github.com/AurelienLab/daps-p6-snowtricks.git snowtricks
cd snowtricks
```

### Install PHP Dependencies

Use Composer to install the required PHP dependencies:

```
composer install
```

### Install JavaScript Dependencies

Use Yarn to install the required JavaScript dependencies:

```
yarn install
```

### Set Up Environment Variables

Copy `.env` to `.env.local` file at the root of your project and configure your environment variables.

### Database Migration

Run the following command to create the database schema:

```
php bin/console doctrine:migrations:migrate
```

### Databse seed

You can prepopulate the database with categories, tricks and users:

```
php bin/console doctrine:fixtures:load
```

### Default credentials

| login                | password     | role          |
|----------------------|--------------|---------------|
| admin@snowtricks.com | STadmin2k24# | Administrator |
| user@snowtricks.com  | STuser2k24#  | User          |

### Build Assets

Build the front-end assets using Yarn:

```
yarn dev
```

For production, use:

```
yarn build
```

### Start the Server (optional)

Finally, start the Symfony server:

```
symfony serve
```

Your application should now be running at `http://127.0.0.1:8000`.