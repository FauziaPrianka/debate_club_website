<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Voting Results | Debate Club</title>

  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: #f7fdf9;
      margin: 0;
      padding: 0;
    }

    .results-section {
      max-width: 700px;
      margin: 3rem auto;
      padding: 2rem;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    h2 {
      text-align: center;
      color: #1b5e20;
      margin-bottom: 1rem;
    }

    p.lead {
      text-align: center;
      color: #555;
      margin-bottom: 2rem;
    }

    .result-item {
      margin-bottom: 1.5rem;
    }

    .result-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.4rem;
      font-weight: 600;
    }

    .progress-bar {
      width: 100%;
      height: 14px;
      background: #e0e0e0;
      border-radius: 8px;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      border-radius: 8px;
      width: 0;
      transition: width 1.2s ease;
    }
  </style>
</head>

<body>
  <div class="results-section">
    <h2>🗳️ Live Voting Results</h2>
    <p class="lead">Track votes for each debate topic in real-time</p>

    <div id="resultsContainer">Loading results...</div>
  </div>

 <script>
async function loadResults() {
  try {
const res = await fetch('http://localhost/debate_club/get_vote_result.php');
    if (!res.ok) throw new Error('Response not OK');
    const data = await res.json();

    const container = document.getElementById('resultsContainer');
    container.innerHTML = '';

    if (!data || data.length === 0) {
      container.innerHTML = '<p>No topics found.</p>';
      return;
    }

    const totalVotes = data.reduce((sum, r) => sum + parseInt(r.votes || 0), 0);
    const colors = ['#4CAF50', '#2196F3', '#FF9800', '#9C27B0', '#E91E63', '#00BCD4'];

    data.forEach((row, i) => {
      const percentage = totalVotes > 0 ? ((row.votes / totalVotes) * 100).toFixed(1) : 0;
      const color = colors[i % colors.length];

      const div = document.createElement('div');
      div.classList.add('result-item');
      div.innerHTML = `
        <div class="result-header">
          <span>${row.topic_title}</span>
          <span>${percentage}% (${row.votes} votes)</span>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" style="background:${color};" data-width="${percentage}%"></div>
        </div>
      `;
      container.appendChild(div);
    });

    // animate bars
    setTimeout(() => {
      document.querySelectorAll('.progress-fill').forEach(bar => {
        bar.style.width = bar.getAttribute('data-width');
      });
    }, 200);
  } catch (err) {
    console.error(err);
    document.getElementById('resultsContainer').innerHTML = '<p style="color:red;">Error loading results.</p>';
  }
}

loadResults();
setInterval(loadResults, 5000);
</script>

</body>
</html>
