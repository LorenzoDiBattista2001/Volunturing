{extends file="main.tpl"}

{block name="title"}Logout{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/confirmationMessage.css">
{/block}  

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card border-0 shadow-lg p-5 text-center">
            <div class="mb-4">
              <i class="bi bi-check-circle-fill success-icon"></i>
            </div>
            <h2 class="fw-bold text-dark mb-3">{$header}</h2>
            <p class="text-muted fs-5 mb-4">{$text}</p>
            
            <div class="d-grid gap-2 col-md-8 mx-auto">
              <a href="/" class="btn btn-warning fw-bold py-3 shadow-sm">
                VAI ALLA HOME
              </a>
            </div>
          </div>
        </div>
      </div>
    </main>
{/block}