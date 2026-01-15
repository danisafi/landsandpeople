# Coffee Catering Reservation System

## INFO 3305 WEB APP DEVELOPMENT
**Section:** 5   

### Group Member
- Dania Safiyya Binti Farid (2310056)  

---

## Project Overview
Lands & People Coffee Catering is a web-based booking system that is developed by using the Laravel framework. The system allows customers to browse coffee catering packages, submit booking requests, and manage their reservations online. Authenticated users can view, edit, and delete their bookings through a dedicated booking page.

---

## Project Objectives
Functional Objectives:
- To allow customers to submit coffee catering booking requests online.
- To provide a clear presentation of catering packages and services.
- To enable registered users to view, update, and delete their bookings.

Technical Objectives:
- To implement Laravel MVC architecture effectively.
- To implement full CRUD operations for booking management.
- To integrate secure user authentication using Laravel Jetstream.
  
---

## Target Users
- **Customers:** Customers can browse catering services without requiring an account.
- **Registered Users:**  Registered customers who want to submit booking requests and manage their bookings.

---

## Features and Functionalities
- User Registration & Login: Secure account creation and authentication.
- Homepage & Service Overview: View business information, operating hours, and services highlights.
- Package Showcase (Catalog-only style): Explore available coffee catering packages with detailed descriptions, pricing per cup, pax range, and flavour options.
- Online Reservation: Submit coffee catering reservations through an online booking form with event and contact details.
- Package Selection: Choose preferred catering packages during the booking process.
- Manage Booking: Manage existing booking either to view, update, and delete.
- Contact & Location Access: View cafe contact details, operating hours, and physical location via Google Map integration.
- Social Media Access: Connect to official social media platforms for updates and promotions.
- Responsive User Interface: Access the system seamlessly across desktop and mobile devices.

---

## Technical Implementation

** Technology Stack**

- Backend Framework: Laravel 10.x
- Frontend: Blade Templates with Bootstrap 5
- Database: MySQL 8.0
- Authentication: Laravel Breeze
- Image Storage: Laravel File Storage
- Development Environment: XAMPP

** Database Design**
Database Schema Overview 

Our database consists of 5 main tables designed to handle users, bookings and related data: 

Core Tables:
- Users – Stores customers's login and account information.
- Booking – Stores booking details made by users.
- 
      - id
      - name
      - email
      - phone
      - date
      - pax
      - package_id
      - address
      - user_id
      - timestamps
- Teams – Stores team information created within the system.


### Entity Relationship Diagram (ERD)

https://docs.google.com/document/d/1c4JFsu3OOlD9ZGYdNFtjqPW0GQNxHYiKma-kjQ6P_-U/edit?usp=sharing


### Key Relationships
- A user can have multiple bookings (one-to-many)
- A package can have multiple reservation details (one-to-many)
- A reservation detail can have multiple reservation update (one-to-many)
- A reservation can have one cancelled reservation (one-to-one (optional))

---

**Laravel Implementation**

- Routes (Web.php)

       Route::get('/', function () {
        return view('home');
      })->name('home');

        //View booking route
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

        //Other booking route (require login)
        Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () 
          {

        // Other booking routes (protected - require login)
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

        Route::get('/packages', function () {
            return view('packages'); 
        })->name('packages');
        });
  
- Controllers
  
1. BookingController:
   
    - Handles only authenticated users can create, edit, update, or delete bookings.
    - Users can only modify or delete their own bookings.
    - Guests trying to book are redirected to register.
    - Handles all strandard CRUD operations: Create, Read, Update, Delete.

      1.store() – Save new booking (guest or user)
      2.index() – Display user bookings
      3.edit() – Edit booking details
      4.update() – Update booking
      5.destroy() – Delete booking
   
- Models and Relationship
  
//Booking Model

    class Booking extends Model
    {
        use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'date',
        'pax',
        'package_id',
        'address',
    ];

     protected $casts = [
        'date' => 'datetime', // Now $booking->date is a Carbon instance
    ];

    // Relationship: A booking belongs to a user
    public function user()
    {
       // return $this->belongsTo(Package::class);
          return $this->belongsTo(User::class);
    }
    
    }


