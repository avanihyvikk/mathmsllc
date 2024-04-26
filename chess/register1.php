<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chess Camp Registration</title>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f4f7f6;
    color: #333;
  }
  .container {
    max-width: 600px;
    margin: auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  .section {
    display: none;
  }
  .active {
    display: block;
  }
  h2, h3 {
    font-family: 'Merriweather', serif;
    color: #204056;
    text-align: center;
  }
  .btn, input[type="submit"] {
    background-color: #1E90FF; /* Darker blue */
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    margin-top: 20px;
  }
  .btn:hover, input[type="submit"]:hover {
    background-color: #4169E1; /* Even darker blue on hover */
  }
  .btn-section {
    text-align: center;
  }
  .step-number {
    background-color: #4CAF50;
    color: white;
    width: 30px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    border-radius: 50%;
    display: inline-block;
    margin-bottom: 10px;
  }
  input[type="text"],
  input[type="tel"],
  input[type="email"],
  input[type="number"],
  input[type="date"],
  select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
  }
  input[type="text"]:focus,
  input[type="tel"]:focus,
  input[type="email"]:focus,
  input[type="number"]:focus,
  input[type="date"]:focus,
  select:focus {
    outline: none;
    border-color: #007bff;
  }
  
  
  input:valid {
    border-color: #ced4da;
  }
  /* Add this CSS */
input.error,
select.error {
    border-color: red;
}
</style>
</head>
<body>
<div class="container">
  <form id="registrationForm" onsubmit="return validateForm()">
    <!-- Section 1: Camp Selection -->
    <div class="section active" id="section1">
      <h2>Chess Camp Registration</h2>
      <h3>Step 1: Camp Selection</h3>
      <hr>
      <center><b><p>Select each camp(s) you would like to attend</p></b></center>
      <div class="camp-selection" id="campSelectionContainer">
        <input type="checkbox" id="wildOpenings" name="campSelection[]" value="June 3rd-7th: Wild Openings!" required>
        <label for="wildOpenings">June 3rd-7th: Wild Openings!</label><br>

        <input type="checkbox" id="checkMate" name="campSelection[]" value="June 17th-21st: Check & Mate!" required>
        <label for="checkMate">June 17th-21st: Check & Mate!</label><br>

        <input type="checkbox" id="brillianciesHowlers" name="campSelection[]" value="July 8th-12th: Brilliancies & Howlers!" required>
        <label for="brillianciesHowlers">July 8th-12th: Brilliancies & Howlers!</label><br>

        <input type="checkbox" id="worldClassChess" name="campSelection[]" value="July 22nd-26th: World Class Chess!" required>
        <label for="worldClassChess">July 22nd-26th: World Class Chess!</label><br>

        <input type="checkbox" id="fantasticFinales" name="campSelection[]" value="August 5th-9th: Fantastic Finales!" required>
        <label for="fantasticFinales">August 5th-9th: Fantastic Finales!</label><br>
      </div>
      <br>
      <hr>
      <label for="numberOfKids">How many kids do you want to register?</label>
      <select id="numberOfKids" name="numberOfKids" onchange="showKidsQuestions(this.value)" required>
        <option value="" selected>Select number of kids...</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>

      <div class="btn-section">
        <button type="button" class="btn" onclick="showNext(2)">Next</button>
      </div>
    </div>
    
    <!-- Section 2: Personal Information for Each Kid -->
    <div class="section" id="section2">
      <h3>Step 2: Personal Information</h3>
      <div id="kidsQuestions">
        <!-- Questions for each kid will be displayed dynamically here -->
      </div>
      <div class="btn-section">
        <button type="button" class="btn" onclick="showPrevious(1)">Previous</button>
        <button type="button" class="btn" onclick="showNext(3)">Next</button>
      </div>
    </div>
    
    <!-- Section 3: Contact Information -->
    <div class="section" id="section3">
      <h3>Step 3: Contact Information</h3>
      <label for="parentName">Parent/Legal Guardian Name:<span class="required">*</span></label>
