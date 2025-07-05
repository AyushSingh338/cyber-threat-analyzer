<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Email Analyzer | Cyber Threat Analyzer</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #0d1117;
      color: #c9d1d9;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background-color: #161b22;
    }
    .container {
      max-width: 700px;
    }
    .form-control, .btn {
      border-radius: 8px;
    }
    textarea {
      resize: vertical;
      min-height: 150px;
      background-color: #161b22;
      color: #c9d1d9;
      border: 1px solid #30363d;
    }
    .btn-primary {
      background-color: #238636;
      border: none;
    }
    .btn-primary:hover {
      background-color: #2ea043;
    }
    .result-box {
      background-color: #161b22;
      border-left: 5px solid #238636;
      padding: 20px;
      margin-top: 25px;
      border-radius: 6px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }
    a {
      color: #58a6ff;
    }
    a:hover {
      text-decoration: underline;
    }
    footer {
      background-color: #161b22;
      color: #8b949e;
      text-align: center;
      padding: 2rem 1rem;
      font-size: 0.9rem;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.html">
      <i class="bi bi-shield-lock-fill me-2"></i>Cyber Threat Analyzer
    </a>
  </div>
</nav>

<!-- Page Content -->
<div class="container my-5">
  <h2 class="mb-4 text-center"><i class="bi bi-envelope-open me-2"></i>Email Analyzer</h2>

  <form method="POST">
    <div class="mb-3">
      <label for="emailContent" class="form-label">Paste Suspicious Email Content:</label>
      <textarea class="form-control" id="emailContent" name="email_content" placeholder="Paste email text here..." required><?php echo isset($_POST['email_content']) ? htmlspecialchars($_POST['email_content']) : ''; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary w-100">Analyze Email</button>
  </form>

  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_content'])) {
      $content = trim($_POST['email_content']);

      $phishing_keywords = [
        'urgent', 'verify your account', 'password expired',
        'click here', 'login immediately', 'reset your password',
        'account suspended', 'confirm billing', 'security alert'
      ];

      $detected = [];

      foreach ($phishing_keywords as $keyword) {
        if (stripos($content, $keyword) !== false) {
          $detected[] = $keyword;
        }
      }

      // Extract links
      preg_match_all('/https?:\/\/[^\s"]+/i', $content, $links_found);
      $links = $links_found[0];

      echo "<div class='result-box'>";
      echo "<h5>🧪 Analysis Summary:</h5>";
      echo "<ul>";
      echo "<li><strong>Phishing Keywords:</strong> " . (!empty($detected) ? implode(', ', $detected) : "<em>None detected</em>") . "</li>";
      echo "<li><strong>Number of Links:</strong> " . count($links) . "</li>";
      echo "</ul>";

      if (!empty($links)) {
        echo "<p><strong>🔗 Links Detected:</strong></p><ul>";
        foreach ($links as $link) {
          $safeLink = htmlspecialchars($link);
          echo "<li><a href='$safeLink' target='_blank'>$safeLink</a></li>";
        }
        echo "</ul>";
      }

      echo "<p class='mt-3 text-muted small'>* This scan is basic. For deep analysis, use advanced APIs (e.g., VirusTotal or IPQualityScore).</p>";
      echo "</div>";
    }
  ?>
</div>

<!-- Footer -->
<footer>
  <p>&copy; 2025 Cyber Threat Analyzer. All rights reserved.</p>
  <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a></p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
