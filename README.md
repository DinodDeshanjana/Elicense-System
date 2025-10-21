# 🚘 E-License Management System

The **E-License Management System** is a **web-based portal** designed to simplify the process of applying for, managing, and approving driving licenses online.  
This platform acts as a **centralized online hub for new drivers**, offering a smooth and transparent experience for both **users** and **administrators**.

---

## 🌐 Live Overview
This is a **simple and user-friendly** website that provides all the essential resources needed to start the driver’s license journey — from exam applications to license approval.

---

## 🖼️ Home Interface
<img width="1914" height="853" alt="Screenshot 2025-10-20 140620" src="https://github.com/user-attachments/assets/9f957ce1-73b7-4ee2-93a7-1340964601a3" />

---
## 🛠️ Technologies Used
- **HTML5** – Structure of the web pages  
- **CSS3** – Styling and layout  
- **Bootstrap 5** – Responsive and modern UI components  
- **PHP** – Server-side scripting and backend logic  
- **MySQL** – Database management and data storage

---

## 👥 User Features
- 📝 **Register an account** to access the system  
- 🧾 **Apply for an exam** online  
- 📅 **View exam status** — check if the application is *Approved*, *Rejected*, or *Pending*  
- 🕓 **View scheduled exam date** once approved  
- 🎯 **Check exam results** after completion  
- 🪪 **Track license approval status** — see if your license is *Processing* or *Ready for Collection*  
- 👤 **Manage user profile** and update personal information

---

## 🔧 Admin Features
- ✅ **Approve or reject exam applications** submitted by users  
- 🧮 **Update exam results** (Pass or Fail)  
- 🪪 **Manage license approval** process for qualified users  
- 👨‍💼 **Manage user accounts** (view, edit, or delete)

---

## 🗄️ Database Design
The **database** is the *"brain"* of the system, built using **MySQL** and named **`elicense_system`**.  
It efficiently handles all records and maintains relationships between users, applications, results, and licenses.

### Main Tables:
1. **`users`**  
   Stores user and admin login details.  
   **Columns:** `user_id`, `fullname`, `email`, `password` (hashed), `nic`, `role`

2. **`exam_applications`**  
   Contains all exam applications submitted by users.  
   Linked to the `users` table through `user_id`.  
   **Columns:** `application_id`, `user_id`, `status` (`Pending`, `Approved`, `Rejected`)

3. **`exam_results`**  
   Stores exam outcomes and dates.  
   Linked to the `exam_applications` table through `application_id`.  
   **Columns:** `result_id`, `application_id`, `exam_date`, `result` (`Pass`, `Fail`)

4. **`licenses`**  
   Tracks the final license status after a user passes the exam.  
   Linked to the `users` table through `user_id`.  
   **Columns:** `license_id`, `user_id`, `status` (`Processing`, `Ready for Collection`)

All tables are connected using **foreign keys** (`user_id`, `application_id`) to ensure accurate data relationships between users, applications, and results.

---

## 💡 Purpose of the Project
This system was developed to:
- Reduce manual paperwork in license application processes  
- Provide transparency for users tracking their exam and license status  
- Simplify admin management tasks  
- Deliver a digital solution to a real-world problem faced by new drivers

---

## 👨‍💻 Developer
**[Dinod Deshanjana]**  
🎓 Developer of E-License Management System    
🌐 GitHub Profile Link https://github.com/DinodDeshanjana

---

⭐ *If you found this project useful, don’t forget to star the repository!*
