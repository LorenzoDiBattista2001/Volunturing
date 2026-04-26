<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}Volunturing{/block}</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {block name="head"}{/block}
  </head>
  <body class="bg-light d-flex flex-column min-vh-100">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm" style="background-color: #ff9411;">
      <div class="container">
        <a href="#" class="navbar-brand fw-bold fs-3 d-flex align-items-center">
          <i class="bi bi-megaphone-fill me-2"></i> Volunturing
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav mx-auto gap-2 fw-semibold">
            {if $isLogged}
            <li class="nav-item"><a class="nav-link" href="/">HOME</a></li>
            <li class="nav-item"><a class="nav-link" href="/events/explore">EVENTI</a></li>
            <li class="nav-item"><a class="nav-link" href="/about/contacts">CONTATTI</a></li>
            <li class="nav-item"><a class="nav-link" href="/donation/start">DONA ORA</a></li>
            {else}
            <li class="nav-item"><a class="nav-link" href="/">HOME</a></li>
            <li class="nav-item"><a class="nav-link" href="#">ABOUT</a></li>
            <li class="nav-item"><a class="nav-link" href="/about/contacts">CONTATTI</a></li>
            {/if}
          </ul>
          <div class="d-flex gap-2">
            {if $isLogged}
            <a href="/account/personal" class="btn btn-outline-light btn-sm">PROFILO</a>
            <a href="/auth/logout" class="btn btn-light btn-sm fw-bold">LOGOUT</a>
            {else}
            <a href="/auth/registrationForm" class="btn btn-outline-light btn-sm">REGISTRATI</a>
            <a href="/auth/loginForm" class="btn btn-light btn-sm fw-bold">LOGIN</a>
            {/if}
          </div>
        </div>
      </div>
    </nav>

    <div class="d-flex mt-5">
      <div id="cookie-alert" class="alert alert-danger d-none w-75 mx-auto" role="alert">
        <h4 class="alert-heading text-center">ATTENZIONE</h4>
        <p class="text-center">I cookie del Browser sono disattivati. Perch&eacute; l'applicazione funzioni correttamente, &egrave; necessario abilitarli.</p>
      </div>
    </div>

    <noscript>
      <div class="alert alert-danger w-75 mx-auto" role="alert">
        <h4 class="alert-heading text-center">ATTENZIONE</h4>
        <p class="text-center">L'uso di JavaScript &egrave; disabilitato. Perché l'applicazione funzioni correttamente, assicurarsi di abilitare JavaScript e i cookie del Browser.</p>
      </div>
    </noscript>

    {block name="body"}{/block}

    <!-- FOOTER -->
    <footer class="bg-dark text-white py-5 mt-5">
      <div class="container">
        <div class="row g-4">
          <div class="col-md-6 text-center text-md-start">
            <h5 class="fw-bold mb-3 text-warning">Volunturing</h5>
            <p class="small text-light mb-0">&copy; 2025 Volontorino - Tutti i diritti riservati.</p>
          </div>
          <div class="col-md-6 text-center text-md-end">
            <p class="mb-2"><i class="bi bi-geo-alt-fill text-warning me-2"></i> Via dei Volontari, 123 - Torino</p>
            <div class="d-flex justify-content-center justify-content-md-end gap-3 mt-3">
              <a href="#" class="text-white fs-4"><i class="bi bi-facebook"></i></a>
              <a href="#" class="text-white fs-4"><i class="bi bi-instagram"></i></a>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{$js_path}/checkCookies.js"></script>
    {block name="script"}{/block}
  </body>
</html>