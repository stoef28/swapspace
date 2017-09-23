<?php

class status_overview_model extends model
{
	
	protected function init($params){
		
	}
	protected function createContent(){
		?>
		
			<div class="w3-justify">
      <h1 class="w3-border-bottom">Statusübersicht</h1>
      <div class="panel-body">
        <ul class="timeline">
          <li>
            <div class="timeline-badge primary" style="z-index:0"><i class="fa fa-edit"></i>
            </div>
            <div class="timeline-panel" style="z-index:-1">
              <div class="timeline-heading">
                <h4 class="timeline-title">Fall eröffnet</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero laboriosam dolor perspiciatis omnis exercitationem. Beatae, officia pariatur? Est cum veniam excepturi. Maiores praesentium, porro voluptas suscipit facere rem dicta, debitis.</p>
              </div>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge warning" style="z-index:0"><i class="fa fa-legal"></i>
            </div>
            <div class="timeline-panel" style="z-index:-1">
              <div class="timeline-heading">
                <h4 class="timeline-title">Abklärung Sachverhalt</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolorem quibusdam, tenetur commodi provident cumque magni voluptatem libero, quis rerum. Fugiat esse debitis optio, tempore. Animi officiis alias, officia repellendus.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium maiores odit qui est tempora eos, nostrum provident explicabo dignissimos debitis vel! Adipisci eius voluptates, ad aut recusandae minus eaque facere.</p>
              </div>
            </div>
          </li>
          <li>
            <div class="timeline-badge danger" style="z-index:0"><i class="fa fa-medkit"></i>
            </div>
            <div class="timeline-panel" style="z-index:-1">
              <div class="timeline-heading">
                <h4 class="timeline-title">Medizinische Abklärung</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus numquam facilis enim eaque, tenetur nam id qui vel velit similique nihil iure molestias aliquam, voluptatem totam quaerat, magni commodi quisquam.</p>
              </div>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge success" style="z-index:0"><i class="fa fa-credit-card"></i>
            </div>
            <div class="timeline-panel" style="z-index:-1">
              <div class="timeline-heading">
                <h4 class="timeline-title">Kostengutsprache erfolgt</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates est quaerat asperiores sapiente, eligendi, nihil. Itaque quos, alias sapiente rerum quas odit! Aperiam officiis quidem delectus libero, omnis ut debitis!</p>
              </div>
            </div>
          </li>
          <li>
            <div class="timeline-badge info" style="z-index:0"><i class="fa fa-trophy"></i>
            </div>
            <div class="timeline-panel" style="z-index:-1">
              <div class="timeline-heading">
                <h4 class="timeline-title">Leistungserbringung</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis minus modi quam ipsum alias at est molestiae excepturi delectus nesciunt, quibusdam debitis amet, beatae consequuntur impedit nulla qui! Laborum, atque.</p>
              </div>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge success" style="z-index:0"><i class="fa fa-check"></i>
            </div>
            <div class="timeline-panel" style="z-index:-1">
              <div class="timeline-heading">
                <h4 class="timeline-title">Fall abgeschlossen</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt obcaecati, quaerat tempore officia voluptas debitis consectetur culpa amet, accusamus dolorum fugiat, animi dicta aperiam, enim incidunt quisquam maxime neque eaque.</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
		<?php 
		
	}
	
	
}
?>