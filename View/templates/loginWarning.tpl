{extends file="main.tpl"}

{block name="title"}Avviso{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/errorMessage.css">
{/block} 

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card border-0 shadow-lg p-5 text-center">
            <div class="mb-4">
              <i class="bi bi-exclamation-triangle-fill error-icon"></i>
            </div>
            <h2 class="fw-bold text-dark mb-3">ATTENZIONE</h2>
            <p class="text-muted fs-5 mb-4">
              Per proseguire con questa operazione, &egrave; necessario registrarsi o effettuare il login come utenti volontari
            </p>
            
            <div class="row g-3 justify-content-center">
                <div class="col-md-6">
                    <a href="/auth/registrationForm" class="btn btn-home w-100 fw-bold py-3 shadow-sm">
                        REGISTRATI
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="/auth/loginForm" class="btn btn-home w-100 fw-bold py-3 shadow-sm">
                        LOGIN
                    </a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </main>
{/block}