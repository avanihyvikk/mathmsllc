<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess Camp Adventures - Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Additional styles */
        .form-input {
            @apply block w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none;
        }
        .required::after {
            content: "*";
            color: red;
        }
        .mb-8 {
            margin-bottom: 1rem;
        }
        /* Adjust border properties for a better look */
        .form-input {
            border-width: 1px; /* Adjust the border width */
            border-style: solid; /* Set the border style */
            border-color: #ccc; /* Set the border color */
            border-radius: 0.25rem; /* Adjust the border radius */
            padding: 0.5rem; /* Add padding */
        }
		 hr.class-2 {
            border-top: 3px double #8c8b8b;
        }
		hr.class-1 {
            border-top: 10px solid #8c8b8b;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">
<header class="bg-blue-900 text-white p-5 text-center">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold">2024 Summer Chess Camps</h1>
        <p class="mt-2">Master the Game with Paul Chaplin</p>
        <p class="mt-2">Hosted at Cedar Park Mathnasium</p>
    </div>
</header>
<main class="py-10">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Section 1: Camp Selection -->
        <section id="camp-selection" class="mb-10">
            <h2 class="text-3xl font-semibold mb-4">Section 1: Camp Selection</h2>
            <form action="submit.php" method="POST" id="registrationForm">
                <div class="mb-8">
                    <label class="block text-lg font-medium mb-1 camp-selection-label">Select camp(s) you would like to attend<span class="required"></span></label>
                    <div class="flex flex-wrap mb-2">
                        <label class="inline-flex items-center mr-4">
                            <input type="checkbox" name="camps[]" value="Wild Openings"> June 3rd-7th: Wild Openings!
                        </label><div>
						<div class="flex flex-wrap mb-2">
                        <label class="inline-flex items-center mr-4">
                            <input type="checkbox" name="camps[]" value="Check & Mate"> June 17th-21st: Check & Mate!
                        </label><div>
						<div class="flex flex-wrap mb-2">
                        <label class="inline-flex items-center mr-4">
                            <input type="checkbox" name="camps[]" value="Brilliancies & Howlers"> July 8th-12th: Brilliancies & Howlers!
                        </label><div>
						<div class="flex flex-wrap mb-2">
                        <label class="inline-flex items-center mr-4">
                            <input type="checkbox" name="camps[]" value="World Class Chess"> July 22nd-26th: World Class Chess!
                        </label><div>
						<div class="flex flex-wrap mb-2">
                        <label class="inline-flex items-center mr-4">
                            <input type="checkbox" name="camps[]" value="Fantastic Finales"> August 5th-9th: Fantastic Finales!
                        </label><div>
                    </div>
                </div>
				<hr class="class-1" />
                <!-- Section 2: Student Information -->
                <section id="student-info" class="mb-10">
                    <h2 class="text-3xl font-semibold mb-4">Section 2: Student Information</h2>
                    <!-- Default to 1 kid -->
                    <div class="student">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name_1" class="block text-lg font-medium mb-1">First Name<span class="required"></span></label>
                                <input type="text" id="first_name_1" name="first_name_1" class="form-input" placeholder="Enter first name" required>
                            </div>
                            <div>
                                <label for="last_name_1" class="block text-lg font-medium mb-1">Last Name<span class="required"></span></label>
                                <input type="text" id="last_name_1" name="last_name_1" class="form-input" placeholder="Enter last name" required>
                            </div>
                            <div>
                                <label for="age_1" class="block text-lg font-medium mb-1">Age<span class="required"></span></label>
                                <input type="number" id="age_1" name="age_1" class="form-input" placeholder="Enter age" min="1" required>
                            </div>
                            <div>
                                <label for="uscf_rating_1" class="block text-lg font-medium mb-1">USCF Rating</label>
                                <input type="number" id="uscf_rating_1" name="uscf_rating_1" class="form-input" placeholder="Enter USCF rating">
                            </div>
                        </div>
                    </div>
                    <!-- Button to add another kid -->
                    <button type="button" id="addKidBtn" class="mt-4 bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300 ease-in-out">Add Another Kid</button>
                </section>
				<hr class="class-1" />
                <!-- Section 3: Guardian Information -->
                <section id="guardian-info" class="mb-10">
                    <h2 class="text-3xl font-semibold mb-4">Section 3: Guardian Information</h2>
                    <!-- Guardian information fields go here -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="parent_first_name" class="block text-lg font-medium mb-1">Parent/Legal Guardian First Name<span class="required"></span></label>
                            <input type="text" id="parent_first_name" name="parent_first_name" class="form-input" placeholder="First Name" required>
                        </div>
						<div>
                            <label for="parent_last_name" class="block text-lg font-medium mb-1">Parent/Legal Guardian Last Name<span class="required"></span></label>
                            <input type="text" id="parent_last_name" name="parent_last_name" class="form-input" placeholder="Last Name" required>
                        </div>
                        <div>
                            <label for="contact_phone" class="block text-lg font-medium mb-1">Contact Phone Number<span class="required"></span></label>
                            <input type="tel" id="contact_phone" name="contact_phone" class="form-input" placeholder="(xxx) xxx-xxxx" required>
                        </div>
						<div>
                            <label for="email1" class="block text-lg font-medium mb-1">Email Address<span class="required"></span></label>
                            <input type="email" id="email1" name="email1" class="form-input" placeholder="Enter email address" required>
                        </div>
                        <div>
                            <label for="other_parent_first_name" class="block text-lg font-medium mb-1">Other Parent/Guardian First Name</label>
                            <input type="text" id="other_parent_first_name" name="other_parent_first_name" class="form-input" placeholder="First Name">
                        </div>
						<div>
                            <label for="other_parent_last_name" class="block text-lg font-medium mb-1">Other Parent/Guardian Last Name</label>
                            <input type="text" id="other_parent_last_name" name="other_parent_last_name" class="form-input" placeholder="Last Name">
                        </div>
                        <div>
                            <label for="alternate_phone" class="block text-lg font-medium mb-1">Alternate Phone</label>
                            <input type="tel" id="alternate_phone" name="alternate_phone" class="form-input" placeholder="(xxx) xxx-xxxx">
                        </div>
                        <div>
                            <label for="email2" class="block text-lg font-medium mb-1">Alternate Email</label>
                            <input type="email" id="email2" name="email2" class="form-input" placeholder="Enter email address">
                        </div>
                    </div>
                </section>
				<hr class="class-1" />
               <!-- Section 4: Chess Knowledge Questionnaire -->
<section id="chess-knowledge" class="mb-10">
    <h2 class="text-3xl font-semibold mb-4">Section 4: Chess Knowledge Questionnaire</h2>
    <!-- Chess knowledge questionnaire fields go here -->
    <div class="mb-4">
        <label for="general_knowledge" class="block text-lg font-medium mb-1">General chess knowledge</label>
        <select id="general_knowledge" name="general_knowledge" class="form-input">
            <option value="Default" disabled selected>Rate Your Skillset</option>
            <option value="A Little">A Little</option>
            <option value="A Lot">A Lot</option>
            <option value="None">None</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="instruction" class="block text-lg font-medium mb-1">Has received some chess instruction by a coach, mentor, or other trainer?</label>
        <select id="instruction" name="instruction" class="form-input">
            <option value="Default" disabled selected>Rate Your Skillset</option>
            <option value="A Little">A Little</option>
            <option value="A Lot">A Lot</option>
            <option value="None">None</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="etiquette_rules" class="block text-lg font-medium mb-1">Knows something about chess etiquette and competitive rules?</label>
        <select id="etiquette_rules" name="etiquette_rules" class="form-input">
            <option value="Default" disabled selected>Rate Your Skillset</option>
            <option value="A Little">A Little</option>
            <option value="A Lot">A Lot</option>
            <option value="None">None</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="played_tournaments" class="block text-lg font-medium mb-1">Has played in competitive scholastic tournaments?</label>
        <select id="played_tournaments" name="played_tournaments" class="form-input">
            <option value="Default" disabled selected>Rate Your Skillset</option>
            <option value="A Little">A Little</option>
            <option value="A Lot">A Lot</option>
            <option value="None">None</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="special_moves" class="block text-lg font-medium mb-1">Knows the three special moves: castling, en passant, and pawn promotion?</label>
        <select id="special_moves" name="special_moves" class="form-input">
            <option value="Default" disabled selected>Rate Your Skillset</option>
            <option value="A Little">A Little</option>
            <option value="A Lot">A Lot</option>
            <option value="None">None</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="notation" class="block text-lg font-medium mb-1">Reads and writes chess notation?</label>
        <select id="notation" name="notation" class="form-input">
            <option value="Default" disabled selected>Rate Your Skillset</option>
            <option value="A Little">A Little</option>
            <option value="A Lot">A Lot</option>
            <option value="None">None</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="school_chess_club" class="block text-lg font-medium mb-1">Plays at their school chess club?</label>
        <select id="school_chess_club" name="school_chess_club" class="form-input">
            <option value="Default" disabled selected>Rate Your Skillset</option>
            <option value="A Little">A Little</option>
            <option value="A Lot">A Lot</option>
            <option value="None">None</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="plays_with_family" class="block text-lg font-medium mb-1">Plays at home with family member(s)?</label>
        <select id="plays_with_family" name="plays_with_family" class="form-input">
            <option value="Default" disabled selected>Rate Your Skillset</option>
            <option value="A Little">A Little</option>
            <option value="A Lot">A Lot</option>
            <option value="None">None</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="software_books" class="block text-lg font-medium mb-1">Uses software and/or books to improve chess skills?</label>
        <select id="software_books" name="software_books" class="form-input">
            <option value="Default" disabled selected>Rate Your Skillset</option>
            <option value="A Little">A Little</option>
            <option value="A Lot">A Lot</option>
            <option value="None">None</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="online_sites" class="block text-lg font-medium mb-1">Plays at or visits online chess sites?</label>
        <select id="online_sites" name="online_sites" class="form-input">
            <option value="Default" disabled selected>Rate Your Skillset</option>
            <option value="A Little">A Little</option>
            <option value="A Lot">A Lot</option>
            <option value="None">None</option>
        </select>
    </div>
    <!-- Add more questionnaire fields as needed -->
</section>
<hr class="class-1" />
<!-- Section 5: Policies -->
<section id="policies" class="mb-10">
    <h2 class="text-3xl font-semibold mb-4">Section 5: Policies</h2>
<!-- Disciplinary Policy -->
<div class="mb-4">
    <input type="checkbox" id="agree_disciplinary_policy" name="agree_disciplinary_policy" required>
    <label for="agree_disciplinary_policy" class="ml-2 text-lg">
        I have read and agree to the <a href="discipline.html" target="_blank" style="color: red; font-weight: bold;">Disciplinary Policy</a><span class="required"></span>
    </label>
</div>
<!-- Emergency Services Policy -->
<div class="mb-4">
    <input type="checkbox" id="agree_emergency_services_policy" name="agree_emergency_services_policy" required>
    <label for="agree_emergency_services_policy" class="ml-2 text-lg">
       I have read and agree to the  <a href="emergency.html" target="_blank" style="color: red; font-weight: bold;">Emergency Services Policy</a><span class="required"></span>
    </label>
</div>


<!-- Signature and Date Fields -->
<div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="signature" class="block text-lg font-medium mb-1">Signature<span class="required"></span></label>
        <input type="text" id="signature" name="signature" class="form-input" placeholder="Enter your signature" required>
    </div>
    <div>
        <label for="date" class="block text-lg font-medium mb-1">Date<span class="required"></span></label>
        <input type="date" id="date" name="date" class="form-input" required readonly>
    </div>
</div>
</section>

                <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-6 rounded hover:bg-blue-700 transition duration-300 ease-in-out">Submit</button>
            </form>
        </section>
    </div>
</main>
<footer class="bg-blue-900 text-white text-center p-5">
    <div class="max-w-4xl mx-auto">
        <p>Contact us for more info and registration!</p>
    </div>
</footer>
<script>
    // Prefill date field with today's date
    document.getElementById('date').valueAsDate = new Date();
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let numKids = 1;

        // Function to add a kid
        function addKid() {
            numKids++;
            const studentInfoSection = document.getElementById('student-info');
            const studentSection = document.createElement('div');
            studentSection.classList.add('student', 'mb-4');
            studentSection.innerHTML = `
                <br><br><hr class="class-2" /> <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name_${numKids}" class="block text-lg font-medium mb-1">Kid ${numKids} First Name<span class="required"></span></label>
                        <input type="text" id="first_name_${numKids}" name="first_name_${numKids}" class="form-input" placeholder="Enter first name" required>
                    </div>
                    <div>
                        <label for="last_name_${numKids}" class="block text-lg font-medium mb-1">Kid ${numKids} Last Name<span class="required"></span></label>
                        <input type="text" id="last_name_${numKids}" name="last_name_${numKids}" class="form-input" placeholder="Enter last name" required>
                    </div>
                    <div>
                        <label for="age_${numKids}" class="block text-lg font-medium mb-1">Kid ${numKids} Age<span class="required"></span></label>
                        <input type="number" id="age_${numKids}" name="age_${numKids}" class="form-input" placeholder="Enter age" min="1" required>
                    </div>
                    <div>
                        <label for="uscf_rating_${numKids}" class="block text-lg font-medium mb-1">Kid ${numKids} USCF Rating</label>
                        <input type="number" id="uscf_rating_${numKids}" name="uscf_rating_${numKids}" class="form-input" placeholder="Enter USCF rating">
                    </div>
                </div>
                <button type="button" class="mt-2 bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700 transition duration-300 ease-in-out removeKidBtn">Remove Kid</button>
            `;
            studentInfoSection.insertBefore(studentSection, addKidBtn);

            // Show the "Add" button after adding a new kid
            addKidBtn.style.display = 'block';

            // Hide all "Remove Kid" buttons except the last one
            hideRemoveButtons();
        }

        // Function to remove a kid
        function removeKid(btn) {
            const studentSection = btn.parentElement;
            studentSection.remove();
            numKids--;

            // Show the "Add" button after removing a kid
            addKidBtn.style.display = 'block';

            // Hide all "Remove Kid" buttons except the last one
            hideRemoveButtons();
        }

        // Function to hide all "Remove Kid" buttons except the last one
        function hideRemoveButtons() {
            const removeButtons = document.querySelectorAll('.removeKidBtn');
            removeButtons.forEach((button, index) => {
                if (index !== removeButtons.length - 1) {
                    button.style.display = 'none';
                } else {
                    button.style.display = 'block';
                }
            });
        }

        // Add kid button event listener
        const addKidBtn = document.getElementById('addKidBtn');
        addKidBtn.addEventListener('click', function () {
            addKid();
        });

        // Remove kid button event listener
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('removeKidBtn')) {
                removeKid(event.target);
            }
        });
		
        // Function to format phone number as (xxx) xxx-xxxx
        function formatPhoneNumber(inputId) {
            const phoneNumberInput = document.getElementById(inputId);
            const phoneNumber = phoneNumberInput.value.replace(/\D/g, '');
            const formattedPhoneNumber = phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            phoneNumberInput.value = formattedPhoneNumber;
        }

        // Event listener to format contact phone number as user types
        document.getElementById('contact_phone').addEventListener('input', function() {
            formatPhoneNumber('contact_phone');
        });

        // Event listener to format alternate phone number as user types
        document.getElementById('alternate_phone').addEventListener('input', function() {
            formatPhoneNumber('alternate_phone');
        });

        // Function to capitalize the first letter of every word in a string
        function capitalizeEveryWord(string) {
            return string.replace(/\b\w/g, function(char) {
                return char.toUpperCase();
            });
        }

        // Event listener to capitalize the first letter of every word in First Name field
        document.getElementById('first_name_1').addEventListener('input', function() {
            this.value = capitalizeEveryWord(this.value);
        });

        // Event listener to capitalize the first letter of every word in Last Name field
        document.getElementById('last_name_1').addEventListener('input', function() {
            this.value = capitalizeEveryWord(this.value);
        });

        // Event listener to capitalize the first letter of every word in Parent/Legal Guardian First Name field
        document.getElementById('parent_first_name').addEventListener('input', function() {
            this.value = capitalizeEveryWord(this.value);
        });

        // Event listener to capitalize the first letter of every word in Parent/Legal Guardian Last Name field
        document.getElementById('parent_last_name').addEventListener('input', function() {
            this.value = capitalizeEveryWord(this.value);
        });

        // Event listener to capitalize the first letter of every word in Other Parent/Guardian First Name field
        document.getElementById('other_parent_first_name').addEventListener('input', function() {
            this.value = capitalizeEveryWord(this.value);
        });

        // Event listener to capitalize the first letter of every word in Other Parent/Guardian Last Name field
        document.getElementById('other_parent_last_name').addEventListener('input', function() {
            this.value = capitalizeEveryWord(this.value);
        });

        // Form Validation
        const form = document.getElementById('registrationForm');
        form.addEventListener('submit', function (event) {
            // Check if at least one camp is selected
            const selectedCamps = document.querySelectorAll('input[name="camps[]"]:checked');
            if (selectedCamps.length < 1) {
                event.preventDefault(); // Prevent form submission
                alert('Please select at least one camp.'); // Display an alert or any other validation message
                return;
            }

            // Your existing form validation logic
        });
    });
</script>


</body>
</html>
