<?php

class settings_model extends model
{

	protected function init($params){

	}
	protected function createContent(){
		?>
			<div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px">
    <div class="w3-justify w3-border-bottom w3-padding-bottom">
      <h1>Benutzerdaten</h1>
      <form style="max-width:300px">
        <label>Email:</label>
        <input type="email" class="w3-border w3-input w3-margin-bottom" value="max.musterman@gmail.com">
        <label>Telefon:</label>
        <input type="text" class="w3-input w3-border" value="+41 77 888 11 22">
      </form>
    </div>

    <div class="w3-justify w3-border-bottom w3-padding-bottom">
      <h1>Benachrichtigungen</h1>
      <p class="w3-justify">Über welche Kommunikationsmittel möchten Sie die aktuellsten Miteilungen
        erhalten?</p>
      <form>
        <input type="checkbox" name="mobile" value=""> SMS<br>
        <input type="checkbox" name="email" value="" checked=""> Email<br>
      </form>
    </div>

    <div class="w3-justify w3-border-bottom w3-padding-bottom">
      <h1>Benachrichtigungsstufe</h1>
      <p>Welche Art von Mitteilungen möchten Sie erhalten?</p>
      <form>
        <input type="checkbox" name="less-notification" value="" checked=""> Relevante Mitteilungen<br>
        <input type="checkbox" name="no-notification" value=""> Keine Mitteilungen<br>
      </form>
    </div>
    <input type="submit" value="Einstellungen speichern" class="w3-btn w3-margin-top w3-blue w3-right">

  </div>
		<?php
	}


}
?>
