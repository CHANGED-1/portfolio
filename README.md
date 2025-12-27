# 🎨 Personal Portfolio Website with Admin Panel

A modern, full-featured portfolio website with a powerful admin panel for managing projects. Built with PHP, MySQL, HTML, CSS, and JavaScript - perfect for showcasing your work professionally.

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

---

## ✨ Features

### 🌐 Public Website
- **Modern Landing Page** - Eye-catching hero section with gradient design
- **Projects Showcase** - Grid layout with hover effects
- **Category Filtering** - Filter projects by category (Web Dev, Mobile App, Design, etc.)
- **Project Detail Pages** - Full project information with images, links, and technologies
- **Contact Form** - Functional contact form with database storage
- **Responsive Design** - Mobile-first, works on all devices
- **Professional Footer** - Social links and site information

### 🔐 Admin Panel
- **Secure Login System** - Password-protected admin access
- **Dashboard** - Statistics and quick overview
- **Complete CRUD Operations**:
  - ✅ **Create** - Add new projects with images
  - ✅ **Read** - View all projects in table format
  - ✅ **Update** - Edit existing projects
  - ✅ **Delete** - Remove projects (with image cleanup)
- **Image Upload** - Drag & drop image upload with validation
- **Category Management** - Organize projects by category
- **Featured Projects** - Mark projects to display on homepage
- **Project Status** - Track project stages (Completed/In Progress/Planned)
- **Contact Messages** - View messages from contact form

---

## 📸 Screenshots

### Public Website
```
🏠 Homepage          📂 Projects Page      📋 Project Detail
[Hero Section]      [Filter Bar]          [Full Description]
[Featured Projects] [All Projects Grid]   [Technologies Used]
                                           [Live/GitHub Links]
```

### Admin Panel
```
📊 Dashboard         ➕ Add Project        ✏️ Edit Project
[Statistics Cards]  [Upload Form]         [Edit Form]
[Recent Projects]   [Image Upload]        [Delete Option]
```

---

## 🚀 Quick Start

### Prerequisites
- PHP 7.0 or higher
- MySQL 5.6 or higher
- Apache Server (XAMPP/WAMP/MAMP)
- Web Browser

### Installation (5 Minutes)

**1. Clone or Download**
```bash
git clone https://github.com/CHANGED-1/portfolio.git
```

**2. Move to Web Directory**
- XAMPP: `C:\xampp\htdocs\portfolio\`
- WAMP: `C:\wamp64\www\portfolio\`
- MAMP: `/Applications/MAMP/htdocs/portfolio/`

**3. Create Database**
```sql
-- Open phpMyAdmin: http://localhost/phpmyadmin
-- Create new database: portfolio_db
-- Run the SQL file provided in the documentation
```

**4. Configure**
Edit `config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portfolio_db');
define('SITE_URL', 'http://localhost/portfolio');
```

**5. Set Permissions**
```bash
chmod 755 uploads/projects/
```

**6. Access**
- **Public Site**: `http://localhost/portfolio/`
- **Admin Panel**: `http://localhost/portfolio/admin/login.php`
  - Username: `admin`
  - Password: `password`

---

## 📁 Project Structure

```
portfolio/
│
├── 📄 index.php                 # Homepage
├── 📄 projects.php              # All projects page
├── 📄 project-detail.php        # Single project view
├── 📄 contact.php               # Contact page
├── 📄 config.php                # Database configuration
│
├── 📁 admin/                    # Admin Panel
│   ├── login.php               # Admin login
│   ├── dashboard.php           # Statistics dashboard
│   ├── add-project.php         # Add new project
│   ├── edit-project.php        # Edit existing project
│   ├── delete-project.php      # Delete project
│   ├── manage-projects.php     # View all projects
│   └── logout.php              # Admin logout
│
├── 📁 includes/                 # Reusable Components
│   ├── header.php              # Header template
│   ├── footer.php              # Footer template
│   └── functions.php           # Helper functions
│
├── 📁 css/                      # Stylesheets
│   ├── style.css               # Public site styles
│   └── admin.css               # Admin panel styles
│
├── 📁 js/                       # JavaScript
│   └── main.js                 # Main functionality
│
├── 📁 uploads/                  # File Storage
│   └── projects/               # Project images
│
└── 📄 README.md                 # Documentation
```

---

## 🎯 How It Works

### For Visitors (Public Side)

1. **Browse Homepage**
   - See featured projects
   - Eye-catching hero section
   
