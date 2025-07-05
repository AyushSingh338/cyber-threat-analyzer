<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>URL Scanner - Cyber Threat Analyzer</title>
  <style>
    body {
      background-color: #0e1117;
      color: #e4e6eb;
      font-family: 'Arial', sans-serif;
      text-align: center;
      padding: 2rem;
    }

    h1 {
      color: #58a6ff;
    }

    form {
      margin: 2rem auto;
    }

    input[type="text"] {
      width: 300px;
      padding: 0.7rem;
      border-radius: 8px;
      border: 1px solid #333;
      background: #161b22;
      color: #fff;
    }

    button {
      padding: 0.7rem 1.5rem;
      background-color: #f9826c;
      color: white;
      border: none;
      border-radius: 8px;
      margin-left: 1rem;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background-color: #e76a5a;
    }

    .results {
      margin-top: 2rem;
      padding: 1.5rem;
      background-color: #161b22;
      border-radius: 10px;
      border: 1px solid #30363d;
      width: fit-content;
      margin-left: auto;
      margin-right: auto;
    }

    .results p {
      margin: 0.5rem 0;
    }

    .safe { color: #2ecc71; }
    .warning { color: #f1c40f; }
    .danger { color: #e74c3c; }
  </style>
</head>
<body>
  <h1>🔍 URL Scanner</h1>
  <form method="POST">
    <input type="text" name="url" placeholder="Enter URL (e.g., http://example.com)" required />
    <button type="submit">Scan</button>
  </form>

<?php
if (isset($_POST['url'])) {
    $userUrl = trim($_POST['url']);
    $encodedUrl = urlencode($userUrl);
    $apiKey = "caO1WQg7TMfHSdTymwM7Gr3Os830ErjR";
    $apiUrl = "https://www.ipqualityscore.com/api/json/url/$apiKey/$encodedUrl";

    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if ($data && isset($data['success']) && $data['success']) {
        echo "<div class='results'>";
        echo "<h2>🔎 Results for: " . htmlspecialchars($userUrl) . "</h2>";
        echo "<p><strong>Domain:</strong> " . $data['domain'] . "</p>";
        echo "<p><strong>Status Code:</strong> " . $data['status_code'] . "</p>";
        echo "<p><strong>Risk Score:</strong> " . $data['risk_score'] . " / 100</p>";
        echo "<p><strong>Malware:</strong> " . ($data['malware'] ? "<span class='danger'>Yes</span>" : "<span class='safe'>No</span>") . "</p>";
        echo "<p><strong>Phishing:</strong> " . ($data['phishing'] ? "<span class='danger'>Yes</span>" : "<span class='safe'>No</span>") . "</p>";
        echo "<p><strong>Suspicious:</strong> " . ($data['suspicious'] ? "<span class='warning'>Yes</span>" : "No") . "</p>";
        echo "<p><strong>Domain Age:</strong> " . $data['domain_age']['human'] . "</p>";
        echo "<p><strong>Server:</strong> " . $data['server'] . "</p>";
        echo "</div>";
    } else {
        echo "<p class='danger'>⚠️ Error scanning URL. Please check and try again.</p>";
    }
}
?>

</body>
</html>
