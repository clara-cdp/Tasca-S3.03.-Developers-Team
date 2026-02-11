# 📝 Task-O-Mania
A task management application built using a custom-built PHP MVC Framework. The primary aim of this project is to master the management of existing codebases and to understand the inner workings of the Model-View-Controller (MVC) architectural pattern.

This project focuses on implementing key backend concepts, including:

- Advanced Routing: Directing traffic through a Front Controller.

- Controller Logic: Managing the bridge between user input and system response.

- Persistence: Handling data storage using JSON files (for lightweight storage) and MySQL (for relational database persistence).

<img width="2767" height="1459" alt="Captura de pantalla 2026-02-11 100941" src="https://github.com/user-attachments/assets/7c6f1e8b-2e59-407b-a140-58601c9804a6" />

## ⚙️ Features

- **CRUD:** Create, Read, Update, and Delete tasks.
- **Task Status:** Toggle between "Pending" and "Completed" states by clicking "start task" or "finish".
- **filter**: filter button for custom view of tasks.
- **search**: find wanted task quickly.
- **Responsive Design:** Fully optimized for mobile and desktop views via Tailwind.
- **Data Validation:** Secure input handling to prevent basic vulnerabilities.

## 🛠️ Technology

- **PHP 8**: Server-side logic and backend processing.
- **JSON**: Lightweight data storage for file-based persistence.
- **MySQL**: Relational database management.
- **Tailwind CSS**: Utility-first styling for a modern look.

 <img width="328" height="1137" alt="image" src="https://github.com/user-attachments/assets/d2b1df3b-f65e-46e8-94c0-959e77ed6552" />
 <img width="280" height="auto" alt="image" src="https://github.com/user-attachments/assets/887e97af-b24b-47ba-a68b-7234b6ddb222" />
 <img width="151" height="auto" alt="Captura de pantalla 2026-02-11 103152" src="https://github.com/user-attachments/assets/d6b9536d-3591-435e-837c-693489b9e2a7" />

 


## 🚀 Installation & Setup
Follow these steps to get the project running locally:

#### JSON PERSISTANCE: 
1. **switch to MAIN branch** 
2. Clone the repositoryBashgit clone https://github.com/clara-cdp/Tasca-S3.03.-Developers-Team
3. Run the Server If you are using the PHP built-in server:
Bash:  _php -S localhost:8000_
5. Open your browser and go to http://localhost:8000/web/home.
   
#### SQL PERSISTANCE: 
1. **switch to DEVELOP branch** 
2. Clone the repository
3. Bash: _git clone https://github.com/clara-cdp/Tasca-S3.03.-Developers-Team_
4. Database Configuration:
   - Create a database named my_database in your local environment (XAMPP, Laragon, etc.).
   - Import the my_database.sql file located in the config folder.
   - Note: Update your credentials in the connection file (e.g., config/db.inc.php):
     - $host = "localhost";
     - $user = "root";
     - $pass = "your_password";
   
6. Run the Server If you are using the PHP built-in server: Bash:  _php -S localhost:8000_

9. open your browser and go to http://localhost:8000/web/home.

## 📁 Project Structure

<img width="400" height="AUTO" alt="taskomania_structure" src="https://github.com/user-attachments/assets/64518340-8259-4ce6-b71e-eacc5683ed9d" />

## 🗂️ DATABASE structure

<img width="200" height="AUTO" alt="taskomania_database" src="https://github.com/user-attachments/assets/0ca841e4-85a2-421f-a01b-52df9967874c" />