2. **Explore Projects**
   - Filter by category
   - Click to view details
   
3. **Contact You**
   - Fill contact form
   - Message saved in database

### For Administrators (Admin Panel)

1. **Login**
   ```
   admin/login.php
   ```

2. **View Dashboard**
   - Total projects count
   - New messages
   - Recent projects

3. **Manage Projects**
   - **Add**: Fill form → Upload image → Save
   - **Edit**: Select project → Modify → Update
   - **Delete**: Select project → Confirm → Removed

4. **View Messages**
   - See contact form submissions
   - Mark as read/replied

---

## 💡 Key Features Explained

### 1. CRUD Operations

**Create (Add Project)**
```php
// Form with validation
- Title, Description, Category (required)
- Image upload with validation
- Technologies, URLs (optional)
- Featured flag
```

**Read (View Projects)**
```php
// Display all projects
- Filterable by category
- Sortable by date
- Searchable (future enhancement)
```

**Update (Edit Project)**
```php
// Modify existing data
- Pre-filled form
- Image replacement
- Delete image option
```

**Delete (Remove Project)**
```php
// Safe deletion
- Removes database record
- Deletes associated image
- Confirmation required
```

### 2. Image Upload System

```php
✅ File type validation (jpg, png, gif, webp)
✅ Size limit (5MB max)
✅ Unique filenames (prevents overwrite)
✅ Secure upload directory
✅ Automatic cleanup on delete
```

### 3. Security Features

```php
🔒 Password hashing (bcrypt)
🔒 SQL injection prevention (prepared statements)
🔒 XSS protection (htmlspecialchars)
🔒 Session management
🔒 Admin authentication
🔒 File upload validation
```

---

## 🛠️ Customization Guide

### Change Colors

Edit `css/style.css`:
```css
:root {
    --primary: #667eea;      /* Your primary color */
    --secondary: #764ba2;    /* Your secondary color */
    --accent: #f093fb;       /* Your accent color */
}
```

### Update Site Name

Edit `config.php`:
```php
define('SITE_NAME', 'Your Name');
define('ADMIN_EMAIL', 'your@email.com');
```

### Add More Categories

```sql
INSERT INTO categories (name, slug) 
VALUES ('Photography', 'photography');
```

### Change Admin Password

```sql
-- Generate new hash for password 'newpassword123'
UPDATE admin_users 
SET password = '$2y$10$...' 
WHERE username = 'admin';
```

Or use this PHP code:
```php
echo password_hash('newpassword123', PASSWORD_DEFAULT);
```

---

## 📊 Database Schema

### Tables Overview

**admin_users**
```
id | username | email | password | created_at
```

**categories**
```
id | name | slug | created_at
```

**projects**
```
id | title | slug | description | full_description
category_id | image | project_url | github_url
technologies | status | featured | created_at | updated_at
```

**contact_messages**
```
id | name | email | subject | message | status | created_at
```

---

## 🎓 What You'll Learn

Building this project teaches you:

✅ **Backend Development**
- PHP programming
- MySQL database design
- CRUD operations
- File handling
- Authentication systems

✅ **Frontend Development**
- HTML5 semantic markup
- CSS3 (Grid, Flexbox, Gradients)
- Responsive design
- JavaScript DOM manipulation

✅ **Security**
- Password hashing
- SQL injection prevention
- XSS protection
- Input validation
- Session management

✅ **Best Practices**
- MVC-like structure
- Code organization
- Reusable components
- Error handling
- User experience design

---

## 🚧 Troubleshooting

### Common Issues

**❌ Database Connection Failed**
```
Solution:
1. Start MySQL in XAMPP/WAMP control panel
2. Check credentials in config.php
3. Verify database 'portfolio_db' exists
```

**❌ Images Not Uploading**
```
Solution:
1. Check folder exists: uploads/projects/
2. Set permissions: chmod 755
3. Verify php.ini: upload_max_filesize = 10M
```

**❌ Can't Login to Admin**
```
Solution:
1. Check admin user exists in database
2. Reset password using SQL provided
3. Clear browser cookies
```

**❌ Styles Not Loading**
```
Solution:
1. Clear browser cache (Ctrl + F5)
2. Check file paths in header.php
3. Verify CSS files exist
```

**❌ Blank Page Error**
```
Solution:
1. Enable error reporting in php.ini
2. Check PHP error logs
3. Verify all PHP files have <?php opening tag
```

