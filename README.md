# Coffee Catering Reservation System

## Group Information 
**Section:** 5   

### Group Members
- Dania Safiyya Binti Farid (2310056)  

---

## Project Overview
Lands & People Coffee Catering is a web-based booking system that is developed by using the Laravel framework. The system allows customers to browse coffee catering packages, submit booking requests, and manage their reservations online. Authenticated users can view, edit, and delete their bookings through dedicated a booking page.

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
https://drive.google.com/file/d/1M581HbGbgGo_6I07NI9Z8xIYBwOJd6Ia/view?usp=sharing


### Key Relationships
- A user can have multiple bookings (one-to-many)
- A package can have multiple reservation details (one-to-many)
- A reservation detail can have multiple reservation update (one-to-many)
- A reservation can have one cancelled reservation ( One to One (optional))

---

** Laravel Implementation

- Routes (Web.php)

       Route::get('/', function () {
        return view('home');
      })->name('home');

        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

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
  
*Main Controllers Implemented are below :*
1. BookingController: Displays all bookings for the currently authenticated user

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

// Membership Model
class Membership extends JetstreamMembership
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}

// Team Model
class Team extends JetstreamTeam
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }
}

// TeamInvitation Model
class TeamInvitation extends JetstreamTeamInvitation
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'role',
    ];

    /**
     * Get the team that the invitation belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Jetstream::teamModel());
    }
}

// User Model
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

- Views and User Interface

*Blade Templates Structure:*

*api:*
- api-token-manage.blade.php – Manage API tokens
- index.blade.php – Main listing page for a resource

*auth:*
- confirm-password.blade.php – Confirm password for sensitive actions
- forgot-password.blade.php – Request password reset
- login.blade.php – User login form
- register.blade.php – User registration form
- reset-password.blade.php – Set new password after reset
- two-factor-challenge.blade.php – 2FA verification form
- verify-email.blade.php – Email verification notice
  
*bookings:*
edit.blade.php – Edit resource form

*components:*
- action-message.blade.php – Displays temporary success/error messages
- action-section.blade.php – Wrapper section for action forms
- application-logo.blade.php – App logo
- application-mark.blade.php – Small app mark/logo
- authentication-card-logo.blade.php – Logo in authentication card
- authentication-card.blade.php – Card wrapper for login/register forms
- banner.blade.php – Site-wide notification banner
- button.blade.php – Generic button component
- checkbox.blade.php – Styled checkbox input
- confirmation-modal.blade.php – Modal for confirming actions
- danger-button.blade.php – Button for destructive actions
- dialog-modal.blade.php – General-purpose modal dialog
- dropdown-link.blade.php – Link inside a dropdown menu
- dropdown.blade.php – Dropdown menu wrapper
- form-section.blade.php – Section wrapper for forms
- input-error.blade.php – Displays input validation errors
- input.blade.php – Input field component
- label.blade.php – Input label component
- modal.blade.php – General modal wrapper
- nav-link.blade.php – Navigation link component
- responsive-nav-link.blade.php – Nav link for mobile/responsive view
- secondary-button.blade.php – Styled secondary button
- section-border.blade.php – Decorative border between sections
- section-title.blade.php – Styled section heading
- switchable-team.blade.php – Component to switch between teams
- validation-errors.blade.php – Displays all form validation errors
- welcome.blade.php – Welcome/home page for guests

*emailss:*
- team-invitation.blade.php – Page for inviting users to a team

*layouts:*
- app.blade.php – Main layout for authenticated users
- guest.blade.php – Layout for guest pages (login, register)
  
*master:*
- layout.blade.php – Base layout wrapper
- delete-user-form.blade.php – Form to delete a user account
- logout-other-browser-sessions-form.blade.php – Log out from other devices
- show.blade.php – View single resource details
- two-factor-authentication-form.blade.php – Manage 2FA setup
- update-password-form.blade.php – Form to update user password
- update-profile-information-form.blade.php – Update profile info form

*teams:*
- create-team-form.blade.php – Form to create a new team
- create.blade.php – Form to create a resource
- team-member-manager.blade.php – Manage team members
- update-team-name-form.blade.php – Form to update a team’s name
  
- home.blade.php – Homepage for cafe reservation introduction
- navigation-menu.php – Responsive navigation menu
- policy.blade.php – Guest page showing policy content
- terms.blade.php – Guest page showing terms and conditions

 *Design Features:*
- Responsive Design: Built with Bootstrap 5 for a mobile-first layout.
- Color Scheme: Gray and peach theme reflecting the cafe.
- Navigation: Intuitive booking with options based on pax.
- Interactive Elements: Dynamic cart updates and real-time order tracking.

---

## User Authentication System

## ** Authentication Features**
- **Registration System**: Email validation, password confirmation
- **Login System**: Secure authentication with "Remember Me" option.

---

### **Security Measures**
- User registration with email validation
- Secure login with session handling
- Password hashing using Laravel Breeze

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
        - <img width="594" height="266" alt="image" src="https://github.com/user-attachments/assets/11d4d8f7-fba8-46a8-af7b-7e82be57ad3b" />
        - <img width="414" height="239" alt="image" src="https://github.com/user-attachments/assets/f5c6eabc-961a-44ff-a9b2-847efb3f6af3" />

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

- User registration and login system.
- Coffee packages browsing and display.
- Active bookings display.
- Responsive design across devices.

### Browser Compatibility

 - Google Chrome (Latest)
 - Mozilla Firefox (Latest)
 - Safari (Latest) 
 - Microsoft Edge (Latest)

 ### Performance Testing

 - Fast Page Load: Ensured all pages load in under 3 seconds for optimal user experience.
 - Database Optimization: Queries were optimized to reduce load times and improve efficiency.
 - Image Optimization: Compressed images without compromising quality to enhance performance.
 - Responsive Testing: Verified that the system works seamlessly across desktops, tablets, and mobile devices.

---

## Challenges Faced and Solutions

 ### Challenge 1: Ensuring Mobile Responsiveness
 - Problem: Users needed to make reservations easily on phones, tablets, and desktops.
 - Solution: Utilized Bootstrap and responsive design techniques to create a consistent and user-friendly interface across all devices. 
 
 ### Challenge 2: Complex Reservation Management
 - Problem: Handling relationships between reservations, coffee packages, and customer details was complicated, especially for multiple bookings and updates.
 - Solution: Implemented proper Eloquent relationships with pivot tables for many-to-many connections, ensuring accurate tracking of reservations and package selections. 

---

## Future Enhancements

### Phase 2 Features (Potential Improvements)
- Live Notifications: Instant alerts for reservation confirmations, updates, and changes.
- Online Payment Support: Integration with secure payment gateways such as Stripe or PayPal.
- Location-Based Tracking: Map-based tracking for catering delivery and event locations.
- Customer Feedback Module: Ratings and reviews to improve service quality.
- Data Analytics Dashboard: Insights into booking patterns, revenue, and customer behavior.
- Custom Package Builder: Let users create their own coffee catering packages with flexible options.
- Mobile Application: Dedicated iOS and Android apps for convenient access.
- Inventory Alerts: Notify staff of ingredient or stock shortages to prevent overbooking.

### Scalability Considerations
- Database optimization to efficiently handle larger datasets.
- Implementation of caching mechanisms to improve system performance.
- API development to support mobile application integration.
- Load balancing strategies to ensure reliability under high-traffic scenarios.

---

## Learning Outcomes

### Technical Skills Gained
 - Laravel Framework: Applied MVC architecture and Eloquent ORM for structured application development.
 - Database Design: Designed efficient database schemas and managed relational data.
 - Authentication: Implemented secure user authentication and authorization mechanisms.
 - Frontend Development: Built responsive and user-friendly interfaces using Bootstrap.
 - Version Control: Utilized Git and GitHub for effective version control and collaborative project management.

### Soft Skills
 - **Team Collaboration** : Working effectively and cooperatively within a group environment.
 - **Project Management** : Planning, organizing, and executing a complex web application project.
 - **Problem Solving** : Identifying, debugging, and resolving technical challenges.
 - **Documentation** : Producing clear and comprehensive project documentation.

---

## References
- Figma Prototype: Coffee Catering Reservation System
- Easy Eat. (2025). https://easyeat.ai/r/landsnpeople/2

---

## Conclusion
Our coffee reservation system successfully demonstrates the implementation of a comprehensive coffee reservation system using the Laravel framework. The project highlights proficiency in core web development principles, including MVC architecture, database design, user authentication, and responsive web design.

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

 - Project Completion Date: 13/1/2026
 - Course: INFO 3305 Web Application Development

---

## Screenshots
### Home Page
![Home Page](screenshots/screenshot-HomePage.jpeg)

### Packages Page
![Packages Page](screenshots/screenshot-Packages.png)

### Reservation Form
![Reservation Form](screenshots/screenshot-BookingForm.jpeg)

### My Bookings Page
![My Bookings](screenshots/screenshot-Mybookings.png)
