{extends file="main.tpl"}

{block name="title"}Errore{/block}

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
            <h2 class="fw-bold text-dark mb-3">{$header}</h2>
            <p class="text-muted fs-5 mb-4">
              {$text}
            </p>
            
            <div class="d-grid gap-2 col-md-10 mx-auto">
              {if $isLogged}
                <a href="/account/personal/" class="btn btn-home fw-bold py-3 shadow-sm">
                  {if $isAdmin}
                    TORNA ALLA DASHBOARD
                  {else}
                    TORNA AL PROFILO
                  {/if}
                </a>
              {else}
                <a href="/" class="btn btn-home fw-bold py-3 shadow-sm">
                  TORNA ALLA HOME
                </a>
              {/if}
            </div>
          </div>
        </div>
      </div>
    </main>
{/block}