---

## 🔄 Future Enhancements

### Phase 1 (Easy)
- [ ] Edit about section from admin
- [ ] Add skills section
- [ ] Social media links manager
- [ ] Profile picture upload
- [ ] Email notifications for messages

### Phase 2 (Intermediate)
- [ ] Multiple images per project
- [ ] Image gallery/carousel
- [ ] Blog section
- [ ] Testimonials
- [ ] Resume/CV download
- [ ] Project tags
- [ ] Search functionality
- [ ] Pagination

### Phase 3 (Advanced)
- [ ] RESTful API
- [ ] Multi-language support
- [ ] Analytics dashboard
- [ ] SEO optimization
- [ ] Social media auto-posting
- [ ] Export portfolio to PDF
- [ ] Two-factor authentication
- [ ] Activity logging

---

## 📚 Additional Resources

### Documentation
- [Complete Tutorial](docs/TUTORIAL.md) - Step-by-step guide
- [API Reference](docs/API.md) - Function documentation
- [Database Schema](docs/DATABASE.md) - Detailed schema

### Learning Resources
- [PHP Manual](https://www.php.net/manual/) - Official PHP documentation
- [MySQL Tutorial](https://dev.mysql.com/doc/) - MySQL reference
- [MDN Web Docs](https://developer.mozilla.org/) - HTML/CSS/JS guides

### Video Tutorials
- Setup walkthrough (Coming soon)
- Adding first project (Coming soon)
- Customization guide (Coming soon)

---

## 🤝 Contributing

Contributions are welcome! Here's how:

1. **Fork** the repository
2. **Create** a feature branch
   ```bash
   git checkout -b feature/AmazingFeature
   ```
3. **Commit** your changes
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```
4. **Push** to the branch
   ```bash
   git push origin feature/AmazingFeature
   ```
5. **Open** a Pull Request

### Contribution Ideas
- Bug fixes
- New features
- Documentation improvements
- Design enhancements
- Code optimization
- Test coverage

---

## 🐛 Bug Reports

Found a bug? Please open an issue with:
- Description of the problem
- Steps to reproduce
- Expected behavior
- Screenshots (if applicable)
- Your environment (PHP version, OS, browser)

---

## 📜 License

MIT License

```
Copyright (c) 2025 Guloba Moses

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
```

---

## 👨‍💻 Author

**Guloba Moses**
- Website: [yourwebsite.com](https://yourwebsite.com)
- GitHub: [@CHANGED-1](https://github.com/CHANGED-1/)
<!-- - LinkedIn: [Your Name](https://linkedin.com/in/yourprofile) -->
- Email: consult@guloba.com

---

## 🙏 Acknowledgments

- Design inspiration from modern portfolio websites
- Icons by [Font Awesome](https://fontawesome.com/)
- Gradient inspiration from [uiGradients](https://uigradients.com/)
- PHP & MySQL community

---

## 📞 Support

Need help? Here's how to get support:

1. **Documentation** - Read the complete guide above
2. **Issues** - Check existing [issues](https://github.com/CHANGED-1/portfolio/issues)
3. **Discussions** - Join [discussions](https://github.com/CHANGED-1/portfolio/discussions)
4. **Email** - Contact: your@email.com

---

## 🎉 Show Your Support

If you found this helpful:
- ⭐ **Star** this repository
- 🐛 **Report** bugs
- 💡 **Suggest** new features
- 📢 **Share** with others
- 🤝 **Contribute** code

---

## 📈 Project Stats

- **Lines of Code**: ~2,500+
- **Files**: 18
- **Database Tables**: 4
- **Features**: 25+
- **Development Time**: Learning project
- **Difficulty**: Beginner-Intermediate

---

## 🌟 Features Showcase

| Feature | Status | Description |
|---------|--------|-------------|
| CRUD Operations | ✅ Complete | Full Create, Read, Update, Delete |
| Image Upload | ✅ Complete | Secure file handling |
| Authentication | ✅ Complete | Login/logout system |
| Responsive Design | ✅ Complete | Mobile-friendly |
| Contact Form | ✅ Complete | Message storage |
| Admin Dashboard | ✅ Complete | Statistics display |
| Category Filter | ✅ Complete | Filter projects |
| Featured Projects | ✅ Complete | Homepage showcase |

---

**Built with ❤️ for learning web development**

⭐ Don't forget to star this repository if you found it helpful!

---

*Last Updated: December 2025*