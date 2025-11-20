<div class="popup-form" id="joinusPopup">
  <div class="popup-content">
    <button type="button" class="close-btn" id="closeJoinUs">&times;</button>
    <h2>Join the Debate Club</h2>
    <form action="join_us_submit.php" method="POST" enctype="multipart/form-data">
      
      <label for="name">Full Name:</label>
      <input type="text" name="name" id="name" required>

      <label for="uni_id">University ID:</label>
      <input type="text" name="uni_id" id="uni_id" required>

      <label for="department">Department:</label>
      <select name="department" id="department" required>
        <option value="">Select Department</option>
        <option value="CSE">CSE</option>
        <option value="EEE">EEE</option>
        <option value="Civil">Civil</option>
        <option value="BBA">BBA</option>
        <option value="English">English</option>
        <option value="Law">Law</option>
      </select>

      <label for="semester">Semester:</label>
      <select name="semester" id="semester" required>
        <option value="">Select Semester</option>
        <option value="1st">1st</option>
        <option value="2nd">2nd</option>
        <option value="3rd">3rd</option>
        <option value="4th">4th</option>
        <option value="5th">5th</option>
        <option value="6th">6th</option>
        <option value="7th">7th</option>
        <option value="8th">8th</option>
      </select>

      <label for="photo">Upload Photo:</label>
      <input type="file" name="photo" id="photo" accept="image/*" required>

      <button type="submit" class="submit-btn">Submit Registration</button>
    </form>
  </div>
</div>