<input type="text" id="parentName" name="parentName" required>
<span id="parentNameError" style="color: red; display: none;">Please enter a valid name</span>
	 
      <br><br>
      <label for="phone">Home or Work Phone:<span class="required">*</span></label>
<input type="tel" id="phone" name="phone" required>
<span id="phoneError" style="color: red; display: none;">Please enter a 10-digit phone number</span>
      <br><br>
      <label for="otherParentName">Other Parent/Guardian Name:</label>
      <input type="text" id="otherParentName" name="otherParentName">
      <br><br>
      <label for="alternatePhone">Alternate Phone:</label>
      <input type="tel" id="alternatePhone" name="alternatePhone">
      <br><br>
     <label for="email1">Email #1:<span class="required">*</span></label>
<input type="email" id="email1" name="email1" required>
<span id="emailError" style="color: red; display: none;">Please enter a valid email address</span>
      <br><br>
      <label for="email2">Email #2:</label>
      <input type="email" id="email2" name="email2">
      <div class="btn-section">
        <button type="button" class="btn" onclick="showPrevious(2)">Previous</button>
        <button type="button" class="btn" onclick="showNext(4)">Next</button>
      </div>
    </div>

  <!-- Section 4: Chess Knowledge Questionnaire -->
<div class="section" id="section4">
  <h3>Step 4: Chess Knowledge Questionnaire</h3>

  <label for="generalKnowledge">General chess knowledge:<span class="required">*</span></label>
  <select id="generalKnowledge" name="generalKnowledge" required>
    <option value="" disabled selected>Rate your Skillset</option>
    <option value="a_lot">A lot</option>
    <option value="a_little">A little</option>
    <option value="none">None</option>
  </select>
  <br><br>
  <label for="receivedInstruction">Has received some chess instruction by a coach, mentor, or other trainer?<span class="required">*</span></label>
  <select id="receivedInstruction" name="receivedInstruction" required>
    <option value="" disabled selected>Rate your Skillset</option>
    <option value="a_lot">A lot</option>
    <option value="a_little">A little</option>
    <option value="none">None</option>
  </select>
  <br><br>
  <label for="chessEtiquette">Knows something about chess etiquette and competitive rules?<span class="required">*</span></label>
  <select id="chessEtiquette" name="chessEtiquette" required>
    <option value="" disabled selected>Rate your Skillset</option>
    <option value="a_lot">A lot</option>
    <option value="a_little">A little</option>
    <option value="none">None</option>
  </select>
  <br><br>
  <label for="scholasticTournaments">Has played in competitive scholastic tournaments?<span class="required">*</span></label>
  <select id="scholasticTournaments" name="scholasticTournaments" required>
    <option value="" disabled selected>Rate your Skillset</option>
    <option value="a_lot">A lot</option>
    <option value="a_little">A little</option>
    <option value="none">None</option>
  </select>
  <br><br>
  <label for="specialMoves">Knows the three special moves: castling, en passant, and pawn promotion?<span class="required">*</span></label>
  <select id="specialMoves" name="specialMoves" required>
    <option value="" disabled selected>Rate your Skillset</option>
    <option value="a_lot">A lot</option>
    <option value="a_little">A little</option>
    <option value="none">None</option>
  </select>
  <br><br>
  <label for="chessNotation">Reads and writes chess notation?<span class="required">*</span></label>
  <select id="chessNotation" name="chessNotation" required>
    <option value="" disabled selected>Rate your Skillset</option>
    <option value="a_lot">A lot</option>
    <option value="a_little">A little</option>
    <option value="none">None</option>
  </select>
  <br><br>
  <label for="schoolChessClub">Plays at their school chess club?<span class="required">*</span></label>
  <select id="schoolChessClub" name="schoolChessClub" required>
    <option value="" disabled selected>Rate your Skillset</option>
    <option value="a_lot">A lot</option>
    <option value="a_little">A little</option>
    <option value="none">None</option>
  </select>
  <br><br>
  <label for="homeChess">Plays at home with family member(s)?<span class="required">*</span></label>
  <select id="homeChess" name="homeChess" required>
    <option value="" disabled selected>Rate your Skillset</option>
    <option value="a_lot">A lot</option>
    <option value="a_little">A little</option>
    <option value="none">None</option>
  </select>
  <br><br>
  <label for="chessResources">Uses software and/or books to improve chess skills?<span class="required">*</span></label>
  <select id="chessResources" name="chessResources" required>
    <option value="" disabled selected>Rate your Skillset</option>
    <option value="a_lot">A lot</option>
    <option value="a_little">A little</option>
    <option value="none">None</option>
  </select>
  <br><br>
  <label for="onlineChess">Plays at or visits online chess sites?<span class="required">*</span></label>
  <select id="onlineChess" name="onlineChess" required>
    <option value="" disabled selected>Rate your Skillset</option>
    <option value="a_lot">A lot</option>
    <option value="a_little">A little</option>
    <option value="none">None</option>
  </select>
  <br><br>
  <!-- Add other questionnaire items here -->

      <div class="btn-section">
        <button type="button" class="btn" onclick="showPrevious(3)">Previous</button>
        <button type="button" class="btn" onclick="showNext(5)">Next</button>
      </div>
    </div>

    <!-- Section 5: Rules Agreement / Emergency Services & Consent Forms -->
    <div class="section" id="section5">
      <div class="rules-agreement">
        <h3>Step 5: Rules Agreement / Emergency Services & Consent Forms</h3>
        <!-- Add rules agreement content here -->
