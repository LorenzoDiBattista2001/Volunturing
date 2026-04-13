{extends file="main.tpl"}

{block name="title"}Volunturing - Gestione Utenti{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/volunteersList.css"/>
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-white p-4 border-0">
              <h5 class="fw-bold mb-0">Elenco Utenti Registrati</h5>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                      <th class="ps-4 py-3">Volontario</th>
                      <th>Contatti</th>
                      <th class="text-center">Stato</th>
                      <th class="pe-4 text-end no-print">Profilo</th>
                    </tr>
                  </thead>
                  <tbody>
                  {foreach $registeredUsers as $user}
                    <tr class="app-row">
                      <td class="ps-4 py-3">
                        <div class="d-flex align-items-center">
                          <div class="avatar-circle">{$user->getInitials()}</div>
                          <div>
                            <div class="fw-bold">{$user->getFirstName()} {$user->getLastName()}</div>
                            <div class="small text-muted text-truncate" style="max-width: 150px;">Et&agrave;: {$user->calculateAge()}</div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="small"><i class="bi bi-envelope me-2"></i>{$user->getEmail()}</div>
                        <div class="small"><i class="bi bi-telephone me-2"></i>+{$user->getTelephoneNumber()}</div>
                      </td>
                      <td class="text-center">{if $user->isBlocked()}Bloccato{else}Attivo{/if}</td>
                      <td class="pe-4 text-end no-print">
                        <a href="/admin/users/select/{$user->getUserId()}" class="btn btn-light btn-sm border">
                          <i class="bi bi-eye"></i>
                        </a>
                      </td>
                    </tr>
                  {/foreach}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
{/block}