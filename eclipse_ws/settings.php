<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Settings</title>
</head>

<body>
  <div>
    <h1>Benutzerdaten</h1>
    <form>
      Email:<br>
      <input type="email" name="email" value=""><br>
      Telefon:<br>
      <input type="text" name="telefon" value=""><br>
      <button type="reset">Passwort ändern</button>
    </form>
  </div>

  <div>
    <h1>Notifications</h1>
    <p>Über welche Kommunikationsmittel möchten Sie die aktuellsten Miteilungen
      erhalten?</p>
    <form>
      <input type="checkbox" name="mobile" value=""> SMS<br>
      <input type="checkbox" name="email" value=""> Email<br>
      <input type="submit" value="Ändern!">
    </form>
  </div>

  <div>
    <h1>Notification Level</h1>
    <p>Welche Art von Mitteilungen möchten Sie erhalten?</p>
    <form>
      <input type="checkbox" name="less-notification" value=""> Relevante Mitteilungen<br>
      <input type="checkbox" name="no-notification" value="">Keine Mitteilungen<br>
      <input type="submit" value="Ändern!">
    </form>
  </div>


</body>

</html>