<p><b>Disciplinary Policy:</b></p>
        <p>The primary goal of the camp is to provide chess instruction and competitive experiences to all the participants. If one or more participants interfere significantly with this process, then it is deemed as detrimental to the group as a whole and will not be tolerated. We have developed a number of skills to guide occasional and insignificant offenders back into the process, but we are not equipped, nor required by circumstances, to deal with continued and repeated disruptions, and certainly not any involving bodily injury to anyone present, or physical damage to the premises or any of its contents.</p>
        <p>Parents should be aware that these chess camps are not suitable for all children. These chess camps are not suitable at all for horsing around or making noise. For this reason, we do not accept children under the age of 7 unless they are highly recommended by one of the local chess teachers for being serious and focused chess students. Special note for beginners: registrants who have no tournament experience should understand all the basic move rules. It is also suggested they be able to read and speak algebraic chess notation. Students should expect a “total immersion” chess experience and to gain knowledge with respect to their abilities and maturity. Knowing this, the parent(s) or legal guardian(s) responsible for registering the participant should consider whether or not the basic camp regimen, including but not limited to group study, exercise, discussion and competition, fits the minor’s personality and expectations.</p>
        <p>I, the undersigned parent or legal guardian of the subject minor, agree to allow Cedar Park Mathnasium staff, chess camp instructors, and volunteers, to use appropriate disciplinary measures in dealing with said minor.</p>
        <ol>
          <li>First offense – a behavioral warning will be issued to the minor.</li>
          <li>Second offense – direct discussion with the undersigned parent/guardian (and/or other provided contact).</li>
          <li>Third offense – dismissal of the minor from the camp, to be facilitated by the prompt removal of the minor from the premises by the undersigned.</li>
          <li>ANY significant acts of physical or emotional aggression to others, or acts causing property damage, may result in the participant’s immediate dismissal and prompt removal by the undersigned.</li>
        </ol>
        <p><b>Emergency Services:</b></p>
        <p>I, the undersigned parent or legal guardian of the registrant minor, agree to allow Mathnasium staff, chess camp instructors, and volunteers, to take what actions are deemed appropriate in emergency situations involving said minor, including the alerting of Emergency Medical Services (EMS). I also accept full financial responsibility for any and all charges for emergency services and for subsequent and consequent care.</p>
        <p>I do hereby agree to release, discharge, and hold harmless Mathnasium, the camp staff, instructors, and volunteers of and from all liabilities, damages, claims, or demands whatsoever on account of any injury or accident involving the said minor arising out of the minor's attendance of the chess camp at Mathnasium or in the course of activities held during the camp. I have read, understand and fully accept the policies set forth by Mathnasium.</p>
         <hr>
		 <div>
        <input type="checkbox" id="rulesAgreement" required>
        <label for="rulesAgreement"><b>I have read and agree to the Rules Agreement and Emergency Services & Consent Forms</b></label>
      </div>
      <br>
      <label for="parentNameSignature">Parent/Legal Guardian Signature:<span class="required">*</span></label>
      <input type="text" id="parentNameSignature" name="parentNameSignature" required>
      
      <label for="date">Date:<span class="required">*</span></label>
      <input type="date" id="date" name="date" required>
      <br><br>
        <div class="btn-section">
          <button type="button" class="btn" onclick="showPrevious(4)">Previous</button>
          <input type="submit" value="Register" class="btn">
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  // Add this function to trigger the form display on page load
  window.onload = function() {
    showKidsQuestions(document.getElementById('numberOfKids').value);
  };

  function showNext(nextSectionId) {
    // Validate current section before moving to the next
    var currentSectionId = nextSectionId - 1;
    if (!validateSection(currentSectionId)) {
        return;
    }

    document.querySelector('.active').classList.remove('active');
    document.getElementById('section' + nextSectionId).classList.add('active');
  }
  
  function showPrevious(prevSectionId) {
    document.querySelector('.active').classList.remove('active');
    document.getElementById('section' + prevSectionId).classList.add('active');
  }

  // Function to validate each section before moving to the next
  function validateSection(sectionId) {
      var section = document.getElementById('section' + sectionId);
      var inputs = section.querySelectorAll('input[required], select[required]');
      var unfilledFields = []; // Array to store unfilled field names
      var isValid = true;

      for (var i = 0; i < inputs.length; i++) {
          if (!inputs[i].value) {
              unfilledFields.push(inputs[i].name);
              isValid = false;
              // Add class to highlight the field with error
              inputs[i].classList.add('error');
          } else {
              // Remove class if field is filled
              inputs[i].classList.remove('error');
          }
      }

      return isValid;
  }
  
  
  // Function to validate email format
  function validateEmail(email) {
    // Regular expression for email format
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
  }

  // Function to handle input change event
  document.getElementById('email1').addEventListener('input', function() {
    var emailInput = document.getElementById('email1');
    var emailError = document.getElementById('emailError');

    // Validate email format
    if (!validateEmail(emailInput.value)) {
      emailError.style.display = 'inline';
    } else {
      emailError.style.display = 'none';
    }
  });

  // Function to handle input focus event for email error box
  document.getElementById('email1').addEventListener('focus', function() {
    removeErrorBorder('emailError');
  });

  // Function to validate phone number format
  function validatePhoneNumber(phone) {
    // Regular expression for 10-digit phone number format
    var re = /^\d{10}$/;
    return re.test(phone);
  }

  // Function to handle input change event
  document.getElementById('phone').addEventListener('input', function() {
    var phoneInput = document.getElementById('phone');
    var phoneError = document.getElementById('phoneError');

    // Validate phone number format
    if (!validatePhoneNumber(phoneInput.value)) {
      phoneError.style.display = 'inline';
    } else {
      phoneError.style.display = 'none';
    }
  });

  // Function to handle input focus event for phone number error box
  document.getElementById('phone').addEventListener('focus', function() {
    removeErrorBorder('phoneError');
  });

  // Function to validate parent name format
  function validateParentName(name) {
    /// Regular expression for alphabetic characters and spaces
    var re = /^[A-Za-z\s]+$/;
    return re.test(name);
  }

  // Function to handle input change event
  document.getElementById('parentName').addEventListener('input', function() {
    var parentNameInput = document.getElementById('parentName');
    var parentNameError = document.getElementById('parentNameError');

    // Validate parent name format
    if (!validateParentName(parentNameInput.value)) {
      parentNameError.style.display = 'inline';
    } else {
      parentNameError.style.display = 'none';
    }
  });

  // Function to handle input focus event for parent name error box
  document.getElementById('parentName').addEventListener('focus', function() {
    removeErrorBorder('parentNameError');
  });

  // Function to validate text format
  function validateText(text) {
    // Regular expression for alphabetic characters and spaces
    var re = /^[A-Za-z\s]+$/;
    return re.test(text);
  }

  // Function to handle input change event for first name
  document.getElementById('kid${kidNumber}FirstName').addEventListener('input', function() {
    var inputField = document.getElementById('kid${kidNumber}FirstName');
    var errorSpan = document.getElementById('kid${kidNumber}FirstNameError');

    // Validate text format
    if (!validateText(inputField.value)) {
      errorSpan.style.display = 'inline';
    } else {
      errorSpan.style.display = 'none';
    }
  });

  // Function to handle input focus event for first name error box
  document.getElementById('kid${kidNumber}FirstName').addEventListener('focus', function() {
    removeErrorBorder('kid${kidNumber}FirstNameError');
  });

  // Function to handle input change event for last name
  document.getElementById('kid${kidNumber}LastName').addEventListener('input', function() {
    var inputField = document.getElementById('kid${kidNumber}LastName');
    var errorSpan = document.getElementById('kid${kidNumber}LastNameError');

    // Validate text format
    if (!validateText(inputField.value)) {
      errorSpan.style.display = 'inline';
    } else {
      errorSpan.style.display = 'none';
    }
  });

  // Function to handle input focus event for last name error box
  document.getElementById('kid${kidNumber}LastName').addEventListener('focus', function() {
    removeErrorBorder('kid${kidNumber}LastNameError');
  });

  // Function to handle input focus event for error boxes
  function removeErrorBorder(errorId) {
    var errorSpan = document.getElementById(errorId);
    errorSpan.style.display = 'none';
  }
  
  function validateForm() {
    var campSelections = document.querySelectorAll('input[name="campSelection[]"]:checked');
    if (campSelections.length === 0) {
        alert('Please select at least one camp.');
        return false;
    }
    return true;
}