// Team Model
    
    class Team extends JetstreamTeam
    {
    
    use HasFactory;

    protected $fillable = [
        'name',
        'personal_team',
    ];

    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }
    }


// User Model
    
    class User extends Authenticatable
    {
    
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    }

- Views and User Interface

*Blade Template Structure:*

- master/layout.blade.php - Main application layout and navigation
- home.blade.php – Homepage with package displays, reservation form, and contact details
- bookings/index.blade.php - View existing reservation
- bookings/edit.blade.php - Manage reservation details
- auth/login.blade.php – User login form
- auth/register.blade.php – User registration form
- layouts/app.blade.php – Main layout for authenticated users
- layouts/guest.blade.php – Layout for guest pages (login, register)

 
 *Design Features:*
- Responsive Design: Built with Bootstrap 5 for a mobile-first layout.
- Color Scheme: Gray and peach theme reflecting the cafe.
- Navigation: Intuitive scrolling and navigation links for easy access to booking, packages, and contact information.
- Interactive Elements: Hero image slider, animated package displays, and a dynamic reservation form for real-time interaction.

---

## User Authentication System

** Authentication Features**
- **Registration System**: Secure account creation with password confirmation.
- **Login System**: Secure authentication with "Remember Me" option.
- **Password Reset**: Email-based password recovery.

---

### **Security Measures**
- User registration with password confirmation.
- Secure login with session handling.
- Password hashing using Laravel Breeze.
- Middleware protection for authenticated routes.

---

## Installation and Setup Instructions

### Prerequisites :
- PHP >= 8.1
- Composer
- Node.js and NPM
- MySQL 8.0
- XAMPP

### Step-by-Step Installation

### Installation Steps
1. Install - https://git-scm.com/install/
   
2. Clone the Repository
   - Create a folder in D: drive named 'coffee-clone'
   - Open folder 'coffee-clone' in VSC
   - In Terminal, type:
     
       - git clone https://github.com/danisafi/CoffeeReservation.git
         
       - cd CoffeeReservation
   
4. Install Dependencies (type in Terminal)
   
    -composer install
   
    -npm install

5. Environment Configuration (type in Terminal)
    - cp .env.example .env
    - configure the .env file
        - <img width="618" height="132" alt="image" src="https://github.com/user-attachments/assets/9dbf774b-bcca-454f-b8ed-98a5525b5054" />
        - <img width="240" height="147" alt="image" src="https://github.com/user-attachments/assets/e5380752-80a6-49c7-8f5d-efdd51ec8b65" />

    - php artisan key:generate

6. Database Setup (type in Terminal)
    - php artisan migrate
    - php artisan db:seed

7. Start Development Server (type in Terminal)
    - php artisan serve
    - npm run dev

---

## Testing and Quality Assurance

###  Functionality Testing

- Booking submission for guest and authenticated user.
- User registration and login system.
- Coffee packages display and selection.
- Booking CRUD operations.
- Active bookings display.
- Responsive design across devices.

### Browser Compatibility

 - Google Chrome 
 - Mozilla Firefox 
 - Safari 
 - Microsoft Edge 

 ### Performance Testing

 - Optimised database queries.
 - Reservation form submissions were tested to ensure fast response time and reliable data processing without page freezing or submission delays.
 - Responsive design tested on multiple screen sizes.

---

