<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Getting user input and putting it in a variable
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Hashing the password and putting it in a variable
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  // Prepare the SQL statement
  $stmt = $db->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");

  // Bind the variables to SQL parameters and declare which data type they are
  $stmt->bindParam(':email', $email, SQLITE3_TEXT);
  $stmt->bindParam(':password', $hashedPassword, SQLITE3_TEXT);

  // Turn off displaying errors
  ini_set('display_errors', 0);

  // Execute the SQL statement
  $result = $stmt->execute();

  // Turn on displaying errors (optional, but good practice to restore the default behavior)
  ini_set('display_errors', 1);

  if ($result) {
      // Handle successful insertion
      echo "User registered successfully!";
  } else {
      // Check if the error code corresponds to a unique constraint violation
      $errorCode = $db->lastErrorCode();
      
      if ($errorCode == 19) {
          echo "Email address already exists. <Br> Login or choose a different email.";
      } else {
          // Handle other database errors
          echo "Error: " . $db->lastErrorMsg();
      }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournoi</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <form method="post">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" require>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" require>
      <button type="submit">register</button>
      <button type="submit">login</button>
    </form>
    <div class="intro bg-blur">
      <h1 style="text-align:center;">[ Welcome to Tournoi ]</h1>
      <p style="text-align:center;">#️⃣ 🎠 🔃 🉐 👍 🎎 🐙 👐 🏥 🎋 🔗 ⚖ ❄️</p>
      <p>Cette application web sert a créer des tournois ou les participants on le droit de:</p>
      <ul>
        <li>S&#39;inscrire</li>
        <li>Se connecter</li>
        <li>Créer &amp; modifier des tournois.</li>
      </ul>
      <p>(Ceci est la liste complete des fonctionnalités du site.)</p>
      <p>
        C&#39;est un projet scolaire qui nous servira a apprendre les bases du développement web, sachant que nous n&#39;avons accès ni au libraries/framework ou Javascript!!!!!!
      </p>
      <p>Teste l'application maintenant en créent un compte ou en te connectant</p>
      <p>fuck school</p>
    </div>
  </main>
  <footer>
  <p>Une creation de <a href="https://github.com/pindjouf"><b>@pindjouf</b></a> & <a href="http://github.com/princeofthelord"><b>@princeofthelord</b></a>.</p>
  </footer>
</body>
</html>
