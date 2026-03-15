{extends file="main.tpl"}

{block name="title"}Candidatura Confermata{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/confirmationMessage.css">
{/block}  



    
{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-7">
          <div class="card border-0 shadow-lg overflow-hidden">
            
            <div class="card-header card-header-custom p-4 text-center">
              <h2 class="h4 fw-bold mb-0 text-dark text-uppercase">Candidatura Inviata con Successo!</h2>
            </div>

            <div class="card-body p-4 p-md-5">
                  <div class="row g-3 justify-content-center">
                    <div class="col-md-8">
                      <p class="text-center lead">Monitora lo stato della tua candidatura dalla tua area personale</p>
                    </div>
                    <div class="action-divider">
                      <div class="col-md-8 text-center">
                        <a href="#" class="btn btn-link text-muted text-decoration-none small">
                          Visita la tua area personale
                        </a>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </main>
{/block}