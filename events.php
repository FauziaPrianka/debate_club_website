<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Events | CCN-UST Debate Club</title>

  <!-- CSS -->
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="css/event_popup.css" />
  <link rel="stylesheet" href="css/vote_result.css" />
  <link rel="stylesheet" href="fontawesome/css/all.min.css" />
</head>

<body>
  <!-- Header -->
  <header class="site-header">
    <div class="container header-inner">
      <a href="index.html" class="logo">
        <img src="assets/images/logo.jpg" alt="Debate Club Logo" />
        <span class="club-name">CCN-UST Debate Club</span>
      </a>

      <nav class="nav">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="events.php" class="active">Events</a></li>
          <li><a href="achievements.html">Achievements</a></li>
          <li><a href="members.html">Members</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- ✅ REPLACED: Events Section (copied from index.html) -->
  <section id="events" class="section index-events">
    <div class="container">
      <h2>Upcoming Events</h2>
      <div id="indexEventsContainer" class="index-events-list">
        <!-- Latest 3 events will load here -->
      </div>
    </div>
  </section>

  <!-- 🎟️ Event Registration Section (kept same) -->
  <section id="unique-event-registration" class="event-register-section">
    <div class="event-register-container">
      <?php if (isset($_GET['registered'])): ?>
        <p class="event-register-success">
          ✅ Registration successful!
        </p>
      <?php endif; ?>

      <div id="event-register-form-container">
        <!-- Event registration form will load dynamically here -->
      </div>
    </div>
  </section>

  <!-- 🗳️ Voting Section -->
  <section class="voting-section container">
    <h2>🗳️ Vote for This Week’s Debate Topic</h2>
    <p>Choose one topic you want for the next debate session.</p>

    <div class="vote-box">
      <form id="voteForm" method="POST">
        <?php
        $topics = $conn->query("SELECT * FROM votes_topics");
        while ($topic = $topics->fetch_assoc()) {
          echo '<label>
                  <input type="radio" name="topic_id" value="' . $topic['id'] . '">
                  ' . htmlspecialchars($topic['topic_title']) . '
                </label><br>';
        }
        ?>
        <input type="text" name="member_id" placeholder="Enter your Member ID" required>
        <button type="submit" class="vote-btn">Submit Vote</button>
      </form>
    </div>

    <div class="vote-results" id="voteResults">
      <!-- Live colorful results will appear here -->
    </div>
  </section>

  <!-- Footer -->
  <footer id="contact" class="site-footer">
    <div class="container footer-inner">
      <div class="footer-brand">
        <img src="assets/images/footer.jpg" alt="University Logo" />
        <h3>CCN-UST Debate Club</h3>
      </div>

      <div class="footer-contact">
        <h4>Contact Us</h4>
        <p>Email: <a href="mailto:debate@university.edu">debate@university.edu</a></p>
        <p>Follow: <a href="https://www.facebook.com/groups/1166546140147253">Facebook</a> · <a href="https://ccnust.ac.bd/">website</a></p>
      </div>

      <div class="footer-note">
        <p>© <span id="year"></span>ByteForce Team. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Script -->
<script>
  const yearSpan = document.getElementById('year');
