# Task Management System

A simple and efficient task management system built with PHP and MySQL.

## Features

- Create and manage tasks
- Assign tasks to team members
- Track task status
- Project-based task organization
- Status history tracking
- User management

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- XAMPP/WAMP/LAMP stack

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/task-management-system.git
```

2. Import the database:
   - Open phpMyAdmin
   - Create a new database named `new_task`
   - Import the `database.sql` file

3. Configure the database connection:
   - Open `config/database.php`
   - Update the database credentials if needed:
     ```php
     private $host = "localhost";
     private $db_name = "new_task";
     private $username = "root";
     private $password = "";
     ```

4. Set up the initial data:
   - Run `add_default_admin.php` to create the admin user
   - Run `add_default_projects.php` to create default projects

5. Access the application:
   - Open your web browser
   - Navigate to `http://localhost/task-management-system`

## Project Structure

```
task-management-system/
├── config/
│   └── database.php
├── add_default_admin.php
├── add_default_projects.php
├── create_task.php
├── dashboard.php
├── database.sql
├── index.php
├── register.php
├── update_status.php
└── README.md
```

## Database Schema

### Users Table
- user_id (Primary Key)
- employee_id
- name
- email
- password
- designation
- team
- created_at

### Projects Table
- project_id (Primary Key)
- project_name
- description
- created_by (Foreign Key)
- created_at

### Tasks Table
- task_id (Primary Key)
- project_id (Foreign Key)
- title
- description
- assigned_to (Foreign Key)
- created_by (Foreign Key)
- deadline
- current_status
- created_at
- updated_at

### Task Status Log Table
- log_id (Primary Key)
- task_id (Foreign Key)
- status
- changed_by (Foreign Key)
- changed_at
- comments

## Usage

1. Access the dashboard at `http://localhost/task-management-system`
2. Create new tasks using the "Create New Task" button
3. Assign tasks to team members
4. Update task status as work progresses
5. View task history and comments

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email support@example.com or create an issue in the GitHub repository. 