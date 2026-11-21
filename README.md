# JobHunt

JobHunt is a PHP and MySQL job board. It has a public site, candidate accounts, company accounts, and an admin area. AI tools are marked as coming soon.

## Run with XAMPP

1. Start Apache and MySQL.
2. Import `database/jobhunt.sql` into MySQL.
3. Check the database name, user, and password in `config/database.php`.
4. Open `http://localhost/tests/jobhunt/public/index.php?page=home`.

The app uses PHP 8.2 or newer. Password recovery needs PHP email (`mail()`) configured in XAMPP.

## Main features

- Create candidate and company accounts, sign in, and sign out.
- Search jobs, save jobs, apply, and track applications.
- Companies can publish jobs, review applicants, and update application status.
- Candidates can edit their profile and upload PDF, DOC, or DOCX resumes.
- Admins can manage users and job categories.
- AI CV optimization, job matching, and screening are coming soon.

## Main pages

- Home: `index.php?page=home`
- Jobs: `index.php?page=jobs`
- Sign in: `index.php?page=signin`
- Candidate area: `index.php?page=candidate-dashboard`
- Company area: `index.php?page=company-dashboard`
- Admin area: `index.php?page=admin-dashboard`

Three development demo accounts are already in the local database. Change their passwords before sharing or publishing the site.