yearSpan.textContent = new Date().getFullYear();
</script>

  <!-- ✅ Auto-load latest 3 events dynamically -->
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const eventsContainer = document.getElementById("indexEventsContainer");

    fetch("get_events.php?limit=3")
      .then(response => response.json())
      .then(data => {
        eventsContainer.innerHTML = "";
        if (data.length === 0) {
          eventsContainer.innerHTML = "<p>No upcoming events available.</p>";
          return;
        }

        data.forEach(event => {
          const card = document.createElement("div");
          card.classList.add("index-event");
          card.innerHTML = `
            <h3>${event.title}</h3>
            <div class="meta">📅 ${event.event_date} | 📍 ${event.venue}</div>
            <p>${event.description}</p>
            <button class="btn primary register-btn" data-event="${event.title}">Register</button>
          `;
          eventsContainer.appendChild(card);
        });
      })
      .catch(error => {
        eventsContainer.innerHTML = `<p style="color:red;text-align:center;">⚠️ Failed to load events.</p>`;
        console.error("Error loading events:", error);
      });
  });
  </script>

  <!-- ✅ Popup Loader for Event Registration -->
  <script>
  let popupLoaded = false;

  function loadEventPopup(callback) {
    if (popupLoaded) {
      callback();
      return;
    }

    fetch("event_registration.php")
      .then(res => res.text())
      .then(html => {
        document.body.insertAdjacentHTML("beforeend", html);
        popupLoaded = true;
        callback();
      })
      .catch(err => console.error("Popup load failed:", err));
  }

  document.addEventListener("click", e => {
    if (e.target.classList.contains("register-btn")) {
      e.preventDefault();
      const eventName = e.target.dataset.event;

      loadEventPopup(() => {
        const popup = document.getElementById("eventPopup");
        const eventInput = popup.querySelector('input[name="event_name"]');
        eventInput.value = eventName;

        popup.style.display = "flex";

        popup.querySelector(".close-btn").onclick = () => (popup.style.display = "none");
        window.onclick = (ev) => {
          if (ev.target === popup) popup.style.display = "none";
        };
      });
    }
  });
  </script>

  <!-- ✅ Voting System -->
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const voteForm = document.getElementById("voteForm");
    const voteResults = document.getElementById("voteResults");

    voteForm.addEventListener("submit", e => {
      e.preventDefault();
      const formData = new FormData(voteForm);

      fetch("submit_vote.php", { method: "POST", body: formData })
        .then(res => res.text())
        .then(data => {
          if (data === "success") {
            alert("✅ Vote submitted successfully!");
            loadResults();
          } else if (data === "already") {
            alert("⚠️ You have already voted!");
          } else if (data === "invalid") {
            alert("❌ Invalid Member ID!");
          } else {
            alert("❌ Error submitting vote!");
          }
        });
    });

    function loadResults() {
      fetch("get_vote_results.php")
        .then(res => res.json())
        .then(data => {
          let totalVotes = data.reduce((sum, item) => sum + parseInt(item.votes), 0);
          let output = "<h3>📊 Live Results</h3>";

          data.forEach(item => {
            let percent = totalVotes > 0 ? ((item.votes / totalVotes) * 100).toFixed(1) : 0;
            output += `
              <div class="result-row">
                <span class="topic">${item.topic_title}</span>
                <div class="progress-bar"><div class="fill" style="width:${percent}%"></div></div>
                <span class="percent">${percent}% (${item.votes} votes)</span>
              </div>`;
          });

          voteResults.innerHTML = output;
        });
    }

    loadResults();
    setInterval(loadResults, 10000);
  });
  </script>

  <script>
  window.addEventListener("scroll", function () {
    const header = document.querySelector(".site-header");
    if (window.scrollY > 50) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }
  });
  </script>

  <script>
document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const eventName = urlParams.get("register");

  if (eventName) {
    fetch("event_registration.php")
      .then(res => res.text())
      .then(html => {
        document.body.insertAdjacentHTML("beforeend", html);
        const popup = document.getElementById("eventPopup");

        // Fill event name
        const eventInput = popup.querySelector('input[name="event_name"]');
        if (eventInput) eventInput.value = eventName;

        // Show popup
        popup.style.display = "flex";

        // Close popup
        popup.querySelector(".close-btn").onclick = () => popup.style.display = "none";
        window.onclick = e => {
          if (e.target === popup) popup.style.display = "none";
        };
      })
      .catch(err => console.error("Popup load failed:", err));
  }
});
</script>
  

<script>
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has("register")) {
  const popup = document.getElementById("registrationPopup");
  popup.style.display = "block";
  document.body.style.overflow = "hidden";

  // Fill event name automatically
  const eventField = document.getElementById("event-name-field");
  if (eventField) {
    eventField.value = urlParams.get("register");
  }
}
</script>


</body>
</html>
