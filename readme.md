# Gitpab

<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>

![](/doc/spent-web.png)

## Who I am?

I am calculator of time spent in Gitlab by every user in period.
Just mark time spent in Gitlab and build report using me.

## Installation using docker

You may obtain needed project ids from gitlab Api:
https://gitlab.com/api/v4/projects?private_token=your_private_token&membership=1 

Clone this repo and run containers from `docker` folder:

```bash
git clone git@github.com:zubroide/gitpab.git
cd gitpab/docker
export host="https://gitlab.com/" \
    && export token="your_gitlab_private_token" \
    && export projects="project_id1,project_id2" \
    && docker-compose up --build app
```

Be patient. Loading data from Gitlab may take tens minutes at first time.

Open url http://127.0.0.1:8010  
And enter  
login `admin@admin`  
password `admin`

## Installation without docker

Create empty database in PostgreSQL.

```bash
git clone git@github.com:zubroide/gitpab.git
cd gitpab
composer install
php artisan key:generate
php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\ServiceProvider" --tag=assets
cp .env.example .env
```

Edit environment variables in `.env`:

- `GITLAB_PRIVATE_TOKEN` - is your private token from Gitlab.
- `GITLAB_RESTRICTIONS_PROJECT_IDS` - not necessary, project ids, that you need to monitor.
You are can find project ids using next command: `php artisan look:projects`.
- `APP_URL`
- `DB_DATABASE`
- `DB_USERNAME`
- `GITLAB_HOST`

Run migrations:
```bash
php artisan migrate
```

Fill dictionaries:
```bash
php artisan db:seed
```

Create user (with Admin role):
```bash
php artisan make:user
```

Build static:
```bash
npm install
npm run prod
```

## Usage

Run next command for import projects, issues and comments from Gitlab:

```bash
php artisan import:all
```

You can run it in schedule (every hour by defaults): `php artisan schedule:run`.

Now you can build report about spent time using command

```bash
php artisan stat:spent-time --start=2018-05-01 --finish=2018-06-01
```

Filter:

 - `start` - start date,
 - `finish` - finish date,
 - `user-id` - by assignee,
 - `project-id` - by project,
 - `issue-id` - by issue,
 - `order` - for example: `issue.iid`, `project.path_with_namespace`
 
 Result:

 ```
 +---------------------+-------------------+--------------+-------+----------------------------------+
 | gitlab_created_at   | project           | issue        | hours | description                      |
 +---------------------+-------------------+--------------+-------+----------------------------------+
 | 2018-05-18 12:23:56 | my-group/project1 | #5 My time   | 1.00  | Some work                        |
 | 2018-05-18 12:24:56 | my-group/project1 | #5 My time   | 0.50  | Export data into pdf             |
 | 2018-05-19 20:19:49 | my-group/project1 | #5 My time   | 1.00  | Create templates                 |
 | 2018-05-19 21:56:30 | my-group/project1 | #5 My time   | 0.50  | Reading requirements             |
 | 2018-05-18 12:23:56 | my-group/project2 | #152 My time | 1.00  | Skype call                       |
 | 2018-05-18 12:24:56 | my-group/project2 | #152 My time | 0.50  | Discussion about export into xml |
 +---------------------+-------------------+--------------+-------+----------------------------------+
```
