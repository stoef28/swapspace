<?php

class dashboard_model extends model
{

	protected function init($params){

		$this->showChat();

		unset($_SESSION['employee_id']);

		$_SESSION['last_message_id'] = 0;
	}
	protected function createContent(){

		$dc_ide = $this->function_single->encrypt($this->session_single->getActiveUser()->getId(), 'damage_case_id');
		?>

			<div class="w3-half w3-left-align backgroundpic">
                <div class="w3-card-4 w3-margin" style="height:300px">
                    <div class="w3-container">
                        <h1>Willkommen auf Swap Space!</h1>
                        <p>Hier finden Sie alle Informationen auf einen Blick. <br>
							Wir wünschen Ihnen gute Besserung.</p>
                    </div>
                </div>
            </div>

            <div class="w3-half w3-left-align ">
                <div class="w3-card-4 w3-margin" style="min-height:300px">
                    <div class="w3-container ">
                        <h1>Wichtige Infos</h1>

                        <table class="w3-table w3-bordered">
                            <tr>
                                <th style="padding-left: 5px">Schaden-Nr.:</th>
                                <th>29/000001/17.9</th>
                            </tr>
                            <tr>
                                <th style="padding-left: 5px">Ansprechperson:</th>
                                <th>Michele Eichenberger</th>
                            </tr>
							<tr>
                                <th style="padding-left: 5px">Tel:</th>
                                <th>58 285 76 97</th>
                            </tr>
							<tr>
                                <th style="padding-left: 5px">E-Mail:</th>
                                <th>michele.eichenberger@baloise.ch</th>
                            </tr>
                            <tr>
                                <th style="padding-left: 5px">Status:</th>
                                <th>Abklärung Sachverhalt</th>
                            </tr>
							<tr>
                                <th style="padding-left: 5px">Leistungsübersicht:</th>
                                <th>Sehe "Meine Dokumente"</th>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>

            <div class="w3-half w3-left-align">
                <div class="w3-card-4 w3-margin" style="height:300px">
                    <div class="w3-container">
                        <h1>Pendenzen</h1>
                        <p>- Ärztliches Zeugnis einreichen</p>

                        <!--<a href="survey&survey_ide=7i9dgLBgDP6KUYwj0pgFPQosqtjM04CgFcKpITfTQPg-">Zur Umfrage</a>-->

                    </div>
                </div>
            </div>

            <div class="w3-half w3-left-align ">
                <div class="w3-card-4 w3-justify  w3-margin" style="min-height:300px">
                    <div class="w3-container">
                        <h1>Status</h1>
                        <h3>Abklärung Sachverhalt</h3>
                        <p>Wir sind daran Ihren Fall zu bearbeiten. Es ist uns ein Anliegen, Sie hilfreich zu unterstützen und die Bearbeitung Ihres Falls so unkompliziert wie möglich zu gestalten. Zu diesem Zweck möchten wir uns zunächst ein genaues Bild über die vorliegende Situation machen, wozu wir noch einige Angaben von Ihnen benötigen.

							<br>Vielen Dank für Ihre Unterstützung.<br>

                        <a href="status_overview"> weitere infos</a></p>
                    </div>
                </div>
            </div>
            <div class="w3-half w3-left-align">
                <div class="w3-card-4 w3-margin" style="height:300px">
                    <div class="w3-container w3-row">
                        <div class="w3-col s12 l8 m12" >
                            <h1 class="" style="display: inline-block">Meine Dokumente</h1>
                        </div>
                        <div class="w3-col s12 l4 m12">
                            <button class="w3-btn w3-blue w3-right w3-margin-top" style="width:100%" type="button" name="Upload">Upload</button>
                        </div>

                    </div>
                    <div class="w3-container" style="">
                        <div class="w3-margin-top w3-border" style="overflow:auto; max-height:155px">

                        <table class="w3-striped w3-table w3-bordered">
                            <tr>
                                <td><i class="fa fa-file-pdf-o fa-lg w3-margin-right" ></i>Leistungsübersicht.pdf</td>
                            </tr>

                            <tr>
                                <td><i class="fa fa-file-image-o fa-lg w3-margin-right" ></i>Unfallbild_1.jpg</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-file-image-o fa-lg w3-margin-right" ></i>Unfallbild_2.jpg</td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>





			<div class="w3-half w3-left-align">
				<div class="w3-card-4 w3-margin" style="height:300px">
					<div class="w3-container">

						<img class="w3-image w3-center w3-content" src="pics/Banner.png" alt="" style="height:300px">

					</div>
				</div>
			</div>





		<?php

	}


}
?>