## Challenges Faced and Solutions

 ### Challenge 1: Designing an Efficient Booking Flow
 - Problem: To design a booking process that is simple for users while still collecting all required event details such as date, number of pax, selected package, and event address.
 - Solution: The booking form was created into clear input fields and labels.
 
 ### Challenge 2: Restricting Booking Access to Authenticated Users
 - Problem: Ensures that only authenticated users could submite reservation request.
 - Solution: Implemented Laravel authentication middleware to restrict booking routes to logged-in users only. The booking form and submission functionality is protected using authentication check and will prompt the users to register or login before making a reservation.
 
 ### Challenge 3: Managing User-Specific Booking Data
 - Problem: Since bookings are limited to authenticated users, the system need to associate each booking with the correct user.
 - Solution: A one-to-many relationship was established between users and bookings using Laravel's Eloquent ORM. Each booking record stores the authenticated user's ID to allow personalised booking management such as viewing, editing, or deleting bookings from the manage booking page.

---

## Future Enhancements

### Phase 2 Features (Potential Improvements)
- Location-Based Tracking: Map-based tracking to display catering delivery routes and event location.
- Custom Package Maker: Features that allows customers to design personalised coffee catering packages based on their preferences and budget.
-  Admin dashboard: A centralised management panel for admin to view, approve, reject, manage reservations, and update catering packages.
- Live Notifications: Real-time alerts for reservation confirmations, updates, cancellations, and booking status changes.
- Customer Feedback: Rating and review system to collect customer feedback and improve service quality.
- Booking Status: Enable booking status tracking (Pending, Confirmed, Completed, Cancelled).


### Scalability Considerations
- Database optimization to efficiently handle larger datasets.
- Implementation of caching mechanisms to improve system performance.
- API development to support mobile application integration.
- Load balancing strategies to ensure reliability under high-traffic scenarios.

---

## Learning Outcomes

### Technical Skills Gained
 - Laravel Framework: Applied MVC architecture and Eloquent ORM for structured application development.
 - Database Design: Designed normalized database schemas and managed relational data.
 - Authentication & Security: Implemented secure user authentication and authorization, and middleware protection using Laravel Breeze.
 - Frontend Development: Built responsive and user-friendly interfaces using Bootstrap.
 - Version Control: Utilized Git and GitHub for effective version control and collaborative project management.

### Soft Skills
 - **Team Collaboration** : Working effectively and cooperatively within a group environment.
 - **Team Communication**: Communicate with team members for the ease of project completion.
 - **Project Management** : Planning, organizing, and executing a complex web application project.
 - **Problem Solving** : Identifying, debugging, and resolving technical challenges.
 - **Documentation** : Produced clear, structured, and comprehensive technical and user documentation.
---

## References
- Figma Prototype - https://www.figma.com/design/K3AxbdMtMaGGnOj6ibEtlP/Coffee-Catering-Reservation?node-id=1-393&t=Wa0z1Wn5PMFQKfcy-1
- BOOTSTRAPMADE. (2026). Nice Restaurant – Elegant Bootstrap Template for Restaurants and Cafés 2026 | BootstrapMade. Bootstrapmade.com. https://bootstrapmade.com/nice-restaurant-bootstrap-template/
- Easy Eat. (2025). Easyeat.ai. https://easyeat.ai/r/landsnpeople/2

---

## Conclusion
The Coffee Catering Reservation System for Lands And People cafe successfully meets its functional and technical objectives by providing a secure, user-friendly, and responsive platform for managing coffee catering reservations. The implementation of authentication and CRUD functionality ensures data integrity, accountability, and efficient booking management, while Laravel Breeze enhances overall system security and reliability. Through the effective application of modern web development concepts and best practices, the system demonstrates scalability and strong potential for future enhancements to support real-world business operations.

---

### Key Achievements
- Successfully implemented all required Laravel components (Routes, Controllers, Views, and Models).
- Designed and developed a functional coffee reservation system with user role management.
- Built a responsive and user-friendly interface for seamless reservation and ordering.
- Demonstrated a strong understanding of database relationships and full CRUD operations.
- Applied security best practices for user authentication and access control

---

### Project Impact
Project Impact This project offers hands-on experience in developing real-world web applications and highlights the ability to collaborate effectively within a team. The skills acquired through this project are highly relevant and transferable to professional web development environments.

 - Project Completion Date: 15/1/2026
 - Course: INFO 3305 Web Application Development

---