// Function to dynamically show questions for each kid based on selected number of kids
function showKidsQuestions(numKids) {
    var kidsQuestionsDiv = document.getElementById('kidsQuestions');
    kidsQuestionsDiv.innerHTML = ''; // Clear previous questions

    for (var i = 0; i < numKids; i++) {
        var kidNumber = i + 1;
        var kidQuestions = `
            <h4>Kid ${kidNumber} Information</h4>
<label for="kid${kidNumber}FirstName">First Name:<span class="required">*</span></label>
<input type="text" id="kid${kidNumber}FirstName" name="kid${kidNumber}FirstName" required>
<span id="kid${kidNumber}FirstNameError" style="color: red; display: none;">Please enter text only</span>
<br><br>

<label for="kid${kidNumber}LastName">Last Name:<span class="required">*</span></label>
<input type="text" id="kid${kidNumber}LastName" name="kid${kidNumber}LastName" required>
<span id="kid${kidNumber}LastNameError" style="color: red; display: none;">Please enter text only</span>
<br><br>
<label for="kid${kidNumber}Age">Age:<span class="required">*</span></label>
<input type="number" id="kid${kidNumber}Age" name="kid${kidNumber}Age" min="6" required>
<br><br>
<label for="kid${kidNumber}USCFRating">USCF Rating:</label>
<input type="number" id="kid${kidNumber}USCFRating" name="kid${kidNumber}USCFRating">
<br><br>`;
        kidsQuestionsDiv.innerHTML += kidQuestions;
    }
}

 
</script>


</body>
</html>
