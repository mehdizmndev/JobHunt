# JobHunt

JobHunt is a PHP MVC recruitment SaaS prototype inspired by the provided Google Stitch design and product specification. The app includes a public marketing site, authentication flows, candidate workspace, company workspace, and admin workspace, all implemented with HTML/CSS/JavaScript and server-side PHP routing.

## Project structure

- `app/` — Controllers, models, and shared core classes
- `config/` — environment and application configuration
- `database/` — MySQL schema for the JobHunt relational model
- `public/` — web entry point and static assets
- `resources/views/` — HTML templates for all screens
- `routes/` — route registration for the app

## Run locally

1. Start Apache and MySQL via XAMPP.
2. Import `database/jobhunt.sql` into MySQL.
3. Open the app in a browser:
   - `http://localhost/jobhunt/public/index.php?page=home`

## Main pages

- Public landing page: `index.php?page=home`
- Job list: `index.php?page=jobs`
- Sign in: `index.php?page=signin`
- Candidate dashboard: `index.php?page=candidate-dashboard`
- Company dashboard: `index.php?page=company-dashboard`
- Admin dashboard: `index.php?page=admin-dashboard`

## Notes

This prototype focuses on the design and product structure described by the JobHunt specification, while keeping the code modular and easy to extend.
