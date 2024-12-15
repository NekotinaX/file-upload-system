Извинявай за пропуска! Ето го актуализираният `README.md` файл, който включва директно вграден линк към видеото в текста:

```markdown
# Registration System with File Upload and Download Dashboard 📂🚀

This is a **file upload and download system** that allows users to register, log in, and gain access to a dashboard where they can upload files. Every registered user can download files, and the system tracks the number of times each file has been downloaded in the database.

## Features ✨

- **Registration**: Users can register via a form with data validation.
- **Login**: Users can log in with their username and password.
- **Dashboard**: Once logged in, users have access to a personalized dashboard where they can:
  - Upload files.
  - View a list of uploaded files.
  - Download files.
- **Download Tracking**: Every time a file is downloaded, the system logs the event in the database and tracks the number of downloads.

## How to Run the Project Locally 🖥️

1. **Clone the repository**:
   ```bash
   git clone https://github.com/NekotinaX/file-upload-system.git
   ```

2. **Install dependencies**:
   If you are using PHP, ensure that you have a local server like **XAMPP**, **MAMP**, or **LAMP** running.

3. **Set up the database**:
   Make sure you have a working MySQL or SQLite database and that the connection is properly configured.

4. **Start the server**:
   If you're using **XAMPP** or **MAMP**, place the project folder in the `htdocs` (XAMPP) or `www` (MAMP) directory. Then, start the Apache and MySQL services.
   Access the project in your browser at `http://localhost/your-project-folder`.

## Project Structure 🗂️

- `index.php`: Main entry point for the application (handles registration, login, and file upload).
- `dashboard.php`: The file that displays the user's dashboard after login.
- `upload.php`: Handles the file upload functionality.
- `templates/`: Folder with HTML templates for the pages of the app.
- `static/`: Folder for static files (CSS, images, JavaScript).
- `config.php`: Configuration file for database connection.
- `style.css`: The CSS file that handles the styling of the app.

## Example Workflow 🎯

1. The user registers via the registration form.
2. After successful registration, the user is redirected to the dashboard.
3. In the dashboard, the user can upload new files.
4. Other registered users can download the files, and the system tracks how many times they have been downloaded.

## Technologies ⚙️

- **Backend**: PHP
- **Frontend**: HTML, CSS
- **Database**: MySQL / SQLite (configured based on needs)
- **Authentication**: PHP sessions for login management

## Video Demo 🎥

If you'd like to get an idea of how the system looks and works, you can watch the demo video here: 

[Project Demo Video](https://youtu.be/4U03A45RPcQ?si=VL_NAM9hRu1ANcNs)

## License 📝

This project is open-source and licensed under the [MIT License](LICENSE).
```

### Key Updates:
- The **Video Demo** section now properly contains the clickable link to your YouTube video: [Project Demo Video](https://youtu.be/4U03A45RPcQ?si=VL_NAM9hRu1ANcNs).

This should now be ready to go! Just copy this into your `README.md` file, and the demo video will be included. Let me know if you need further tweaks!
