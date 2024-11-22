# Notifications in `app/Notifications`

This directory contains the notifications used to inform users about important events, such as password reset requests. Laravel's notification system is used to send notifications to various channels, such as email.

---

## **Notification Files**

### **1. `CustomResetPassword.php`**
Responsible for sending an email notification for password reset. This notification is triggered when a user submits a password reset request.

#### **Properties:**
- **$token**: The token used to verify the password reset request.

#### **Via Channels:**
The notification is only sent via **email**.

```php
public function via($notifiable)
{
    return ['mail'];
}
