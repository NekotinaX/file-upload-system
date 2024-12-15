Извинявай за предишното объркване! Ето по-семпъл и точен README.md файл, който включва само информацията, която си ми дал, и добавя споменаването на SQL файла:


# Registration System with File Upload and Download Dashboard 📂🚀

This is a **file upload and download system** where users can register, log in, and access a dashboard where they can upload files. Every registered user can download files, and the system tracks how many times each file has been downloaded in the database.

## Features ✨

- **Registration**: Users can register via a form with data validation.
- **Login**: Users can log in with their username and password.
- **Dashboard**: Users can upload and download files.
- **Download Tracking**: The system tracks how many times each file has been downloaded.

## Video Demo 🎥
If you'd like to see how the system works, watch the demo video here: [Project Demo](https://youtu.be/4U03A45RPcQ?si=VL_NAM9hRu1ANcNs)



## Setup Instructions 🖥️

1. **Clone the repository**:
   ```bash
   git clone https://github.com/NekotinaX/file-upload-system.git
   ```

2. **Install dependencies**:
   The project is written in **PHP**. Ensure that you have a local PHP server installed.

3. **Set up the database**:
   Import the provided SQL file into your MySQL database to create the necessary tables. The SQL file is included in the project.

4. **Start the server**:
   Place the project folder in your directory. Access the project in your browser at `http://localhost/your-project-folder`.

## Project Structure 🗂️

- `index.html`: The homepage for users to access the system.
- `login.php`: The login page for users to access the system.
- `register.php`: The registration page for new users.
- `database.sql`: SQL file for setting up the database tables.
- `database/db.php`: PHP file for the database connection setup.
- `dash/index.php`: The main dashboard where users can upload and download files.
- `dash/logout.php`: The logout functionality to exit the system.
- `style.css`: The CSS file for the design of the app.

