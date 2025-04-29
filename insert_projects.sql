-- First, get the user_id of the admin user
SET @admin_id = (SELECT user_id FROM users WHERE email = 'admin@example.com' LIMIT 1);

-- Insert projects
INSERT INTO projects (project_name, description, created_by) VALUES
('Website Development', 'Main company website development project', @admin_id),
('Mobile App', 'Mobile application development project', @admin_id),
('Database Migration', 'Legacy system database migration project', @admin_id),
('API Integration', 'Third-party API integration project', @admin_id),
('System Maintenance', 'Regular system maintenance and updates', @admin_id); 