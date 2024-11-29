# Authentication Components

This project provides a set of reusable **authentication components** for managing user login, password recovery, and password reset flows in a web application. Built with **Vue 3** and **Inertia.js**, these components are designed to streamline the development of authentication features by providing pre-built and customizable components that handle common tasks related to user authentication.

### 1. **Login Form**
- The login form allows users to authenticate using their email and password.
- Includes a **"Remember me"** checkbox to keep users logged in across sessions.
- Includes a link for users who have forgotten their passwords, guiding them to the password reset page.

### 2. **Forgot Password Form**
- This form allows users to request a password reset link by entering their email address.
- Once the form is submitted, the user will receive a link to reset their password.

### 3. **Confirm Password Form**
- After receiving a password reset link, users can set a new password.
- This component contains fields for entering the new password and confirming it.
- Ensures that both passwords match before submitting to the backend.

### 4. **Forgot Password Link**
- A simple, reusable link component that can be placed in the login form.
- Navigates the user to the "forgot password" page when clicked.

## How it works

The authentication components use **Vue 3** with the **Composition API**, allowing for easy integration and customization. These components are designed to interact with backend routes using **Inertia.js** to send form data, receive responses, and handle errors without triggering full page reloads.

### Example flow:
1. **Login**: The user enters their email and password in the login form. If successful, the user is authenticated and redirected.
2. **Forgot Password**: If the user forgets their password, they can enter their email to request a password reset link. After submitting the form, they will receive an email with a reset link.
3. **Confirm Password**: After clicking the reset link, the user is prompted to enter and confirm their new password. Once both fields match, the password is updated, and the user is able to log in with their new credentials.

### Form Handling:
- The forms are powered by **Inertia.js**’s `useForm` hook to handle form submissions and manage state.
- Validation is handled in the components using simple error handling. Any errors returned from the backend (e.g., invalid email or mismatched passwords) are displayed next to the relevant input fields.
