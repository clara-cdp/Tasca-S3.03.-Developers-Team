# 📝 Task-O-Mania
A task management application built using a custom-built PHP MVC Framework. The primary aim of this project is to master the management of existing codebases and to understand the inner workings of the Model-View-Controller (MVC) architectural pattern.

This project focuses on implementing key backend concepts, including:

- Advanced Routing: Directing traffic through a Front Controller.

- Controller Logic: Managing the bridge between user input and system response.

- Persistence: Handling data storage using JSON files (for lightweight storage) and MySQL (for relational database persistence).


## Features

- **CRUD:** Create, Read, Update, and Delete tasks.
- **Task Status:** Toggle between "Pending" and "Completed" states by clicking "start task" or "finish".
- **filter**: filter button for custom view of tasks.
- **search**: find wanted task quickly.
- **Responsive Design:** Fully optimized for mobile and desktop views via Tailwind.
- **Data Validation:** Secure input handling to prevent basic vulnerabilities.

# 🛠️ Technology

- **PHP 8**: Server-side logic and backend processing.
- **JSON**: Lightweight data storage for file-based persistence.
- **MySQL**: Relational database management.
- **Tailwind CSS**: Utility-first styling for a modern look.

# 🚀 Installation & Setup
Follow these steps to get the project running locally:

### JSON PERSISTANCE: 
1. Clone the repositoryBashgit clone https://github.com/your-username/repo-name.git
cd repo-name
2. Run the Server If you are using the PHP built-in server:Bashphp -S localhost:8000
3. Open your browser and go to http://localhost:8000.
   
### SQL PERSISTANCE: 
1. Clone the repositoryBashgit clone https://github.com/your-username/repo-name.git
cd repo-name
2. Database ConfigurationCreate a database named todo_db in your local environment (XAMPP, Laragon, etc.).Import the database.sql file located in the root directory.Note: Update your credentials in the connection file (e.g., config/db.inc.php):PHP$host = "localhost"; 
$host = "localhost";
$user = "root";
$pass = "your_password";
3. Run the ServerIf you are using the PHP built-in server:Bashphp -S localhost:8000
4. open your browser and go to http://localhost:8000.

# 📁 Project Structure

<img width="634" height="1490" alt="taskomania_structure" src="https://github.com/user-attachments/assets/64518340-8259-4ce6-b71e-eacc5683ed9d" />

# 🗂️ DATABASE structure

<img width="547" height="572" alt="taskomania_database" src="https://github.com/user-attachments/assets/0ca841e4-85a2-421f-a01b-52df9967874c" />





