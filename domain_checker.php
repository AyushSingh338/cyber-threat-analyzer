<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Domain Checker | Cyber Threat Analyzer</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #0e1117;
      color: #e4e6eb;
      margin: 0;
      padding: 0;
    }

    header {
      background: linear-gradient(to right, rgba(20, 30, 48, 0.85), rgba(36, 59, 85, 0.85)),
                  url('https://images.unsplash.com/photo-1581093588401-22f69bcd2c52?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80') center/cover no-repeat;
      padding: 4rem 2rem;
      text-align: center;
    }

    header h1 {
      font-size: 2.8rem;
      margin-bottom: 0.5rem;
    }

    header p {
      font-size: 1.2rem;
      color: #ccc;
    }

    .container {
      max-width: 800px;
      margin: 2rem auto;
      padding: 2rem;
      background-color: #161b22;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    input[type="text"] {
      padding: 0.75rem;
      border-radius: 6px;
      border: 1px solid #444;
      background: #0e1117;
      color: #fff;
      font-size: 1rem;
    }

    button {
      padding: 0.8rem;
      background-color: #f9826c;
      border: none;
      border-radius: 6px;
      color: white;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #e76a5a;
    }

    .result {
      margin-top: 2rem;
      background-color: #0e1117;
      padding: 1rem 1.5rem;
      border-radius: 10px;
      border: 1px solid #30363d;
    }

    .result h2 {
      color: #58a6ff;
      margin-bottom: 1rem;
    }

    .result p {
      margin: 0.3rem 0;
      line-height: 1.4;
    }

    footer {
      text-align: center;
      color: #888;
      font-size: 0.9rem;
      padding: 2rem 1rem;
    }
  </style>
</head>
<body>

  <header>
    <h1>Domain Checker</h1>
    <p>Find out if a domain is safe, trustworthy, and technically sound.</p>
  </header>

  <div class="container">
    <form method="POST">
      <label for="domain">Enter Domain Name:</label>
      <input type="text" name="domain" id="domain" placeholder="example.com" required>
      <button type="submit">Check Domain</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["domain"])) {
        $domain = trim($_POST["domain"]);
        $apiKey = "caO1WQg7TMfHSdTymwM7Gr3Os830ErjR";
        $url = "https://ipqualityscore.com/api/json/url/$apiKey/$domain";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data && $data["success"] === true) {
            echo "<div class='result'>";
            echo "<h2>Analysis Result for: " . htmlspecialchars($domain) . "</h2>";
            echo "<p><strong>Domain Age:</strong> " . $data['domain_age']['human'] . "</p>";
            echo "<p><strong>Risk Score:</strong> " . $data['risk_score'] . "</p>";
            echo "<p><strong>Trusted:</strong> " . $data['domain_trust'] . "</p>";
            echo "<p><strong>Phishing:</strong> " . ($data['phishing'] ? 'Yes' : 'No') . "</p>";
            echo "<p><strong>Malware:</strong> " . ($data['malware'] ? 'Yes' : 'No') . "</p>";
            echo "<p><strong>Adult Content:</strong> " . ($data['adult'] ? 'Yes' : 'No') . "</p>";
            echo "<p><strong>Category:</strong> " . $data['category'] . "</p>";
            echo "<p><strong>Server:</strong> " . $data['server'] . "</p>";
            echo "<p><strong>IP Address:</strong> " . $data['ip_address'] . "</p>";
            echo "<p><strong>Country:</strong> " . $data['country_code'] . "</p>";
            echo "</div>";
        } else {
            echo "<div class='result'><p>❌ Could not analyze the domain. Please try again.</p></div>";
        }
    }
    ?>
  </div>

  <footer>
    &copy; 2025 Cyber Threat Analyzer | Built with 🛡 by your cybersecurity team.
  </footer>

</body>
</html>
